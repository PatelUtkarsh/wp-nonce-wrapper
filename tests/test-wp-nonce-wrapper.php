<?php

use spock\helper\Nonce_Wrapper;
use Brain\Monkey;
use Brain\Monkey\Functions;


class test_nonce_wrapper extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		parent::setUp();
		Monkey::setUpWP();
	}

	protected function tearDown() {
		Monkey::setUpWP();
		parent::tearDown();
	}

	function test_nonce_create_verify() {
		//Setup
		Functions::expect( 'wp_create_nonce' )
		         ->once()
		         ->with( 'doing_create_and_verfiy_test' )
		         ->andReturn( 'abc3ae7245' );
		Functions::expect( 'wp_verify_nonce' )
		         ->once()
		         ->with( 'abc3ae7245', 'doing_create_and_verfiy_test' )
		         ->andReturn( 1 );
		Functions::expect( 'wp_verify_nonce' )
		         ->once()
		         ->with( 'abc3ae7245_wrong', 'doing_create_and_verfiy_test' )
		         ->andReturn( false );

		//Act
		$nonce         = new Nonce_Wrapper( 'doing_create_and_verfiy_test' );
		$nonce_val     = $nonce->create_nonce();
		$none_accepted = $nonce->verify_nonce( $nonce_val );
		$none_rejected = $nonce->verify_nonce( $nonce_val . '_wrong' );

		//Verify
		$this->assertEquals( $none_accepted, 1 );
		$this->assertFalse( $none_rejected, 0 );
	}

	function test_create_nonce_field() {
		//setup
		Functions::expect( 'wp_verify_nonce' )
		         ->once()
		         ->with( 'abc3aclean', 'clean_field' )
		         ->andReturn( 1 );
		Functions::expect( 'wp_nonce_field' )
		         ->once()
		         ->with( 'clean_field', '_wpnonce', false, false )
		         ->andReturn( '<input type="hidden" id="_wpnonce" name="_wpnonce" value="abc3aclean" />' );

		//Act
		$nonce            = new Nonce_Wrapper( 'clean_field' );
		$html_input_field = $nonce->create_nonce_field( '_wpnonce', false, false );
		$dom              = new DOMDocument();
		$dom->loadHTML( $html_input_field );
		$inputs    = $dom->getElementsByTagName( 'input' )->item( 0 );
		$nonce_val = $inputs->getAttribute( 'value' );

		//Verify
		$this->assertEquals( $nonce->verify_nonce( $nonce_val ), 1 );
	}

	function test_create_nonce_url() {
		//Setup
		Functions::expect( 'wp_nonce_url' )
		         ->once()
		         ->with( 'http://w.org', 'clean_url', '_wpnonce' )
		         ->andReturn( 'http://w.org?_wpnonce=ad4g4dclean' );
		Functions::expect( 'wp_verify_nonce' )
		         ->once()
		         ->with( 'ad4g4dclean', 'clean_url' )
		         ->andReturn( 1 );

		//Act
		// get url with nonce field
		$nonce = new Nonce_Wrapper( 'clean_url' );
		$url   = $nonce->create_nonce_url( "http://w.org" );
		$query = parse_url( $url );
		$q     = array( '_wpnonce' );
		parse_str( $query['query'], $q );

		//verify
		$this->assertEquals( $nonce->verify_nonce( str_replace( '"', '', $q['_wpnonce'] ) ), 1 );
	}

	function test_check_admin_referral() {
		//Setup
		Functions::expect( 'wp_create_nonce' )
		         ->once()
		         ->with( 'doing_some_admin_job' )
		         ->andReturn( 'abged45fg' );
		Functions::expect( 'check_admin_referer' )
		         ->once()
		         ->with( 'doing_some_admin_job', '_wpnonce' )
		         ->andReturn( 1 );

		//Act
		$nonce                = new Nonce_Wrapper( 'doing_some_admin_job' );
		$nonce_val            = $nonce->create_nonce();
		$_REQUEST['_wpnonce'] = $nonce_val;

		//Verify
		$this->assertEquals( $nonce->check_admin_referral(), 1 );
	}
}
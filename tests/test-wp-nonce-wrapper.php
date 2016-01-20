<?php

class test_wp_nonce_wrapper extends WP_UnitTestCase {

	var $instance;

	/**
	 * test_wp_nonce_wrapper constructor.
	 * Initialize Wp_Nonce_Wrapper
	 */
	public function __construct() {
		$this->instance = Wp_Nonce_Wrapper::getInstance();
	}

	function test_nonce_non_logged_in() {
		// replace this with some actual testing code
		$nonce = $this->instance->create_nonce( "doing_some_form_job" );
		$this->assertEquals( $this->instance->verify_nonce( $nonce, "doing_some_form_job" ), 1 );
		$this->assertNotEquals( $this->instance->verify_nonce( $nonce . 'd', "doing_some_form_job" ), 1 );
	}

	function test_nonce_logged_in() {
		//set admin as a user
		wp_set_current_user( 1 );
		$nonce = $this->instance->create_nonce( "some_awesome_action" );
		// verify nonce
		$this->assertEquals( $this->instance->verify_nonce( $nonce, "some_awesome_action" ), 1 );

		// check if wrong nonce inserted
		$this->assertNotEquals( $this->instance->verify_nonce( $nonce . 'd', "some_awesome_action" ), 1 );
	}

	function test_create_nonce_field() {
		//get html field
		$html_input_field = $this->instance->create_nonce_field( 'clean_field', '_wpnonce', true, false );
		$dom              = new DOMDocument();
		//Load html field to get value from it.
		$dom->loadHTML( $html_input_field );
		$inputs = $dom->getElementsByTagName( 'input' );
		if ( ! empty( $inputs[0] ) ) {
			$nonce = $inputs[0]->getAttribute( 'value' );
			//verify
			$this->assertEquals( $this->instance->verify_nonce( $nonce, 'clean_field' ), 1 );
		}
	}

	function test_create_nonce_url() {
		// get url with nonce field
		$url   = $this->instance->create_nonce_url( "http://w.org", 'clean_url' );
		$query = parse_url( $url );
		$query = $query['query'];
		// parse url and get query from it and extract nonce
		$nonce = substr( $query, ( strpos( $query, '=' ) + 1 ) );
		//verify nonce
		$this->assertEquals( $this->instance->verify_nonce( $nonce, 'clean_url' ), 1 );
	}

	function test_check_admin_referral() {
		$nonce                = $this->instance->create_nonce( "doing_some_admin_job" );
		$_REQUEST['_wpnonce'] = $nonce;
		//check admin referral for verifying nonce
		$this->assertEquals( $this->instance->check_admin_referral( 'doing_some_admin_job' ), 1 );
	}
}
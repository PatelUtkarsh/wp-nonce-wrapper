<?php

class test_wp_nonce_wrapper extends WP_UnitTestCase {

	var $instance;

	/**
	 * test_wp_nonce_wrapper constructor.
	 */
	public function __construct() {
		$this->instance = Wp_Nonce_Wrapper::getInstance();
	}

	function test_nonce_non_logged_in() {
		// replace this with some actual testing code
		$nonce = $this->instance->create_nonce( "doing_some_form_job" );
		$this->assertEquals( $this->instance->verify_nonce( $nonce, "doing_some_form_job" ), 1 );
	}

	function test_nonce_logged_in(){
		wp_set_current_user( 1 );
		$nonce = $this->instance->create_nonce( "some_awesome_action" );
		$this->assertEquals( $this->instance->verify_nonce( $nonce, "some_awesome_action" ), 1 );
	}
}
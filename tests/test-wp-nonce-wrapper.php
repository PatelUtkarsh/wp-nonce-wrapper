<?php

class test_wp_nonce_wrapper extends WP_UnitTestCase {

	/**
	 * test_wp_nonce_wrapper constructor.
	 */
	public function __construct() {
	}

	function test_nonce_non_logged_in() {
	}

	function test_nonce_logged_in(){
		wp_set_current_user( 1 );
	}
}
<?php

if ( ! class_exists( 'Wp_Nonce_Wrapper' ) ) :
	/**
	 * Class Wp_Nonce_Wrapper
	 */
	class Wp_Nonce_Wrapper {

		/**
		 * @var Wp_Nonce_Wrapper The reference to *Singleton* instance of this class
		 */
		private static $instance;

		/**
		 * Wp_Nonce_Wrapper constructor.
		 */
		protected function __construct() {

		}

		/**
		 * Returns the *Singleton* instance of this class.
		 *
		 * @return Wp_Nonce_Wrapper The *Singleton* instance.
		 */
		public static function getInstance() {
			if ( null === static::$instance ) {
				static::$instance = new static();
			}

			return static::$instance;
		}

		/**
		 * Private clone method to prevent cloning of the instance of the
		 * *Singleton* instance.
		 *
		 * @return void
		 */
		private function __clone() {
		}

		/**
		 * Private unserialize method to prevent unserializing of the *Singleton*
		 * instance.
		 *
		 * @return void
		 */
		private function __wakeup() {
		}

		/**
		 * Create nonce
		 *
		 * @param int|String $action Action name. Should give the context to what is taking place. Optional
		 *
		 * @return string
		 */
		public function create_nonce( $action = - 1 ) {
			return wp_create_nonce( $action );
		}

		/**
		 * Verify nonce
		 *
		 * @param String $nonce Nonce to verify.
		 * @param int $action Action name. Should give the context to what is taking place. Optional
		 *
		 * @return false|int
		 */
		public function verify_nonce( $nonce, $action = - 1 ) {
			return wp_verify_nonce( $nonce, $action );
		}

	}
endif;
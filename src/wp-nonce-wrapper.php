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

		/**
		 * Create nonce field
		 *
		 * @param int|string $action Optional. Action name. Default -1.
		 * @param string $name Optional. Nonce name. Default '_wpnonce'.
		 * @param bool $referer Optional. Whether to set the referer field for validation. Default true.
		 * @param bool $echo Optional. Whether to display or return hidden form field. Default true.
		 *
		 * @return string Nonce field HTML markup.
		 */
		public function create_nonce_field( $action = - 1, $name = "_wpnonce", $referer = true, $echo = true ) {
			return wp_nonce_field( $action, $name, $referer, $echo );
		}

		/**
		 * Get nonce url
		 *
		 * @param string $actionurl URL to add nonce action.
		 * @param int|string $action Optional. Nonce action name. Default -1.
		 * @param string $name Optional. Nonce name. Default '_wpnonce'.
		 *
		 * @return string Escaped URL with nonce action added.
		 */
		public function create_nonce_url( $actionurl, $action = - 1, $name = '_wpnonce' ) {
			return wp_nonce_url( $actionurl, $action, $name );
		}

		/**
		 * Check admin referral
		 *
		 * @param int|string $action Action nonce.
		 * @param string $query_arg Optional. Key to check for nonce in `$_REQUEST` (since 2.5).
		 *                              Default '_wpnonce'.
		 *
		 * @return false|int False if the nonce is invalid, 1 if the nonce is valid and generated between
		 *                   0-12 hours ago, 2 if the nonce is valid and generated between 12-24 hours ago.
		 */
		public function check_admin_referral( $action = - 1, $query_arg = '_wpnonce' ) {
			return check_admin_referer( $action, $query_arg );
		}

	}
endif;
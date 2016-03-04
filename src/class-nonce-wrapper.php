<?php

namespace spock\helper;

if ( ! class_exists( 'Nonce_Wrapper' ) ) :
	/**
	 * Class Nonce_Wrapper
	 */
	class Nonce_Wrapper {

		/**
		 * @var Nonce_Wrapper Action that is being performed.
		 */
		private $action;

		/**
		 * Nonce_Wrapper constructor.
		 *
		 * @param int|string $action
		 */
		function __construct( $action = - 1 ) {
			$this->action = $action;
		}

		/**
		 * Returns the *Singleton* instance of this class.
		 *
		 * @return Nonce_Wrapper The *Singleton* instance.
		 */
		public static function getInstance() {
			return new self();
		}

		/**
		 * Create nonce
		 * @return string
		 *
		 */
		public function create_nonce() {
			return \wp_create_nonce( $this->action );
		}

		/**
		 * Verify nonce
		 *
		 * @param String $nonce Nonce to verify.
		 *
		 * @return false|int
		 */
		public function verify_nonce( $nonce ) {
			return \wp_verify_nonce( $nonce, $this->action );
		}

		/**
		 * Create nonce field
		 *
		 * @param string $name Optional. Nonce name. Default '_wpnonce'.
		 * @param bool $referer Optional. Whether to set the referer field for validation. Default true.
		 * @param bool $echo Optional. Whether to display or return hidden form field. Default true.
		 *
		 * @return string Nonce field HTML markup.
		 */
		public function create_nonce_field( $name = '_wpnonce', $referer = true, $echo = true ) {
			return \wp_nonce_field( $this->action, $name, $referer, $echo );
		}

		/**
		 * Get nonce url
		 *
		 * @param string $actionurl URL to add nonce action.
		 * @param string $name Optional. Nonce name. Default '_wpnonce'.
		 *
		 * @return string Escaped URL with nonce action added.
		 */
		public function create_nonce_url( $actionurl, $name = '_wpnonce' ) {
			return \wp_nonce_url( $actionurl, $this->action, $name );
		}

		/**
		 * Check user is coming from another admin page
		 *
		 * @param string $query_arg Optional. Key to check for nonce in `$_REQUEST`.
		 *                              Default '_wpnonce'.
		 *
		 * @return false|int False if the nonce is invalid, 1 if the nonce is valid and generated between
		 *                   0-12 hours ago, 2 if the nonce is valid and generated between 12-24 hours ago.
		 */
		public function check_admin_referral( $query_arg = '_wpnonce' ) {
			return \check_admin_referer( $this->action, $query_arg );
		}

		/**
		 * Check ajax referer
		 *
		 * @param bool $query_arg
		 * @param bool $die
		 *
		 * @return false|int
		 */
		public function check_ajax_referer( $query_arg = false, $die = true ) {
			return \check_ajax_referer( $this->action, $query_arg, $die );
		}

		/**
		 * Display 'Are You Sure' message to confirm the action being taken.
		 *
		 * @param $action
		 */
		public function nonce_ays( $action ) {
			\wp_nonce_ays( $action );
		}

	}
endif;
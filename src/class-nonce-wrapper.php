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

		private $expire;

		/**
		 * Nonce_Wrapper constructor.
		 *
		 * @param int|string $action
		 * @param int $expire Life of nonce in second, default seconds in one day
		 */
		function __construct( $action = - 1, $expire = 86400 ) {
			$this->action = $action;
			$this->expire = $expire;
		}

		/**
		 *
		 * @param $expire
		 *
		 * @return int
		 */
		function set_expire( $expire ) {
			return $this->expire;
		}

		/**
		 * Create nonce
		 * @return string
		 *
		 */
		protected function create_nonce() {
			return \wp_create_nonce( $this->action );
		}

		public function __call( $name, $arguments ) {
			if ( method_exists( $this, $name ) ) {
				add_filter( 'nonce_life', array( $this, 'set_expire' ), 1 );
				$return = call_user_func_array( array( $this, $name ), $arguments );
				remove_filter( 'nonce_life', array( $this, 'set_expire' ), 1 );

				return $return;
			}
		}


		/**
		 * Verify nonce
		 *
		 * @param String $nonce Nonce to verify.
		 *
		 * @return false|int
		 */
		protected function verify_nonce( $nonce ) {
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
		protected function create_nonce_field( $name = '_wpnonce', $referer = true, $echo = true ) {
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
		protected function create_nonce_url( $actionurl, $name = '_wpnonce' ) {
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
		protected function check_admin_referral( $query_arg = '_wpnonce' ) {
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
		protected function check_ajax_referer( $query_arg = false, $die = true ) {
			return \check_ajax_referer( $this->action, $query_arg, $die );
		}

		/**
		 * Display 'Are You Sure' message to confirm the action being taken.
		 *
		 * @param $action
		 */
		protected function nonce_ays( $action ) {
			\wp_nonce_ays( $action );
		}

		/**
		 * Get the time-dependent variable for nonce creation.
		 * @return integer
		 */
		protected function nonce_tick() {
			return wp_nonce_tick();
		}

	}
endif;
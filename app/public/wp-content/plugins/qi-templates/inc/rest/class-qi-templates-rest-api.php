<?php

if ( ! class_exists( 'Qi_Templates_Rest_API' ) ) {
	/**
	 * Rest API class with configuration
	 */
	class Qi_Templates_Rest_API {
		private static $instance;
		private $namespace;

		public function __construct() {
			// Init variables
			$this->set_namespace( 'qi-templates/v1' );

			// Localize theme's main js script with rest variable
			add_filter( 'qi_templates_filter_localize_admin_js', array( $this, 'localize_script' ) );

			// Function that register Rest API routes
			add_action( 'rest_api_init', array( $this, 'register_rest_api_route' ) );
		}

		/**
		 * @return Qi_Templates_Rest_API
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function get_namespace() {
			return $this->namespace;
		}

		public function set_namespace( $namespace ) {
			$this->namespace = $namespace;
		}

		function localize_script( $global ) {
			if ( isset( $_GET['page'] ) && Qi_Templates_Admin_Page_Registration::get_instance()->get_menu_slug() === $_GET['page'] ) {
				$global['restUrl']   = esc_url_raw( rest_url() );
				$global['restNonce'] = wp_create_nonce( 'wp_rest' );
			}

			return apply_filters( 'qi_templates_filter_rest_api_global_variables', $global, $this->get_namespace() );
		}

		function register_rest_api_route() {
			$routes = apply_filters( 'qi_templates_filter_rest_api_routes', array() );

			if ( ! empty( $routes ) ) {
				foreach ( $routes as $route ) {
					$permission_callback = isset( $route['permission_callback'] ) && ! empty( $route['permission_callback'] ) ? $route['permission_callback'] : '__return_true';

					register_rest_route(
						$this->get_namespace(),
						esc_attr( $route['route'] ),
						array(
							'methods'             => $route['methods'],
							'callback'            => $route['callback'],
							'permission_callback' => $permission_callback,
							'args'                => $route['args'],
						)
					);
				}
			}
		}
	}

	Qi_Templates_Rest_API::get_instance();
}

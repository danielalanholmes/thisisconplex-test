<?php

if ( ! function_exists( 'qi_templates_add_registration_sub_page_to_list' ) ) {
	/**
	 * Function that add additional sub page item into general page list
	 *
	 * @param array $sub_pages
	 *
	 * @return array
	 */
	function qi_templates_add_registration_sub_page_to_list( $sub_pages ) {
		$sub_pages[] = 'Qi_Templates_Admin_Page_Registration';

		return $sub_pages;
	}

	add_filter( 'qi_templates_filter_add_sub_page', 'qi_templates_add_registration_sub_page_to_list' );
}

if ( class_exists( 'Qi_Templates_Admin_Sub_Pages' ) ) {
	class Qi_Templates_Admin_Page_Registration extends Qi_Templates_Admin_Sub_Pages {
		private static $instance;

		public function __construct() {

			parent::__construct();

			add_action(
				'wp_ajax_qi_templates_register_plugin',
				array(
					$this,
					'activate_license',
				)
			);

			add_action(
				'wp_ajax_qi_templates_deregister_plugin',
				array(
					$this,
					'deactivate_license',
				)
			);
		}

		/**
		 * @return Qi_Templates_Admin_Page_Registration
		 */
		public static function get_instance() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function add_sub_page() {
			$this->set_base( 'registration' );
			$this->set_menu_slug( 'qi_templates_registration' );
			$this->set_title( esc_html__( 'Registration Page', 'qi-templates' ) );
			$this->set_position( 3 );
			$this->set_atts( $this->set_atributtes() );
		}

		function set_atributtes() {

			$license_key    = qi_templates_get_license();
			$license_active = qi_templates_is_plugin_activated();

			if ( ! empty( $license_key ) ) {
				$license_key = str_repeat( '*', strlen( $license_key ) - 4 ) . substr( $license_key, - 4 );
			}

			$button_text  = ! $license_active ? esc_html__( 'Register', 'qi-templates' ) : esc_html__( 'Deregister', 'qi-templates' );
			$button_class = ! $license_active ? 'qodef-register-plugin' : 'qodef-deregister-plugin';
			$button_name  = ! $license_active ? 'qodef_register_plugin' : 'qodef_deregister_plugin';
			$action_name  = ! $license_active ? 'qi_templates_register_plugin' : 'qi_templates_deregister_plugin';

			$atts = array(
				'license_key'  => $license_key,
				'button_text'  => $button_text,
				'button_class' => $button_class,
				'button_name'  => $button_name,
				'action_name'  => $action_name,
			);

			return $atts;
		}

		function activate_license() {

			if ( ! current_user_can( 'edit_theme_options' ) ) {
				return; // get out if we didn't click the Activate button
			}

			// run a quick security check
			if ( ! check_admin_referer( 'qi_templates_registration_nonce', 'qi_templates_registration_nonce' ) ) {
				return; // get out if we didn't click the Activate button
			}

			// retrieve the license from the database
			$license = trim( get_option( QI_TEMPLATES_LICENSE_OPTION_NAME ) );

			if ( ! $license ) {
				$license = filter_input( INPUT_POST, QI_TEMPLATES_LICENSE_OPTION_NAME, FILTER_SANITIZE_STRING );
			}

			if ( ! $license ) {
				return;
			}

			// data to send in our API request
			$api_params = array(
				'edd_action'  => 'activate_license',
				'license'     => $license,
				'item_id'     => QI_TEMPLATES_ITEM_ID,
				'item_name'   => rawurlencode( QI_TEMPLATES_ITEM_NAME ),
				'url'         => home_url(),
				'environment' => function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production',
			);

			// Call the custom API.
			$response = wp_remote_post(
				QI_TEMPLATES_STORE_URL,
				array(
					'timeout'   => 15,
					'sslverify' => false,
					'body'      => $api_params,
				)
			);

			// make sure the response came back okay
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				} else {
					$message = esc_html__( 'An error occurred, please try again.', 'qi-templates' );
				}
			} else {
				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				if ( false === $license_data->success ) {

					switch ( $license_data->error ) {
						case 'expired':
							$message = sprintf(
							/* translators: the license key expiration date */
								esc_html__( 'Your license key expired on %s.', 'qi-templates' ),
								date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
							);
							break;

						case 'disabled':
						case 'revoked':
							$message = esc_html__( 'Your license key has been disabled.', 'qi-templates' );
							break;

						case 'missing':
							$message = esc_html__( 'Invalid license.', 'qi-templates' );
							break;

						case 'invalid':
						case 'site_inactive':
							$message = esc_html__( 'Your license is not active for this URL.', 'qi-templates' );
							break;

						case 'item_name_mismatch':
							/* translators: the plugin name */
							$message = sprintf( esc_html__( 'This appears to be an invalid license key for %s.', 'qi-templates' ), QI_TEMPLATES_ITEM_NAME );
							break;

						case 'no_activations_left':
							$message = esc_html__( 'Your license key has reached its activation limit.', 'qi-templates' );
							break;

						default:
							$message = esc_html__( 'An error occurred, please try again.', 'qi-templates' );
							break;
					}
				}
			}

			// $license_data->license will be either "valid" or "invalid"
			update_option( QI_TEMPLATES_LICENSE_STATUS_OPTION_NAME, $license_data->license );
			if ( 'valid' === $license_data->license ) {
				update_option( QI_TEMPLATES_LICENSE_OPTION_NAME, $license );
				$message = esc_html__( 'Plugin registered successfully', 'qi-templates' );
				qi_templates_get_ajax_status( 'success', $message );
			} else {
				qi_templates_get_ajax_status( 'error', $message );
			}

			die();
		}

		function deactivate_license() {

			if ( ! current_user_can( 'edit_theme_options' ) ) {
				return; // get out if we didn't click the Activate button
			}

			// run a quick security check
			if ( ! check_admin_referer( 'qi_templates_registration_nonce', 'qi_templates_registration_nonce' ) ) {
				return; // get out if we didn't click the Activate button
			}

			// retrieve the license from the database
			$license = trim( get_option( QI_TEMPLATES_LICENSE_OPTION_NAME ) );

			// data to send in our API request
			$api_params = array(
				'edd_action'  => 'deactivate_license',
				'license'     => $license,
				'item_id'     => QI_TEMPLATES_ITEM_ID,
				'item_name'   => rawurlencode( QI_TEMPLATES_ITEM_NAME ),
				// the name of our product in EDD
				'url'         => home_url(),
				'environment' => function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production',
			);

			// Call the custom API.
			$response = wp_remote_post(
				QI_TEMPLATES_STORE_URL,
				array(
					'timeout'   => 15,
					'sslverify' => false,
					'body'      => $api_params,
				)
			);

			// make sure the response came back okay
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				} else {
					$message = esc_html__( 'An error occurred, please try again.', 'qi-templates' );
				}

				die();
			}

			// decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "deactivated" or "failed"
			if ( 'deactivated' === $license_data->license ) {
				delete_option( QI_TEMPLATES_LICENSE_OPTION_NAME );
				delete_option( QI_TEMPLATES_LICENSE_STATUS_OPTION_NAME );
			}

			qi_templates_get_ajax_status( 'success', esc_html__( 'Success', 'qi-templates' ) );
		}
	}
}

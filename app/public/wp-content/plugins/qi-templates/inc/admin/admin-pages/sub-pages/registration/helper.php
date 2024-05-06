<?php
if ( ! function_exists( 'qi_templates_get_license' ) ) {
	/**
	 * @return mixed Value of the option if exist or bool if not exist.
	 */
	function qi_templates_get_license() {
		return get_option( QI_TEMPLATES_LICENSE_OPTION_NAME );
	}
}
if ( ! function_exists( 'qi_templates_plugin_get_license_status' ) ) {
	/**
	 * @return mixed Value of the option if exist or bool if not exist.
	 */
	function qi_templates_plugin_get_license_status() {
		return get_option( QI_TEMPLATES_LICENSE_STATUS_OPTION_NAME );
	}
}
if ( ! function_exists( 'qi_templates_is_plugin_activated' ) ) {
	/**
	 * @return bool Check is plugin activated
	 */
	function qi_templates_is_plugin_activated() {

		$license        = qi_templates_get_license();
		$license_status = qi_templates_plugin_get_license_status();

		if ( ( ! empty( $license ) && ! empty( $license_status ) && 'valid' === $license_status ) || ( strpos( getenv( 'HTTP_HOST' ), 'qodeinteractive' ) !== false ) ) {
			return true;
		}

		return false;

	}
}
if ( ! function_exists( 'qi_templates_plugin_updater' ) ) {

	function qi_templates_plugin_updater() {

		// To support auto-updates, this needs to run during the wp_version_check cron job for privileged users.
		$doing_cron = defined( 'DOING_CRON' ) && DOING_CRON;
		if ( ! current_user_can( 'manage_options' ) && ! $doing_cron ) {
			return;
		}

		// retrieve our license key from the DB
		$license_key = qi_templates_get_license();

		// setup the updater
		$qi_templates_updater = new Qi_Templates_Updater(
			QI_TEMPLATES_STORE_URL,
			QI_TEMPLATES_PLUGIN_BASE_FILE,
			array(
				'version' => QI_TEMPLATES_VERSION,
				'license' => $license_key,
				'item_id' => QI_TEMPLATES_ITEM_ID,
				'author'  => QI_TEMPLATES_ITEM_AUTHOR,
				'beta'    => false,
			)
		);

	}

	add_action( 'init', 'qi_templates_plugin_updater' );
}

if ( ! function_exists( 'qi_templates_add_rest_api_deregistration_route' ) ) {
	/**
	 * Extend main rest api routes with new case
	 *
	 * @param array $routes - list of rest routes
	 *
	 * @return array
	 */
	function qi_templates_add_rest_api_deregistration_route( $routes ) {
		$routes['deregister'] = array(
			'route'    => 'deregister',
			'methods'  => WP_REST_Server::CREATABLE,
			'callback' => 'qi_templates_deregister_plugin',
			'args'     => array(
				'options' => array(
					'required'          => false,
					'validate_callback' => function ( $param, $request, $key ) {
						// Simple solution for validation can be 'is_array' value instead of callback function
						return is_array( $param ) ? $param : (array) $param;
					},
					'description'       => esc_html__( 'Options data is array with all selected shortcode parameters value', 'qi-templates' ),
				),
			),
		);

		return $routes;
	}

	add_filter( 'qi_templates_filter_rest_api_routes', 'qi_templates_add_rest_api_deregistration_route' );
}

if ( ! function_exists( 'qi_templates_deregister_plugin' ) ) {
	/**
	 * Function that deregister plugin
	 *
	 * @return void
	 */
	function qi_templates_deregister_plugin() {
		$license        = qi_templates_get_license();
		$license_status = qi_templates_plugin_get_license_status();

		if ( ( ! empty( $license ) && ! empty( $license_status ) && 'valid' === $license_status ) ) {
			$success = update_option( QI_TEMPLATES_LICENSE_OPTION_NAME, '' ) && update_option( QI_TEMPLATES_LICENSE_STATUS_OPTION_NAME, 'invalid' );

			if ( $success ) {
				qi_templates_get_ajax_status( 'success', esc_html__( 'Plugin deregistered.', 'qi-templates' ), array() );
			} else {
				qi_templates_get_ajax_status( 'error', esc_html__( 'Something went wrong', 'qi-templates' ), array() );
			}
		} else {
			qi_templates_get_ajax_status( 'success', esc_html__( 'Plugin is already deregistered', 'qi-templates' ), array() );
		}
	}
}

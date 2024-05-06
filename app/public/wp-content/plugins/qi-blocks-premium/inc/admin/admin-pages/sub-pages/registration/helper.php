<?php

if ( ! function_exists( 'qi_blocks_premium_get_license' ) ) {
	/**
	 * Get license object
	 *
	 * @return string Value of the option if exist or bool if not exist.
	 */
	function qi_blocks_premium_get_license() {
		return trim( get_option( QI_BLOCKS_PREMIUM_LICENSE_OPTION_NAME ) );
	}
}

if ( ! function_exists( 'qi_blocks_premium_plugin_get_license_status' ) ) {
	/**
	 * Get license status
	 *
	 * @return mixed Value of the option if exist or bool if not exist.
	 */
	function qi_blocks_premium_plugin_get_license_status() {
		return get_option( QI_BLOCKS_PREMIUM_LICENSE_STATUS_OPTION_NAME );
	}
}

if ( ! function_exists( 'qi_blocks_premium_get_author_info' ) ) {
	/**
	 * Get plugin author info
	 *
	 * @return string
	 */
	function qi_blocks_premium_get_author_info() {
		return str_replace( ' ', '', strtolower( QI_BLOCKS_PREMIUM_ITEM_AUTHOR ) );
	}
}

if ( ! function_exists( 'qi_blocks_premium_is_plugin_activated' ) ) {
	/**
	 * Check is plugin activated
	 *
	 * @return bool
	 */
	function qi_blocks_premium_is_plugin_activated() {
		$license        = qi_blocks_premium_get_license();
		$license_status = qi_blocks_premium_plugin_get_license_status();

		if ( ( ! empty( $license ) && ! empty( $license_status ) && 'valid' === $license_status ) || ( strpos( getenv( 'HTTP_HOST' ), qi_blocks_premium_get_author_info() ) !== false ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'qi_blocks_premium_plugin_updater' ) ) {
	/**
	 * Check is there a new version of the plugin
	 */
	function qi_blocks_premium_plugin_updater() {

		// To support auto-updates, this needs to run during the wp_version_check cron job for privileged users.
		$doing_cron = defined( 'DOING_CRON' ) && DOING_CRON;
		if ( ! current_user_can( 'manage_options' ) && ! $doing_cron ) {
			return;
		}

		// retrieve our license key from the DB
		$license_key = qi_blocks_premium_get_license();

		// Set up the updater
		$edd_updater = new Qi_Blocks_Premium_Updater(
			QI_BLOCKS_PREMIUM_STORE_URL,
			QI_BLOCKS_PREMIUM_PLUGIN_BASE_FILE,
			array(
				'version' => QI_BLOCKS_PREMIUM_VERSION,
				'license' => $license_key,
				'item_id' => QI_BLOCKS_PREMIUM_ITEM_ID,
				'author'  => QI_BLOCKS_PREMIUM_ITEM_AUTHOR,
				'beta'    => false,
			)
		);
	}

	add_action( 'admin_init', 'qi_blocks_premium_plugin_updater' );
}

if ( ! function_exists( 'qi_blocks_premium_set_blocks_status' ) ) {
	/**
	 * Get current block status flag
	 *
	 * @return bool
	 */
	function qi_blocks_premium_set_blocks_status( $block_status ) {

		if ( qi_blocks_premium_is_plugin_activated() ) {
			$block_status = true;
		}

		return $block_status;
	}

	add_filter( 'qi_blocks_filter_block_status', 'qi_blocks_premium_set_blocks_status' );
}

if ( ! function_exists( 'qi_blocks_premium_add_rest_api_deregistration_route' ) ) {
	/**
	 * Extend main rest api routes with new case
	 *
	 * @param array $routes - list of rest routes
	 *
	 * @return array
	 */
	function qi_blocks_premium_add_rest_api_deregistration_route( $routes ) {
		$routes['deregister'] = array(
			'route'    => 'deregister',
			'methods'  => WP_REST_Server::CREATABLE,
			'callback' => 'qi_blocks_premium_deregister_plugin',
			'args'     => array(
				'options' => array(
					'required'          => false,
					'validate_callback' => function ( $param, $request, $key ) {
						// Simple solution for validation can be 'is_array' value instead of callback function
						return is_array( $param ) ? $param : (array) $param;
					},
					'description'       => esc_html__( 'Options data is array with all selected shortcode parameters value', 'qi-blocks-premium' ),
				),
			),
		);
		
		return $routes;
	}
	
	add_filter( 'qi_blocks_premium_filter_rest_api_routes', 'qi_blocks_premium_add_rest_api_deregistration_route' );
}

if ( ! function_exists( 'qi_blocks_premium_deregister_plugin' ) ) {
	/**
	 * Function that deregister plugin
	 *
	 * @return void
	 */
	function qi_blocks_premium_deregister_plugin() {
		$license        = qi_blocks_premium_get_license();
		$license_status = qi_blocks_premium_plugin_get_license_status();
		
		if ( ( ! empty( $license ) && ! empty( $license_status ) && 'valid' === $license_status ) ) {
			$success = update_option( QI_BLOCKS_PREMIUM_LICENSE_OPTION_NAME, '' ) && update_option( QI_BLOCKS_PREMIUM_LICENSE_STATUS_OPTION_NAME, 'invalid' );
			
			if ( $success ) {
				qi_blocks_get_ajax_status( 'success', esc_html__( 'Plugin deregistered.', 'qi-blocks-premium' ), array() );
			} else {
				qi_blocks_get_ajax_status( 'error', esc_html__( 'Something went wrong', 'qi-blocks-premium' ), array() );
			}
		} else {
			qi_blocks_get_ajax_status( 'success', esc_html__( 'Plugin is already deregistered', 'qi-blocks-premium' ), array() );
		}
	}
}
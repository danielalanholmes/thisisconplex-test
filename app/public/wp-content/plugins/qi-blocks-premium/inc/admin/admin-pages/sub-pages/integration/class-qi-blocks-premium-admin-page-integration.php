<?php

if ( ! function_exists( 'qi_blocks_premium_add_integration_sub_page_to_list' ) ) {
	/**
	 * Function that add additional sub-page item into general page list
	 *
	 * @param array $sub_pages
	 *
	 * @return array
	 */
	function qi_blocks_premium_add_integration_sub_page_to_list( $sub_pages ) {
		$sub_pages[] = 'Qi_Blocks_Premium_Admin_Page_Integration';

		return $sub_pages;
	}

	add_filter( 'qi_blocks_filter_add_sub_page', 'qi_blocks_premium_add_integration_sub_page_to_list' );
}

if ( class_exists( 'Qi_Blocks_Admin_Sub_Pages' ) ) {
	class Qi_Blocks_Premium_Admin_Page_Integration extends Qi_Blocks_Admin_Sub_Pages {
		private $integration_services = array();

		public function __construct() {

			$this->set_integration_services(
				'google_maps',
				array(
					'title'       => esc_html__( 'Google Maps API Key', 'qi-blocks-premium' ),
					'description' => esc_html__( 'Note: This setting is required if you wish to use Google Maps in your website. Need help to get Google Maps Api key? Read this article .', 'qi-blocks-premium' ),
					'fields'      => array(
						array(
							'field_name'        => 'google_maps_api_key',
							'field_type'        => 'text',
							'field_description' => '',
						),
					),
				)
			);

			parent::__construct();

			add_action( 'admin_enqueue_scripts', array( $this, 'set_additional_scripts' ) );

			add_filter( 'qi_blocks_filter_localize_main_editor_js', array( $this, 'localize_editor_js_scripts' ) );
			
			add_action( 'wp_ajax_qi_blocks_action_premium_integration_save_options', array( $this, 'save_options' ) );
		}

		public function get_integration_services() {
			return $this->integration_services;
		}

		public function set_integration_services( string $integration_services_key, array $integration_services_value ) {
			$this->integration_services[ $integration_services_key ] = $integration_services_value;
		}

		function add_sub_page() {
			$this->set_base( 'integration' );
			$this->set_menu_slug( 'qi_blocks_integration' );
			$this->set_title( esc_html__( 'Integration Page', 'qi-blocks-premium' ) );
			$this->set_atts( $this->set_atributtes() );
            $this->set_position( 5 );
		}

		function set_atributtes() {
			return array(
				'integration_services' => $this->get_integration_services(),
				'api_key_values'       => $this->get_api_keys(),
			);
		}

		function get_content() {
			qi_blocks_premium_template_part( 'admin/admin-pages/sub-pages/' . $this->get_base(), 'templates/' . $this->get_base(), '', $this->get_atts() );
		}

		function get_api_keys() {
			$api_keys = get_option( QI_BLOCKS_PREMIUM_INTEGRATION_KEYS );

			if ( false === $api_keys ) {
				return array();
			}

			return $api_keys;
		}

		function set_additional_scripts( $hook ) {

			if ( isset( $hook ) && strpos( $hook, $this->get_menu_slug() ) !== false ) {
				wp_enqueue_style( 'qi-blocks-premium-integration', QI_BLOCKS_PREMIUM_ASSETS_URL_PATH . '/dist/integration.css' );
			}
		}

		function localize_editor_js_scripts( $variables ) {
			$variables['integrationPageURL'] = admin_url( 'admin.php?page=' . $this->get_menu_slug() );

			return $variables;
		}

		function save_options() {

			if ( current_user_can( 'edit_theme_options' ) ) {
				if ( isset( $_REQUEST['action'] ) ) {
					unset( $_REQUEST['action'] );
				}

				check_ajax_referer( 'qi_blocks_premium_integration_save_nonce', 'qi_blocks_premium_integration_save_nonce' );

				$integration_values = array();
				$services           = $this->get_integration_services();

				if ( is_array( $services ) && count( $services ) > 0 ) {
					foreach ( $services as $service ) {
						if ( isset( $service['fields'] ) ) {
							foreach ( $service['fields'] as $field ) {
								$integration_values[ $field['field_name'] ] = $_REQUEST[ $field['field_name'] ];
							}
						}
					}
				}

				$results = update_option( QI_BLOCKS_PREMIUM_INTEGRATION_KEYS, $integration_values );

				if ( $results ) {
					esc_html_e( 'Saved', 'qi-blocks-premium' );
				}

				die();
			}
		}
	}
}


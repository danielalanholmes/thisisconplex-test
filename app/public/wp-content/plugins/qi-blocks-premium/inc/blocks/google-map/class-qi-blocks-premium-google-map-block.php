<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Google_Map_Block' ) ) {
	class Qi_Blocks_Premium_Google_Map_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'google-map' );
			$this->set_block_title( esc_html__( 'Google Map', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Business', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/google-map/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#google_map' );
			$this->set_block_video( 'https://www.youtube.com/watch?v=IISeNmFxG2w' );

			// Set block 3rd party scripts
			if ( qi_blocks_premium_get_integration_keys( 'google_maps_api_key' ) ) {
				$this->set_block_3rd_party_scripts(
					array(
						'google-map-api' => array(
							'block_name' => 'google-map',
							'url'        => 'https://maps.googleapis.com/maps/api/js?key=' . esc_attr( qi_blocks_premium_get_integration_keys( 'google_maps_api_key' ) ),
						),
					)
				);
			}

			add_filter( 'qi_blocks_filter_localize_main_editor_js', array( $this, 'localize_editor_js_scripts' ) );

			parent::__construct();
		}

		function localize_editor_js_scripts( $variables ) {
			$variables['googleMapPinURL'] = QI_BLOCKS_PREMIUM_BLOCKS_URL_PATH . '/google-map/assets/img/pin.png';

			return $variables;
		}

		/**
		 * @return Qi_Blocks_Premium_Google_Map_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Qi_Blocks_Premium_Google_Map_Block::get_instance();
}

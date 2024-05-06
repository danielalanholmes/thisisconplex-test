<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Image_Hotspots_Block' ) ) {
	class Qi_Blocks_Premium_Image_Hotspots_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block name
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'image-hotspots' );
			$this->set_block_title( esc_html__( 'Image Hotspots', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Showcase/Presentational', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/image-hotspots/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#image_hotspots' );
			$this->set_block_video( 'https://www.youtube.com/watch?v=obHvTlI3Fyk' );

			add_filter( 'qi_blocks_filter_localize_main_editor_js', array( $this, 'localize_editor_js_scripts' ) );

			parent::__construct();
		}

		function localize_editor_js_scripts( $variables ) {
			$variables['imageHotspotsIcon'] = '<svg width="32" height="32" viewBox="0 0 32 32" fill="#000"><g><path d="M 9,18L 16,18 l0,7 C 16,25.552, 16.448,26, 17,26S 18,25.552, 18,25L 18,18 l 7,0 C 25.552,18, 26,17.552, 26,17 C 26,16.448, 25.552,16, 25,16L 18,16 L 18,9 C 18,8.448, 17.552,8, 17,8S 16,8.448, 16,9L 16,16 L 9,16 C 8.448,16, 8,16.448, 8,17C 8,17.552, 8.448,18, 9,18z"></path></g></svg>';

			return $variables;
		}

		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Qi_Blocks_Premium_Image_Hotspots_Block::get_instance();
}

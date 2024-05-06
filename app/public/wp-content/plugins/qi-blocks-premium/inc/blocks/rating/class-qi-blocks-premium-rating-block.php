<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Rating_Block' ) ) {
	class Qi_Blocks_Premium_Rating_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'rating' );
			$this->set_block_title( esc_html__( 'Rating', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'WooCommerce', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/rating/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#rating' );
			$this->set_block_video( 'https://www.youtube.com/watch?v=ZpL0ORaPTkY' );

			add_filter( 'qi_blocks_filter_localize_main_editor_js', array( $this, 'localize_editor_js_scripts' ) );

			parent::__construct();
		}

		function localize_editor_js_scripts( $variables ) {
			$variables['ratingStar'] = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><g><path d="M 20.756,11.768L 15.856,1.84L 10.956,11.768L0,13.36L 7.928,21.088L 6.056,32L 15.856,26.848L 25.656,32L 23.784,21.088L 31.712,13.36 z"></path></g></svg>';

			return $variables;
		}

		/**
		 * @return Qi_Blocks_Premium_Rating_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Qi_Blocks_Premium_Rating_Block::get_instance();
}

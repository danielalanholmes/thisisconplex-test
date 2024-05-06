<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Before_After_Block' ) ) {
	class Qi_Blocks_Premium_Before_After_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'before-after' );
			$this->set_block_title( esc_html__( 'Before/After Comparison Slider', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Showcase/Presentational', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/before-after-comparison-slider/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#before_after_comparison_slider' );
			$this->set_block_video( 'https://www.youtube.com/watch?v=0R5iLs5jItc' );

			// Set block 3rd party scripts
			$this->set_block_3rd_party_scripts(
				array(
					'jquery-event-move' => array(
						'block_name' => 'before-after',
						'url'        => QI_BLOCKS_PREMIUM_INC_URL_PATH . '/blocks/before-after/assets/js/plugins/jquery.event.move.js',
					),
				)
			);

			parent::__construct();
		}

		/**
		 * @return Qi_Blocks_Premium_Before_After_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Qi_Blocks_Premium_Before_After_Block::get_instance();
}

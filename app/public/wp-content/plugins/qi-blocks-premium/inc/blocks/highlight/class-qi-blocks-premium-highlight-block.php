<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Highlight_Block' ) ) {
	class Qi_Blocks_Premium_Highlight_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'highlight' );
			$this->set_block_title( esc_html__( 'Highlighted Text', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Typography', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/highlighted-text/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#highlighted_text' );
			$this->set_block_video( 'https://www.youtube.com/watch?v=7gFwIJ2bunI' );

			parent::__construct();
		}

		/**
		 * @return Qi_Blocks_Premium_Highlight_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Qi_Blocks_Premium_Highlight_Block::get_instance();
}

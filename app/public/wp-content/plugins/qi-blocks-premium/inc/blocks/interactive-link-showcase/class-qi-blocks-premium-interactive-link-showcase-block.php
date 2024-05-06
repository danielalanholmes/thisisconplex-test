<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Interactive_Link_Showcase_Block' ) ) {
	class Qi_Blocks_Premium_Interactive_Link_Showcase_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'interactive-link-showcase' );
			$this->set_block_title( esc_html__( 'Interactive Links', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Creative', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/interactive-links/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#interactive_link_showcase' );
			$this->set_block_video( 'https://www.youtube.com/watch?reload=9&v=RtHYUtiR3ws&feature=youtu.be&ab_channel=QodeInteractive' );

			parent::__construct();
		}

		/**
		 * @return Qi_Blocks_Premium_Interactive_Link_Showcase_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Qi_Blocks_Premium_Interactive_Link_Showcase_Block::get_instance();
}

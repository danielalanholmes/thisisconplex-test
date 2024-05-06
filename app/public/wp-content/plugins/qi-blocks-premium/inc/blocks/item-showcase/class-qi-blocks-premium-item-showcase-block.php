<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Item_Showcase_Block' ) ) {
	class Qi_Blocks_Premium_Item_Showcase_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'item-showcase' );
			$this->set_block_title( esc_html__( 'Item Showcase', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Showcase/Presentational', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/item-showcase/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#item_showcase' );

			parent::__construct();
		}

		/**
		 * @return Qi_Blocks_Premium_Item_Showcase_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Qi_Blocks_Premium_Item_Showcase_Block::get_instance();
}

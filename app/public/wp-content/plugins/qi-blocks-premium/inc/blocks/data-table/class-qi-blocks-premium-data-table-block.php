<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Data_Table_Block' ) ) {
	class Qi_Blocks_Premium_Data_Table_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block name
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'data-table' );
			$this->set_block_title( esc_html__( 'Data Table', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Business', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/data-table/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#data_table' );

			parent::__construct();
		}

		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Qi_Blocks_Premium_Data_Table_Block::get_instance();
}

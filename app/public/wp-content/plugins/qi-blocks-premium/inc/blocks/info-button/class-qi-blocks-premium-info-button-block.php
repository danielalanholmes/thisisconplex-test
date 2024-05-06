<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Info_Button_Block' ) ) {
	class Qi_Blocks_Premium_Info_Button_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'info-button' );
			$this->set_block_title( esc_html__( 'Info Button', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Typography', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/info-button/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#info_button' );

			parent::__construct();
		}

		/**
		 * @return Qi_Blocks_Premium_Info_Button_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Qi_Blocks_Premium_Info_Button_Block::get_instance();
}

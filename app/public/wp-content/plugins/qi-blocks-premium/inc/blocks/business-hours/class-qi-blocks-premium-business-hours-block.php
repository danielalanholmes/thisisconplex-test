<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Business_Hours_Block' ) ) {
	class Qi_Blocks_Premium_Business_Hours_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'business-hours' );
			$this->set_block_title( esc_html__( 'Working Hours', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Business', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/working-hours/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#working_hours' );
			$this->set_block_video( 'https://www.youtube.com/watch?v=ojHRdzRNyLI&ab_channel=QodeInteractive' );

			parent::__construct();
		}

		/**
		 * @return Qi_Blocks_Premium_Business_Hours_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Qi_Blocks_Premium_Business_Hours_Block::get_instance();
}

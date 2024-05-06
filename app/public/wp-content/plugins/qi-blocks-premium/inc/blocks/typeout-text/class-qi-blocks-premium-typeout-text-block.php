<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_TypeoutText_Block' ) ) {
	class Qi_Blocks_Premium_TypeoutText_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'typeout-text' );
			$this->set_block_title( esc_html__( 'Typeout Text', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Typography', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/typeout-text/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#typeout_text' );

			// Set block 3rd party scripts
			$this->set_block_3rd_party_scripts(
				array(
					'typed' => array(
						'block_name' => 'typeout-text',
						'url'        => QI_BLOCKS_PREMIUM_INC_URL_PATH . '/blocks/typeout-text/assets/js/plugins/typed.js',
					),
				)
			);

			parent::__construct();
		}

		/**
		 * @return Qi_Blocks_Premium_TypeoutText_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Qi_Blocks_Premium_TypeoutText_Block::get_instance();
}

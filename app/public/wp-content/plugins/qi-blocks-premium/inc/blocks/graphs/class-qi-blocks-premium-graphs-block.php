<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Graphs_Block' ) ) {
	class Qi_Blocks_Premium_Graphs_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'graphs' );
			$this->set_block_title( esc_html__( 'Graphs', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Infographics', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/graphs/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#graphs' );

			// Set block 3rd party scripts
			$this->set_block_3rd_party_scripts(
				array(
					'chart' => array(
						'block_name' => 'graphs',
						'url'        => QI_BLOCKS_PREMIUM_INC_URL_PATH . '/blocks/graphs/assets/js/plugins/Chart.min.js',
					),
				)
			);

			parent::__construct();
		}

		/**
		 * @return Qi_Blocks_Premium_Graphs_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Qi_Blocks_Premium_Graphs_Block::get_instance();
}

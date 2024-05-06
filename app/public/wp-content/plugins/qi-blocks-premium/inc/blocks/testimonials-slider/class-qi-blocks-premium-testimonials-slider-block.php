<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Testimonials_Slider_Block' ) ) {
	class Qi_Blocks_Premium_Testimonials_Slider_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'testimonials-slider' );
			$this->set_block_title( esc_html__( 'Testimonials Carousel', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Business', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/testimonials-carousel/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#testimonials_carousel' );

			// Set block 3rd party scripts
			$this->set_block_3rd_party_scripts(
				array(
					'swiper' => array(
						'block_name' => 'testimonials-slider',
						'url'        => 'core',
						'has_style'  => true,
					),
				)
			);

			parent::__construct();
		}

		/**
		 * @return Qi_Blocks_Premium_Testimonials_Slider_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Qi_Blocks_Premium_Testimonials_Slider_Block::get_instance();
}

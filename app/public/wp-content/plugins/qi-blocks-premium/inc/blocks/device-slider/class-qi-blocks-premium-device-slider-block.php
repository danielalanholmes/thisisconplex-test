<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Device_Slider_Block' ) ) {
	class Qi_Blocks_Premium_Device_Slider_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'device-slider' );
			$this->set_block_title( esc_html__( 'Device Frame Slider', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Creative', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/device-frame-slider/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#device_frame_slider' );

			// Set block 3rd party scripts
			$this->set_block_3rd_party_scripts(
				array(
					'swiper' => array(
						'block_name' => 'device-slider',
						'url'        => 'core',
						'has_style'  => true,
					),
				)
			);

			add_filter( 'qi_blocks_filter_localize_main_editor_js', array( $this, 'localize_editor_js_scripts' ) );

			parent::__construct();
		}

		function localize_editor_js_scripts( $variables ) {
			$variables['deviceSliderLaptop'] = QI_BLOCKS_PREMIUM_BLOCKS_URL_PATH . '/device-slider/assets/img/laptop-mockup.svg';
			$variables['deviceSliderTablet'] = QI_BLOCKS_PREMIUM_BLOCKS_URL_PATH . '/device-slider/assets/img/tablet-mockup.svg';
			$variables['deviceSliderMobile'] = QI_BLOCKS_PREMIUM_BLOCKS_URL_PATH . '/device-slider/assets/img/mobile-mockup.svg';

			return $variables;
		}

		/**
		 * @return Qi_Blocks_Premium_Device_Slider_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Qi_Blocks_Premium_Device_Slider_Block::get_instance();
}

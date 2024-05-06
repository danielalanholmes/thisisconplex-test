<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Add_To_Cart_Button_Block' ) ) {
	class Qi_Blocks_Premium_Add_To_Cart_Button_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'add-to-cart-button' );
			$this->set_block_title( esc_html__( 'Add to Cart Button', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'WooCommerce', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/add-to-cart-button/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#add_to_cart_button' );

			$block_options = array(
				'render_callback' => array( $this, 'dynamic_render_callback' ),
				'attributes'      => array_merge(
					array(
						'uniqueClass' => array(
							'type' => 'string',
							'default' => '',
						),
						'blockContainerIds' => array(
							'type'    => 'string',
							'default' => '',
						),
						'blockContainerData' => array(
							'type'    => 'string',
							'default' => '',
						),
						'blockContainerClasses' => array(
							'type'    => 'string',
							'default' => '',
						),
					),
					qi_blocks_get_block_container_attributes(),
					array(
						'allProducts' => array(
							'type' => 'array',
							'default' => array(
							),
						),
						'productID' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonLayout' => array(
							'type' => 'string',
							'default' => 'filled',
						),
						'buttonType' => array(
							'type' => 'string',
							'default' => 'standard',
						),
						'buttonUnderline' => array(
							'type' => 'string',
							'default' => 'no',
						),
						'buttonUnderlineColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonUnderlineHoverColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonUnderlineDraw' => array(
							'type' => 'string',
							'default' => 'no',
						),
						'buttonUnderlineAlignment' => array(
							'type' => 'string',
							'default' => 'left',
						),
						'buttonSize' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonIconPosition' => array(
							'type' => 'string',
							'default' => 'right',
						),
						'buttonInnerBorderColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonInnerBorderHoverColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonInnerBorderHoverType' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonIconEnableSideBorder' => array(
							'type' => 'string',
							'default' => 'no',
						),
						'buttonIconSideBorderColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonIconSideBorderHoverColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonRevealHover' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonIconBackgroundHoverReveal' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonIconBackgroundColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonIconBackgroundHoverColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'isButtonIconColorSet' => array(
							'type' => 'boolean',
							'default' => false,
						),
						'buttonIconHoverMove' => array(
							'type' => 'string',
							'default' => 'move-horizontal-short',
						),
						'buttonColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonHoverColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonBorderColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonBorderHoverColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonHoverBackgroundColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonBackgroundColor' => array(
							'type' => 'string',
							'default' => '',
						),
					),
					qi_blocks_get_block_option_typography_attributes( 'buttonText' ),
					array(
						'icon' => array(
							'type' => 'object',
							'default' => array(
								'html' => '',
							),
						),
						'iconColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'iconFontSize' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconFontSizeUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'iconFontSizeDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconFontSizeTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconFontSizeMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconFontSizeUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'iconFontSizeUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'iconFontSizeDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconFontSizeDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthTop' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthTopTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthTopMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthTopDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthTopDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthTopDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthRight' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthRightTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthRightMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthRightDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthRightDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthRightDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthBottom' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthBottomTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthBottomMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthBottomDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthBottomDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthBottomDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthLeft' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthLeftTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthLeftMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthLeftDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthLeftDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthLeftDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderWidthUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonBorderWidthUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonBorderWidthUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonBorderRadiusTop' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusTopTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusTopMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusTopDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusTopDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusTopDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusRight' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusRightTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusRightMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusRightDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusRightDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusRightDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusBottom' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusBottomTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusBottomMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusBottomDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusBottomDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusBottomDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusLeft' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusLeftTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusLeftMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusLeftDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusLeftDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusLeftDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonBorderRadiusUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonBorderRadiusUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonBorderRadiusUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonPaddingTop' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingTopTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingTopMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingTopDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingTopDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingTopDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingRight' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingRightTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingRightMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingRightDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingRightDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingRightDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingBottom' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingBottomTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingBottomMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingBottomDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingBottomDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingBottomDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingLeft' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingLeftTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingLeftMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingLeftDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingLeftDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingLeftDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonPaddingUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonPaddingUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonPaddingUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonLink' => array(
							'type' => 'string',
							'default' => '',
						),
						'buttonLinkTargetBlank' => array(
							'type' => 'boolean',
							'default' => false,
						),
						'buttonLinkRelNofollow' => array(
							'type' => 'boolean',
							'default' => false,
						),
						'buttonLinkCustomAttributes' => array(
							'type' => 'string',
							'default' => '',
						),
						'iconMarginTop' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginTopTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginTopMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginTopDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginTopDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginTopDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginRight' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginRightTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginRightMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginRightDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginRightDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginRightDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginBottom' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginBottomTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginBottomMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginBottomDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginBottomDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginBottomDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginLeft' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginLeftTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginLeftMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginLeftDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginLeftDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginLeftDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'iconMarginUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'iconMarginUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'iconMarginUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonUnderlineWidth' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineWidthUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonUnderlineWidthDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineWidthTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineWidthMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineWidthUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonUnderlineWidthUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonUnderlineWidthDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineWidthDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineHoverWidth' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineHoverWidthUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonUnderlineHoverWidthDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineHoverWidthTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineHoverWidthMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineHoverWidthUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonUnderlineHoverWidthUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonUnderlineHoverWidthDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineHoverWidthDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineOffset' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineOffsetUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonUnderlineOffsetTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineOffsetMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineOffsetUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonUnderlineOffsetUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonUnderlineThickness' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineThicknessUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonUnderlineThicknessDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineThicknessTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineThicknessMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineThicknessUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonUnderlineThicknessUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonUnderlineThicknessDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonUnderlineThicknessDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonIconSideBorderHeight' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonIconSideBorderHeightUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonIconSideBorderHeightTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonIconSideBorderHeightMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonIconSideBorderHeightUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonIconSideBorderHeightUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonIconSideBorderWidth' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonIconSideBorderWidthUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonIconSideBorderWidthTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonIconSideBorderWidthMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonIconSideBorderWidthUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonIconSideBorderWidthUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonInnerBorderOffset' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonInnerBorderOffsetUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonInnerBorderOffsetDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonInnerBorderOffsetTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonInnerBorderOffsetMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonInnerBorderOffsetUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonInnerBorderOffsetUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonInnerBorderOffsetDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonInnerBorderOffsetDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonInnerBorderWidth' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonInnerBorderWidthUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonInnerBorderWidthTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonInnerBorderWidthMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'buttonInnerBorderWidthUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'buttonInnerBorderWidthUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
					)
				),
			);

			$this->set_block_options( $block_options );

			parent::__construct();
		}

		/**
		 * @return Qi_Blocks_Premium_Add_To_Cart_Button_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function register_block() {
			if ( qi_blocks_premium_is_installed( 'woocommerce' ) ) {
				parent::register_block();
			}
		}

		function dynamic_render_callback( $attributes ) {
			extract( $attributes );
			$product = wc_get_product( $productID );

			$html = '';

			if( ! empty( $product ) ) {
				$block_classes = qi_blocks_get_block_holder_classes( 'add-to-cart-button', $attributes );

				$link_classes = array(
					'qodef-add-to-cart-button-link',
					'qodef-layout--' . $buttonLayout,
					'qodef-type--' . $buttonType,
				);

				$link_classes[] = ! empty( $buttonInnerBorderHoverType ) ? 'qodef-inner-border-hover--' . $buttonInnerBorderHoverType : '';
				$link_classes[] = ! empty( $buttonSize ) ? 'qodef-size--' . $buttonSize : '';
				$link_classes[] = 'yes' === $buttonUnderline ? 'qodef-text-underline' : '';
				$link_classes[] = ( ! empty( $buttonUnderlineAlignment ) && 'yes' === $buttonUnderline ) ? 'qodef-underline--' . $buttonUnderlineAlignment : '';
				$link_classes[] = ( 'yes' === $buttonUnderline && 'yes' === $buttonUnderlineDraw ) ? 'qodef-button-underline-draw' : '';
				$link_classes[] = ! empty( $buttonIconPosition ) ? 'qodef-icon--' . $buttonIconPosition : '';
				$link_classes[] = ! empty( $buttonRevealHover ) ? 'qodef-hover--reveal qodef--' . $buttonRevealHover : '';
				$link_classes[] = ! empty( $buttonIconBackgroundHoverReveal ) ? 'qodef-icon-background-hover--reveal qodef-icon-background-hover--' . $buttonIconBackgroundHoverReveal : '';
				$link_classes[] = ! empty( $buttonIconHoverMove ) ? 'qodef-hover--icon-' . $buttonIconHoverMove : '';

				// Woo Classes
				$link_classes[] = 'button';
				$link_classes[] = 'product_type_' . $product->get_type();
				$link_classes[] = $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '';
				$link_classes[] = $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '';

				$icon_holder_classes = array(
					'qodef-m-icon'
				);

				$icon_holder_classes[] = $isButtonIconColorSet ? 'qodef--icon-color-set' : '';

				$html .= '<div ' . qi_blocks_get_block_container_html_attributes_string( $attributes ) . '>';
				$html .= '<div class="' . implode( ' ', $block_classes ) . '">';
				$html .= '<a 
						class="' . implode( ' ', $link_classes ) . '" 
						href="' . $product->add_to_cart_url() . '" 
						data-product_id="' . $product->get_id() . '"
						data-product_sku="' . $product->get_sku() . '"
						aria-label="' . $product->add_to_cart_description() . '"
						aria-label="' . $product->add_to_cart_description() . '"
						rel="nofollow"
					>';
				$html .= '<span class="qodef-m-text">';
				$html .= $product->add_to_cart_text();
				$html .= '</span>';
				if( 'icon-boxed' === $buttonType && 'yes' === $buttonIconEnableSideBorder && 'textual' !== $buttonLayout ) {
					$html .= '<span class="qodef-m-border">';
					$html .= '</span>';
				}
				if( ! empty( $icon ) ) {
					$html .= '<span class="' . implode( ' ', $icon_holder_classes ) . '">';
					$html .= '<span class="qodef-m-icon-inner">';
					$html .= $icon['html'];
					$html .= ! empty( $buttonIconHoverMove ) && 'move-horizontal-short' !== $buttonIconHoverMove ? $icon : '';
					$html .= '</span>';
					$html .= '</span>';
				}
				if( 'inner-border' === $buttonType ) {
					$html .= '<span class="qodef-m-inner-border">';
					if( 'move-outer-edge' !== $buttonInnerBorderHoverType ) {
						$html .= '<span class="qodef-m-border-top"></span>';
						$html .= '<span class="qodef-m-border-right"></span>';
						$html .= '<span class="qodef-m-border-bottom"></span>';
						$html .= '<span class="qodef-m-border-left"></span>';
					}

					if ( in_array( $buttonInnerBorderHoverType, array( 'draw q-draw-center', 'draw q-draw-one-point', 'draw q-draw-two-points' ), true ) ) {
						$html .= '<span class="qodef-m-inner-border qodef-m-inner-border-copy">';
						$html .= '<span class="qodef-m-border-top"></span>';
						$html .= '<span class="qodef-m-border-right"></span>';
						$html .= '<span class="qodef-m-border-bottom"></span>';
						$html .= '<span class="qodef-m-border-left"></span>';
						$html .= '</span>';
					}
					$html .= '</span>';
				}
				$html .= '</a>';
				$html .= '</div>';
				$html .= '</div>';
			} else {
				$html .= esc_html__( 'Please choose the product.', 'qi-blocks-premium' );
			}

			return $html;
		}
	}

	Qi_Blocks_Premium_Add_To_Cart_Button_Block::get_instance();
}

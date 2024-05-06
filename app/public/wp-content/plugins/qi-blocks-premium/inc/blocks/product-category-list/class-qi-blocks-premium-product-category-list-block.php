<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Product_Category_List_Block' ) ) {
	class Qi_Blocks_Premium_Product_Category_List_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'product-category-list' );
			$this->set_block_title( esc_html__( 'Product Category List', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'WooCommerce', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/product-category-list/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#product_category_list' );

			// Set block 3rd party scripts
			$this->set_block_3rd_party_scripts(
				array(
					'isotope'    => array(
						'block_name' => 'product-category-list',
						'url'        => 'core',
					),
					'packery'    => array(
						'block_name' => 'product-category-list',
						'url'        => 'core',
					),
					'button-script' => array(
						'block_name' => 'product-category-list',
						'url'        => QI_BLOCKS_ASSETS_URL_PATH . '/dist/button-script.js'
					)
				)
			);

			$this->set_block_options(
				array(
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
							'queriedProductCategoriesData' => array(
								'type' => 'array',
								'default' => array(
								),
							),
							'behavior' => array(
								'type' => 'string',
								'default' => 'columns',
							),
							'columnClasses' => array(
								'type' => 'string',
								'default' => '',
							),
							'masonryClasses' => array(
								'type' => 'string',
								'default' => '',
							),
							'imagesProportion' => array(
								'type' => 'string',
								'default' => 'full',
							),
							'customImageWidth' => array(
								'type' => 'string',
								'default' => '',
							),
							'customImageHeight' => array(
								'type' => 'string',
								'default' => '',
							),
							'enableZigzag' => array(
								'type' => 'string',
								'default' => 'no',
							),
							'itemLayout' => array(
								'type' => 'string',
								'default' => 'info-on-image-boxed',
							),
							'titleTag' => array(
								'type' => 'string',
								'default' => 'h5',
							),
							'titleColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'titleHoverColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'contentPosition' => array(
								'type' => 'string',
								'default' => 'center',
							),
							'overlayColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'overlayHoverColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'imageHover' => array(
								'type' => 'string',
								'default' => 'zoom',
							),
							'imageZoomOrigin' => array(
								'type' => 'string',
								'default' => '',
							),
							'titleBackgroundColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'backgroundColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'verticalAlignment' => array(
								'type' => 'string',
								'default' => 'flex-start',
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
							'buttonText' => array(
								'type' => 'string',
								'default' => 'View More',
								'source' => 'html',
								'selector' => 'span',
							),
							'columns' => array(
								'type' => 'number',
								'default' => 3,
							),
							'columnsResponsive' => array(
								'type' => 'string',
								'default' => 'predefined',
							),
							'columns1440' => array(
								'type' => 'number',
								'default' => '',
							),
							'columns1366' => array(
								'type' => 'number',
								'default' => '',
							),
							'columns1024' => array(
								'type' => 'number',
								'default' => '',
							),
							'columns768' => array(
								'type' => 'number',
								'default' => '',
							),
							'columns680' => array(
								'type' => 'number',
								'default' => '',
							),
							'columns480' => array(
								'type' => 'number',
								'default' => '',
							),
							'spaceBetweenItems' => array(
								'type' => 'number',
								'default' => '',
							),
							'spaceBetweenItemsUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'spaceBetweenItemsDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'spaceBetweenItemsTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'spaceBetweenItemsMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'spaceBetweenItemsUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'spaceBetweenItemsUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'spaceBetweenItemsDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'spaceBetweenItemsDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'zigzagAmount' => array(
								'type' => 'number',
								'default' => '',
							),
							'zigzagAmountUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'zigzagAmountDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'zigzagAmountTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'zigzagAmountMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'zigzagAmountUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'zigzagAmountUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'zigzagAmountDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'zigzagAmountDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'postsPerPage' => array(
								'type' => 'number',
								'default' => 9,
							),
							'orderBy' => array(
								'type' => 'string',
								'default' => 'date',
							),
							'order' => array(
								'type' => 'string',
								'default' => 'desc',
							),
							'additionalParams' => array(
								'type' => 'string',
								'default' => '',
							),
							'hideEmpty' => array(
								'type' => 'string',
								'default' => 'no',
							),
							'taxonomyIDs' => array(
								'type' => 'string',
								'default' => '',
							),
						),
						qi_blocks_get_block_option_typography_attributes( 'buttonText' ),
						array(
							'buttonIcon' => array(
								'type' => 'object',
								'default' => array(
									'html' => '',
								),
							),
							'buttonIconColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'buttonIconFontSize' => array(
								'type' => 'number',
								'default' => '',
							),
							'buttonIconFontSizeUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'buttonIconFontSizeDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'buttonIconFontSizeTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'buttonIconFontSizeMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'buttonIconFontSizeUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'buttonIconFontSizeUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'buttonIconFontSizeDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'buttonIconFontSizeDecimalMobile' => array(
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
							'borderRadiusTop' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusTopTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusTopMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusTopDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusTopDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusTopDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusRight' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusRightTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusRightMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusRightDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusRightDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusRightDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusBottom' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusBottomTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusBottomMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusBottomDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusBottomDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusBottomDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusLeft' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusLeftTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusLeftMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusLeftDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusLeftDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusLeftDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'borderRadiusUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'borderRadiusUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'borderRadiusUnitMobile' => array(
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
							'buttonIconStrokeWidth'                 => array(
								'type'    => 'number',
								'default' => '',
							),
							'buttonIconStrokeWidthUnit'             => array(
								'type'    => 'string',
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
						),
						qi_blocks_get_block_option_typography_attributes( 'title' ),
						array(
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
							'titleBoxWidth' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleBoxWidthUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'titleBoxWidthDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleBoxWidthTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleBoxWidthMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleBoxWidthUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'titleBoxWidthUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'titleBoxWidthDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleBoxWidthDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleBottomOffset' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleBottomOffsetUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'titleBottomOffsetDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleBottomOffsetTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleBottomOffsetMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleBottomOffsetUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'titleBottomOffsetUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'titleBottomOffsetDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleBottomOffsetDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageWidth' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageWidthUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'imageWidthDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageWidthTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageWidthMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageWidthUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'imageWidthUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'imageWidthDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageWidthDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'buttonTopMargin' => array(
								'type' => 'number',
								'default' => '',
							),
							'buttonTopMarginUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'buttonTopMarginDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'buttonTopMarginTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'buttonTopMarginMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'buttonTopMarginUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'buttonTopMarginUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'buttonTopMarginDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'buttonTopMarginDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingTop' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingTopTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingTopMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingTopDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingTopDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingTopDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingRight' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingRightTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingRightMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingRightDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingRightDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingRightDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingBottom' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingBottomTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingBottomMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingBottomDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingBottomDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingBottomDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingLeft' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingLeftTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingLeftMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingLeftDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingLeftDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingLeftDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'titlePaddingUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'titlePaddingUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'titlePaddingUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'contentPaddingTop' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingTopTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingTopMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingTopDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingTopDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingTopDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingRight' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingRightTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingRightMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingRightDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingRightDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingRightDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingBottom' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingBottomTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingBottomMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingBottomDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingBottomDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingBottomDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingLeft' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingLeftTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingLeftMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingLeftDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingLeftDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingLeftDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'contentPaddingUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'contentPaddingUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'contentPaddingUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'imagePaddingTop' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingTopTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingTopMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingTopDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingTopDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingTopDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingRight' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingRightTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingRightMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingRightDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingRightDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingRightDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingBottom' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingBottomTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingBottomMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingBottomDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingBottomDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingBottomDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingLeft' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingLeftTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingLeftMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingLeftDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingLeftDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingLeftDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imagePaddingUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'imagePaddingUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'imagePaddingUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'horizontalAlignment' => array(
								'type' => 'string',
								'default' => '',
							),
							'horizontalAlignmentTablet' => array(
								'type' => 'string',
								'default' => '',
							),
							'horizontalAlignmentMobile' => array(
								'type' => 'string',
								'default' => '',
							),
						)
					),
				)
			);

			parent::__construct();
		}

		/**
		 * @return Qi_Blocks_Premium_Product_Category_List_Block
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
			$attributes['post_type']       = 'product';
			$attributes['holder_classes']  = $this->get_holder_classes( $attributes );
			$attributes['taxonomy']        = 'product_cat';
			$attributes['taxonomy_items']  = get_terms( qi_blocks_premium_get_custom_post_type_taxonomy_query_args( $attributes ) );
			$attributes['masonry_classes'] = $attributes['masonryClasses'];
			$attributes['item_classes']    = 'qodef-e qodef-gutenberg-column';
			$attributes['layout']          = $attributes['itemLayout'];

			return qi_blocks_premium_get_template_part( 'blocks/product-category-list', 'templates/content', '', $attributes );
		}

		function get_holder_classes( $attributes ) {
			$classes = qi_blocks_get_block_holder_classes( 'product-category-list', $attributes, 'qi-blocks-woo-block' );

			$classes[] = ! empty( $attributes['columnClasses'] ) ? $attributes['columnClasses'] : '';
			$classes[] = ! empty( $attributes['itemLayout'] ) ? 'qodef-item-layout--' . $attributes['itemLayout'] : '';
			$classes[] = ! empty( $attributes['imageHover'] ) ? 'qodef-image--hover-' . $attributes['imageHover'] : '';
			$classes[] = ! empty( $attributes['imageZoomOrigin'] ) ? 'qodef-image--hover-from-' . $attributes['imageZoomOrigin'] : '';
			$classes[] = ( ! empty( $attributes['contentPosition'] ) && 'info-on-image' === $attributes['itemLayout'] ) ? 'qodef-position--' . $attributes['contentPosition'] : '';

			return implode( ' ', $classes );
		}
	}

	Qi_Blocks_Premium_Product_Category_List_Block::get_instance();
}

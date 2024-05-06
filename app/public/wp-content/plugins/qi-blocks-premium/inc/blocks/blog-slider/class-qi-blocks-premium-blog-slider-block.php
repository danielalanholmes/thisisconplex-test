<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Blog_Slider_Block' ) ) {
	class Qi_Blocks_Premium_Blog_Slider_Block extends Qi_Blocks_Blocks {
		private static $instance;

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'blog-slider' );
			$this->set_block_title( esc_html__( 'Blog Carousel', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Business', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/blog-carousel/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#blog_carousel' );

			// Set block 3rd party scripts
			$this->set_block_3rd_party_scripts(
				array(
					'swiper' => array(
						'block_name' => 'blog-slider',
						'url'        => 'core',
						'has_style'  => true,
					),
					'button-script' => array(
						'block_name' => 'blog-slider',
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
							'queriedPostsData' => array(
								'type' => 'array',
								'default' => array(
								),
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
							'buttonText' => array(
								'type' => 'string',
								'default' => '',
							),
							'itemLayout' => array(
								'type' => 'string',
								'default' => 'boxed',
							),
							'titleTag' => array(
								'type' => 'string',
								'default' => 'h5',
							),
							'showExcerpt' => array(
								'type' => 'string',
								'default' => '',
							),
							'excerptLength' => array(
								'type' => 'string',
								'default' => '',
							),
							'centerContent' => array(
								'type' => 'string',
								'default' => '',
							),
							'showMedia' => array(
								'type' => 'string',
								'default' => '',
							),
							'showInfoIcons' => array(
								'type' => 'string',
								'default' => '',
							),
							'showDate' => array(
								'type' => 'string',
								'default' => '',
							),
							'showCategory' => array(
								'type' => 'string',
								'default' => '',
							),
							'showAuthor' => array(
								'type' => 'string',
								'default' => '',
							),
							'showButton' => array(
								'type' => 'string',
								'default' => '',
							),
							'infoOnImageFullHeight' => array(
								'type' => 'string',
								'default' => '',
							),
							'titleColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'titleHoverColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'excerptColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'infoColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'infoHoverColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'infoIconsColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'titleHoverUnderline' => array(
								'type' => 'string',
								'default' => 'no',
							),
							'imageHover' => array(
								'type' => 'string',
								'default' => 'zoom',
							),
							'imageZoomOrigin' => array(
								'type' => 'string',
								'default' => '',
							),
							'overlayColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'overlayHoverColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'boxedContentBackgroundColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'dateColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'dateHoverColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'dateBackgroundColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'standardBottomInfoColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'standardBottomInfoHoverColor' => array(
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
							'postIds' => array(
								'type' => 'string',
								'default' => '',
							),
							'tax' => array(
								'type' => 'string',
								'default' => 'category',
							),
							'taxSlug' => array(
								'type' => 'string',
								'default' => '',
							),
							'taxIn' => array(
								'type' => 'string',
								'default' => '',
							),
							'authorSlug' => array(
								'type' => 'string',
								'default' => '',
							),
						),
						qi_blocks_get_block_option_typography_attributes( 'title' ),
						qi_blocks_get_block_option_typography_attributes( 'excerpt' ),
						qi_blocks_get_block_option_typography_attributes( 'info' ),
						array(
							'postInfoMarginBottom' => array(
								'type' => 'number',
								'default' => '',
							),
							'postInfoMarginBottomUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'postInfoMarginBottomDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'postInfoMarginBottomTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'postInfoMarginBottomMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'postInfoMarginBottomUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'postInfoMarginBottomUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'postInfoMarginBottomDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'postInfoMarginBottomDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleMarginBottom' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleMarginBottomUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'titleMarginBottomDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleMarginBottomTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleMarginBottomMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleMarginBottomUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'titleMarginBottomUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'titleMarginBottomDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'titleMarginBottomDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'textMarginBottom' => array(
								'type' => 'number',
								'default' => '',
							),
							'textMarginBottomUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'textMarginBottomDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'textMarginBottomTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'textMarginBottomMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'textMarginBottomUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'textMarginBottomUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'textMarginBottomDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'textMarginBottomDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
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
						),
						qi_blocks_get_block_option_typography_attributes( 'date' ),
						array(
							'datePaddingTop' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingTopTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingTopMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingTopDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingTopDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingTopDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingRight' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingRightTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingRightMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingRightDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingRightDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingRightDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingBottom' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingBottomTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingBottomMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingBottomDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingBottomDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingBottomDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingLeft' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingLeftTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingLeftMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingLeftDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingLeftDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingLeftDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'datePaddingUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'datePaddingUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'datePaddingUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'boxedItemBoxShadowColor' => array(
								'type' => 'string',
								'default' => '',
							),
							'boxedItemBoxShadowHorizontal' => array(
								'type' => 'number',
								'default' => '',
							),
							'boxedItemBoxShadowVertical' => array(
								'type' => 'number',
								'default' => '',
							),
							'boxedItemBoxShadowBlur' => array(
								'type' => 'number',
								'default' => '',
							),
							'boxedItemBoxShadowSpread' => array(
								'type' => 'number',
								'default' => '',
							),
							'boxedItemBoxShadowPosition' => array(
								'type' => 'string',
								'default' => '',
							),
							'imageMarginBottom' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageMarginBottomUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'imageMarginBottomDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageMarginBottomTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageMarginBottomMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageMarginBottomUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'imageMarginBottomUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'imageMarginBottomDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageMarginBottomDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'sideImageWidth' => array(
								'type' => 'number',
								'default' => '',
							),
							'sideImageWidthUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'sideImageWidthDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'sideImageWidthTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'sideImageWidthMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'sideImageWidthUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'sideImageWidthUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'sideImageWidthDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'sideImageWidthDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
						),
						qi_blocks_get_block_option_typography_attributes( 'standardBottomInfo' ),
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
							'imageBorderRadiusTop' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusTopTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusTopMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusTopDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusTopDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusTopDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusRight' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusRightTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusRightMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusRightDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusRightDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusRightDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusBottom' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusBottomTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusBottomMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusBottomDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusBottomDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusBottomDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusLeft' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusLeftTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusLeftMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusLeftDecimal' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusLeftDecimalTablet' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusLeftDecimalMobile' => array(
								'type' => 'number',
								'default' => '',
							),
							'imageBorderRadiusUnit' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'imageBorderRadiusUnitTablet' => array(
								'type' => 'string',
								'default' => 'px',
							),
							'imageBorderRadiusUnitMobile' => array(
								'type' => 'string',
								'default' => 'px',
							),
						),
						qi_blocks_get_block_slider_attributes( array( 'sliderDirection', 'sliderHeight' ) ),
						qi_blocks_get_block_slider_navigation_attributes(),
						qi_blocks_get_block_slider_pagination_attributes(),
						array(
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
						)
					),
				)
			);

			parent::__construct();
		}

		/**
		 * @return Qi_Blocks_Premium_Blog_Slider_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function dynamic_render_callback( $attributes ) {
			$attributes['post_type']             = 'post';
			$attributes['additional_query_args'] = qi_blocks_get_additional_query_args( $attributes );
			$query_result                        = new WP_Query( qi_blocks_get_query_params( $attributes ) );
			$attributes['query_result']          = $query_result;
			$attributes['holder_classes']        = $this->get_holder_classes( $attributes );
			$attributes['layout']                = $attributes['itemLayout'];
			$attributes['slider_classes']        = qi_blocks_get_slider_classes( $attributes );
			$attributes['slider_attr']           = qi_blocks_get_slider_data( $attributes );
			$attributes['item_classes']          = 'qodef-blog-item';

			return qi_blocks_premium_get_template_part( 'blocks/blog-slider', 'templates/content', '', $attributes );
		}

		function get_holder_classes( $attributes ) {
			$classes = qi_blocks_get_block_holder_classes( 'blog-slider', $attributes );

			if ( ! empty( $attributes['itemLayout'] ) && 'standard' === $attributes['itemLayout'] ) {
				$classes[] = 'qodef--list';
			}

			if ( ! empty( $attributes['centerContent'] ) && 'yes' === $attributes['centerContent'] ) {
				$classes[] = 'qodef-alignment--centered';
			}

			$classes[] = 'yes' !== $attributes['showInfoIcons'] ? 'qodef-info-no-icons' : '';
			$classes[] = 'yes' === $attributes['titleHoverUnderline'] ? 'qodef-title--hover-underline' : '';
			$classes[] = ! empty( $attributes['imageHover'] ) ? 'qodef-image--hover-' . $attributes['imageHover'] : '';
			$classes[] = ! empty( $attributes['imageZoomOrigin'] ) ? 'qodef-image--hover-from-' . $attributes['imageZoomOrigin'] : '';
			$classes[] = ! empty( $attributes['itemLayout'] ) ? 'qodef-item-layout--' . $attributes['itemLayout'] : '';

			return implode( ' ', $classes );
		}
	}

	Qi_Blocks_Premium_Blog_Slider_Block::get_instance();
}

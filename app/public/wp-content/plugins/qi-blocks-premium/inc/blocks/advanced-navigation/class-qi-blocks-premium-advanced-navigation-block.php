<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Advanced_Navigation_Block' ) ) {
	class Qi_Blocks_Premium_Advanced_Navigation_Block extends Qi_Blocks_Blocks {
		private static $instance;
		private $block_attributes = array();

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'advanced-navigation' );
			$this->set_block_title( esc_html__( 'Advanced Navigation', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Showcase/Presentational', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/advanced-navigation/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#advanced_navigation' );

			$block_options = array(
				'render_callback' => array( $this, 'dynamic_render_callback' ),
				'attributes'      => array_merge(
					array(
						'uniqueClass'           => array(
							'type'    => 'string',
							'default' => '',
						),
						'blockContainerIds'     => array(
							'type'    => 'string',
							'default' => '',
						),
						'blockContainerData'    => array(
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
						'navigationMenus'                                 => array(
							'type'    => 'array',
							'default' => array(),
						),
						'navigationMenuID'                                => array(
							'type'    => 'number',
							'default' => '',
						),
						'navigationMenuHTML'                              => array(
							'type'    => 'string',
							'default' => '',
						),
						'layout'                                          => array(
							'type'    => 'string',
							'default' => 'standard',
						),
						'horizontalAlignment'                             => array(
							'type'    => 'string',
							'default' => '',
						),
						'horizontalAlignmentTablet'                       => array(
							'type'    => 'string',
							'default' => '',
						),
						'horizontalAlignmentMobile'                       => array(
							'type'    => 'string',
							'default' => '',
						),
						'setDropDownTrigger'                              => array(
							'type'    => 'boolean',
							'default' => false,
						),
					),
					qi_blocks_get_block_option_typography_attributes( 'menu' ),
					array(
						'itemColor'                                       => array(
							'type'    => 'string',
							'default' => '',
						),
						'itemBackgroundColor'                             => array(
							'type'    => 'string',
							'default' => '',
						),
						'itemEvenBackgroundColor'                         => array(
							'type'    => 'string',
							'default' => '',
						),
						'itemHoverColor'                                  => array(
							'type'    => 'string',
							'default' => '',
						),
						'itemHoverBackgroundColor'                        => array(
							'type'    => 'string',
							'default' => '',
						),
						'itemActiveColor'                                 => array(
							'type'    => 'string',
							'default' => '',
						),
						'itemActiveBackgroundColor'                       => array(
							'type'    => 'string',
							'default' => '',
						),
						'itemVerticalPadding'                             => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemVerticalPaddingUnit'                         => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'itemVerticalPaddingDecimal'                      => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemVerticalPaddingTablet'                       => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemVerticalPaddingMobile'                       => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemVerticalPaddingUnitTablet'                   => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'itemVerticalPaddingUnitMobile'                   => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'itemVerticalPaddingDecimalTablet'                => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemVerticalPaddingDecimalMobile'                => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemHorizontalPadding'                           => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemHorizontalPaddingUnit'                       => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'itemHorizontalPaddingDecimal'                    => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemHorizontalPaddingTablet'                     => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemHorizontalPaddingMobile'                     => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemHorizontalPaddingUnitTablet'                 => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'itemHorizontalPaddingUnitMobile'                 => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'itemHorizontalPaddingDecimalTablet'              => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemHorizontalPaddingDecimalMobile'              => array(
							'type'    => 'number',
							'default' => '',
						),
						'spaceBetweenItems'                               => array(
							'type'    => 'number',
							'default' => '',
						),
						'spaceBetweenItemsUnit'                           => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'spaceBetweenItemsDecimal'                        => array(
							'type'    => 'number',
							'default' => '',
						),
						'spaceBetweenItemsTablet'                         => array(
							'type'    => 'number',
							'default' => '',
						),
						'spaceBetweenItemsMobile'                         => array(
							'type'    => 'number',
							'default' => '',
						),
						'spaceBetweenItemsUnitTablet'                     => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'spaceBetweenItemsUnitMobile'                     => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'spaceBetweenItemsDecimalTablet'                  => array(
							'type'    => 'number',
							'default' => '',
						),
						'spaceBetweenItemsDecimalMobile'                  => array(
							'type'    => 'number',
							'default' => '',
						),
						'enableBorderBetweenItems'                        => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'itemBorderColor'                                 => array(
							'type'    => 'string',
							'default' => '',
						),
						'itemBorderThickness'                             => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemBorderThicknessUnit'                         => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'menuItemStyle'                                   => array(
							'type'    => 'string',
							'default' => 'default',
						),
						'itemIcon'                                        => array(
							'type'    => 'object',
							'default' => array(
								'html' => '',
							),
						),
						'moveIconOnHover'                                 => array(
							'type'    => 'string',
							'default' => '',
						),
						'itemIconAppear'                                  => array(
							'type'    => 'string',
							'default' => 'fade-in',
						),
						'itemIconPosition'                                => array(
							'type'    => 'string',
							'default' => 'right',
						),
						'itemIconVerticalOffset'                          => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemIconVerticalOffsetUnit'                      => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'itemIconVerticalOffsetTablet'                    => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemIconVerticalOffsetMobile'                    => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemIconVerticalOffsetUnitTablet'                => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'itemIconVerticalOffsetUnitMobile'                => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'itemIconSize'                                    => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemIconSizeUnit'                                => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'itemIconSizeDecimal'                             => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemIconSizeTablet'                              => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemIconSizeMobile'                              => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemIconSizeUnitTablet'                          => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'itemIconSizeUnitMobile'                          => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'itemIconSizeDecimalTablet'                       => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemIconSizeDecimalMobile'                       => array(
							'type'    => 'number',
							'default' => '',
						),
						'spaceBetweenItemAndIcon'                         => array(
							'type'    => 'number',
							'default' => '',
						),
						'spaceBetweenItemAndIconUnit'                     => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'itemUnderlineDistance'                           => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemUnderlineDistanceUnit'                       => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'itemUnderlineDistanceDecimal'                    => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemUnderlineThickness'                          => array(
							'type'    => 'number',
							'default' => '',
						),
						'itemUnderlineThicknessUnit'                      => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'dropDownWidth'                                   => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownWidthUnit'                               => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'dropDownBackgroundColor'                         => array(
							'type'    => 'string',
							'default' => '',
						),
						'dropDownBorderStyle'                             => array(
							'type'    => 'string',
							'default' => '',
						),
						'dropDownBorderColor'                             => array(
							'type'    => 'string',
							'default' => '',
						),
						'dropDownBorderWidthTop'                          => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBorderWidthTopTablet'                    => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBorderWidthTopMobile'                    => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBorderWidthRight'                        => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBorderWidthRightTablet'                  => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBorderWidthRightMobile'                  => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBorderWidthBottom'                       => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBorderWidthBottomTablet'                 => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBorderWidthBottomMobile'                 => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBorderWidthLeft'                         => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBorderWidthLeftTablet'                   => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBorderWidthLeftMobile'                   => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBorderWidthUnit'                         => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'dropDownBorderWidthUnitTablet'                   => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'dropDownBorderWidthUnitMobile'                   => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'dropDownBoxShadowColor'                          => array(
							'type'    => 'string',
							'default' => '',
						),
						'dropDownBoxShadowHorizontal'                     => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBoxShadowVertical'                       => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBoxShadowBlur'                           => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBoxShadowSpread'                         => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownBoxShadowPosition'                       => array(
							'type'    => 'string',
							'default' => '',
						),
						'dropDownTopBottomSpace'                          => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownTopBottomSpaceUnit'                      => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'dropDownTopBottomSpaceDecimal'                   => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownTopBottomSpaceTablet'                    => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownTopBottomSpaceMobile'                    => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownTopBottomSpaceUnitTablet'                => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'dropDownTopBottomSpaceUnitMobile'                => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'dropDownTopBottomSpaceDecimalTablet'             => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownTopBottomSpaceDecimalMobile'             => array(
							'type'    => 'number',
							'default' => '',
						),
					),
					qi_blocks_get_block_option_typography_attributes( 'dropDownMenu' ),
					array(
						'dropDownItemColor'                        => array(
							'type'    => 'string',
							'default' => '',
						),
						'dropDownItemHoverColor'                   => array(
							'type'    => 'string',
							'default' => '',
						),
						'dropDownItemActiveColor'                  => array(
							'type'    => 'string',
							'default' => '',
						),
						'dropDownItemVerticalSpace'                => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownItemVerticalSpaceUnit'            => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'dropDownItemVerticalSpaceDecimal'         => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownItemVerticalSpaceTablet'          => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownItemVerticalSpaceMobile'          => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownItemVerticalSpaceUnitTablet'      => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'dropDownItemVerticalSpaceUnitMobile'      => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'dropDownItemVerticalSpaceDecimalTablet'   => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownItemVerticalSpaceDecimalMobile'   => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownItemHorizontalSpace'              => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownItemHorizontalSpaceUnit'          => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'dropDownItemHorizontalSpaceDecimal'       => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownItemHorizontalSpaceTablet'        => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownItemHorizontalSpaceMobile'        => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownItemHorizontalSpaceUnitTablet'    => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'dropDownItemHorizontalSpaceUnitMobile'    => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'dropDownItemHorizontalSpaceDecimalTablet' => array(
							'type'    => 'number',
							'default' => '',
						),
						'dropDownItemHorizontalSpaceDecimalMobile' => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuWidth'                          => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuWidthUnit'                      => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileMenuWidthDecimal'                   => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuWidthTablet'                    => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuWidthMobile'                    => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuWidthUnitTablet'                => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileMenuWidthUnitMobile'                => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileMenuWidthDecimalTablet'             => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuWidthDecimalMobile'             => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuSpace'                          => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuSpaceUnit'                      => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileMenuSpaceDecimal'                   => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuSpaceTablet'                    => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuSpaceMobile'                    => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuSpaceUnitTablet'                => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileMenuSpaceUnitMobile'                => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileMenuSpaceDecimalTablet'             => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuSpaceDecimalMobile'             => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuBackgroundColor'                => array(
							'type'    => 'string',
							'default' => '',
						),
						'mobileMenuBorderStyle'                    => array(
							'type'    => 'string',
							'default' => '',
						),
						'mobileMenuBorderColor'                    => array(
							'type'    => 'string',
							'default' => '',
						),
						'mobileMenuBorderWidthBottom'              => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuBorderWidthBottomTablet'        => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuBorderWidthBottomMobile'        => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuBorderWidthUnit'                => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileMenuBorderWidthUnitTablet'          => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileMenuBorderWidthUnitMobile'          => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileOpenerIcon'                         => array(
							'type'    => 'object',
							'default' => array(
								'html' => '',
							),
						),
						'mobileOpenerSize'                         => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileOpenerSizeUnit'                     => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileOpenerSizeDecimal'                  => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileOpenerSizeTablet'                   => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileOpenerSizeMobile'                   => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileOpenerSizeUnitTablet'               => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileOpenerSizeUnitMobile'               => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileOpenerSizeDecimalTablet'            => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileOpenerSizeDecimalMobile'            => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileOpenerColor'                        => array(
							'type'    => 'string',
							'default' => '',
						),
						'mobileOpenerHoverColor'                   => array(
							'type'    => 'string',
							'default' => '',
						),
						'mobileOpenerActiveColor'                  => array(
							'type'    => 'string',
							'default' => '',
						),
						'mobileOpenerStrokeWidth'                  => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileOpenerStrokeWidthUnit'              => array(
							'type'    => 'string',
							'default' => 'px',
						),
					),
					qi_blocks_get_block_option_typography_attributes( 'mobileMenu' ),
					array(
						'mobileMenuItemColor'                             => array(
							'type'    => 'string',
							'default' => '',
						),
						'mobileMenuItemHoverColor'                        => array(
							'type'    => 'string',
							'default' => '',
						),
						'mobileMenuItemActiveColor'                       => array(
							'type'    => 'string',
							'default' => '',
						),
						'mobileMenuItemVerticalSpace'                     => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuItemVerticalSpaceUnit'                 => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileMenuItemVerticalSpaceDecimal'              => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuItemVerticalSpaceTablet'               => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuItemVerticalSpaceMobile'               => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuItemVerticalSpaceUnitTablet'           => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileMenuItemVerticalSpaceUnitMobile'           => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileMenuItemVerticalSpaceDecimalTablet'        => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileMenuItemVerticalSpaceDecimalMobile'        => array(
							'type'    => 'number',
							'default' => '',
						),
					),
					qi_blocks_get_block_option_typography_attributes( 'mobileSubmenu' ),
					array(
						'mobileSubmenuItemColor'                      => array(
							'type'    => 'string',
							'default' => '',
						),
						'mobileSubmenuItemHoverColor'                 => array(
							'type'    => 'string',
							'default' => '',
						),
						'mobileSubmenuItemActiveColor'                => array(
							'type'    => 'string',
							'default' => '',
						),
						'mobileSubmenuItemVerticalSpace'              => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileSubmenuItemVerticalSpaceUnit'          => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileSubmenuItemVerticalSpaceDecimal'       => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileSubmenuItemVerticalSpaceTablet'        => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileSubmenuItemVerticalSpaceMobile'        => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileSubmenuItemVerticalSpaceUnitTablet'    => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileSubmenuItemVerticalSpaceUnitMobile'    => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'mobileSubmenuItemVerticalSpaceDecimalTablet' => array(
							'type'    => 'number',
							'default' => '',
						),
						'mobileSubmenuItemVerticalSpaceDecimalMobile' => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenMenuWidth'                         => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenMenuWidthUnit'                     => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenMenuWidthDecimal'                  => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenMenuWidthTablet'                   => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenMenuWidthMobile'                   => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenMenuWidthUnitTablet'               => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenMenuWidthUnitMobile'               => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenMenuWidthDecimalTablet'            => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenMenuWidthDecimalMobile'            => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenMenuAlignment'                     => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenBackgroundColor'                   => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenBackgroundImage'                   => array(
							'type'    => 'object',
							'default' => array(
								'id'  => null,
								'url' => '',
								'alt' => '',
							),
						),
						'fullScreenBackgroundImageTablet'             => array(
							'type'    => 'object',
							'default' => array(
								'id'  => null,
								'url' => '',
								'alt' => '',
							),
						),
						'fullScreenBackgroundImageMobile'             => array(
							'type'    => 'object',
							'default' => array(
								'id'  => null,
								'url' => '',
								'alt' => '',
							),
						),
						'fullScreenBackgroundPosition'                => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenBackgroundPositionTablet'          => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenBackgroundPositionMobile'          => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenBackgroundXPosition'               => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundXPositionUnit'           => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenBackgroundXPositionDecimal'        => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundXPositionTablet'         => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundXPositionMobile'         => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundXPositionUnitTablet'     => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenBackgroundXPositionUnitMobile'     => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenBackgroundXPositionDecimalTablet'  => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundXPositionDecimalMobile'  => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundYPosition'               => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundYPositionUnit'           => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenBackgroundYPositionDecimal'        => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundYPositionTablet'         => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundYPositionMobile'         => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundYPositionUnitTablet'     => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenBackgroundYPositionUnitMobile'     => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenBackgroundYPositionDecimalTablet'  => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundYPositionDecimalMobile'  => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundAttachment'              => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenBackgroundRepeat'                  => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenBackgroundRepeatTablet'            => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenBackgroundRepeatMobile'            => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenBackgroundSize'                    => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenBackgroundSizeTablet'              => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenBackgroundSizeMobile'              => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenBackgroundSizeWidth'               => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundSizeWidthUnit'           => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenBackgroundSizeWidthDecimal'        => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundSizeWidthTablet'         => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundSizeWidthMobile'         => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundSizeWidthUnitTablet'     => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenBackgroundSizeWidthUnitMobile'     => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenBackgroundSizeWidthDecimalTablet'  => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenBackgroundSizeWidthDecimalMobile'  => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenOpenerIcon'                        => array(
							'type'    => 'object',
							'default' => array(
								'html' => '',
							),
						),
						'fullScreenOpenerSize'                        => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenOpenerSizeUnit'                    => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenOpenerSizeDecimal'                 => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenOpenerColor'                       => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenOpenerHoverColor'                  => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenOpenerStrokeWidth'                 => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenOpenerStrokeWidthUnit'             => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenCloseIcon'                         => array(
							'type'    => 'object',
							'default' => array(
								'html' => '',
							),
						),
						'fullScreenCloseSize'                         => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseSizeUnit'                     => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenCloseSizeDecimal'                  => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseTopPosition'                  => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseTopPositionTablet'            => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseTopPositionMobile'            => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseTopPositionUnit'              => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenCloseTopPositionUnitTablet'        => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenCloseTopPositionUnitMobile'        => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenCloseTopPositionDecimal'           => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseTopPositionDecimalTablet'     => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseTopPositionDecimalMobile'     => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseRightPosition'                => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseRightPositionTablet'          => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseRightPositionMobile'          => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseRightPositionUnit'            => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenCloseRightPositionUnitTablet'      => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenCloseRightPositionUnitMobile'      => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenCloseRightPositionDecimal'         => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseRightPositionDecimalTablet'   => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseRightPositionDecimalMobile'   => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseColor'                        => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenCloseHoverColor'                   => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenCloseStrokeWidth'                  => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenCloseStrokeWidthUnit'              => array(
							'type'    => 'string',
							'default' => 'px',
						),
					),
					qi_blocks_get_block_option_typography_attributes( 'fullScreenMenu' ),
					array(
						'fullScreenMenuItemColor'                         => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenMenuItemHoverColor'                    => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenMenuItemActiveColor'                   => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenMenuItemArrowSize'                     => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenMenuItemArrowSizeUnit'                 => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenMenuItemArrowSizeDecimal'              => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenMenuItemVerticalSpace'                 => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenMenuItemVerticalSpaceUnit'             => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenMenuItemVerticalSpaceDecimal'          => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenMenuItemVerticalSpaceTablet'           => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenMenuItemVerticalSpaceMobile'           => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenMenuItemVerticalSpaceUnitTablet'       => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenMenuItemVerticalSpaceUnitMobile'       => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenMenuItemVerticalSpaceDecimalTablet'    => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenMenuItemVerticalSpaceDecimalMobile'    => array(
							'type'    => 'number',
							'default' => '',
						),
					),
					qi_blocks_get_block_option_typography_attributes( 'fullScreenSubmenu' ),
					array(
						'fullScreenSubmenuItemColor'                      => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenSubmenuItemHoverColor'                 => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenSubmenuItemActiveColor'                => array(
							'type'    => 'string',
							'default' => '',
						),
						'fullScreenSubmenuItemVerticalSpace'              => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenSubmenuItemVerticalSpaceUnit'          => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenSubmenuItemVerticalSpaceDecimal'       => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenSubmenuItemVerticalSpaceTablet'        => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenSubmenuItemVerticalSpaceMobile'        => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenSubmenuItemVerticalSpaceUnitTablet'    => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenSubmenuItemVerticalSpaceUnitMobile'    => array(
							'type'    => 'string',
							'default' => 'px',
						),
						'fullScreenSubmenuItemVerticalSpaceDecimalTablet' => array(
							'type'    => 'number',
							'default' => '',
						),
						'fullScreenSubmenuItemVerticalSpaceDecimalMobile' => array(
							'type'    => 'number',
							'default' => '',
						),
					)
				),
			);

			$this->set_block_options( $block_options );

			parent::__construct();
		}

		/**
		 * @return Qi_Blocks_Premium_Advanced_Navigation_Block
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function get_block_attributes() {
			return $this->block_attributes;
		}

		public function set_block_attributes( $block_attributes ) {
			$this->block_attributes = $block_attributes;
		}

		function dynamic_render_callback( $attributes ) {
			$block_classes = qi_blocks_get_block_holder_classes( 'advanced-navigation', $attributes );

			if ( ! empty( $attributes['layout'] ) ) {
				$block_classes[] = 'qodef-layout--' . esc_attr( $attributes['layout'] );
			}

			if ( 'full-screen' === $attributes['layout'] && ! empty( $attributes['fullScreenMenuAlignment'] ) ) {
				$block_classes[] = 'qodef-menu--' . esc_attr( $attributes['fullScreenMenuAlignment'] );
			}

			if ( ! empty( $attributes['setDropDownTrigger'] ) ) {
				$block_classes[] = 'qodef-dropdown-trigger--menu-item';
			}

			if ( 'full-screen' !== $attributes['layout'] && ! empty( $attributes['enableBorderBetweenItems'] ) ) {
				$block_classes[] = 'qodef-border--between';
			}

			if ( ! empty( $attributes['menuItemStyle'] ) ) {
				$block_classes[] = 'qodef-item-style--' . esc_attr( $attributes['menuItemStyle'] );
			}

			if ( 'with-icon' === $attributes['menuItemStyle'] && ! empty( $attributes['moveIconOnHover'] ) ) {
				$block_classes[] = 'qodef-item-icon-hover--' . esc_attr( $attributes['moveIconOnHover'] );
			}

			if ( in_array( $attributes['menuItemStyle'], array( 'with-active-icon', 'with-active-background-svg' ), true ) && ! empty( $attributes['itemIconAppear'] ) ) {
				$block_classes[] = 'qodef-item-icon-appear--' . esc_attr( $attributes['itemIconAppear'] );
			}

			if ( in_array( $attributes['menuItemStyle'], array( 'with-icon', 'with-active-icon' ), true ) && ! empty( $attributes['itemIconPosition'] ) ) {
				$block_classes[] = 'qodef-item-icon-position--' . esc_attr( $attributes['itemIconPosition'] );
			}

			$nav_menu_id    = isset( $attributes['navigationMenuID'] ) && ! empty( $attributes['navigationMenuID'] ) ? intval( $attributes['navigationMenuID'] ) : '';
			$theme_location = empty( $nav_menu_id ) && has_nav_menu( 'qi-blocks-navigation' ) ? 'qi-blocks-navigation' : '';
			$html           = '';

			if ( ! empty( $nav_menu_id ) || ! empty( $theme_location ) ) {
				$nav_menu_args = array(
					'container'       => 'nav',
					'container_class' => 'qodef-navigation-menu',
					'menu'            => $nav_menu_id,
					'theme_location'  => $theme_location,
					'echo'            => false,
				);

				$this->set_block_attributes( $attributes );

				add_filter( 'nav_menu_item_title', array( $this, 'add_nav_menu_item_icon' ), 10, 4 );
				add_filter( 'nav_menu_item_args', array( $this, 'add_nav_menu_mobile_item_icon' ), 10, 2 );

				$nav_html = wp_nav_menu( $nav_menu_args );

				remove_filter( 'nav_menu_item_title', array( $this, 'add_nav_menu_item_icon' ) );
				remove_filter( 'nav_menu_item_args', array( $this, 'add_nav_menu_mobile_item_icon' ) );

				$html .= '<div ' . qi_blocks_get_block_container_html_attributes_string( $attributes ) . '>';
				$html .= '<div class="' . implode( ' ', $block_classes ) . '">';

				if ( 'full-screen' === $attributes['layout'] ) {
					$html .= '<div class="qodef-m-wrapper">';
					$html .= $nav_html;

					if ( 'with-active-floating-underline' === $attributes['menuItemStyle'] ) {
						$html .= '<span class="qodef-navigation-line"></span>';
					}

					$html .= '<button type="button" class="qodef-full-screen-menu-opener qodef--close" aria-expanded="false" aria-label="' . esc_attr__( 'Close the menu', 'qi-blocks-premium' ) . '">';
					if ( isset( $attributes['fullScreenCloseIcon'] ) && ! empty( $attributes['fullScreenCloseIcon'] ) && ! empty( $attributes['fullScreenCloseIcon']['html'] ) ) {
						$html .= $attributes['fullScreenCloseIcon']['html'];
					} else {
						$html .= qi_blocks_get_svg_icon( 'close' );
					}
					$html .= '</button>';
					$html .= '</div>';

					$html .= '<button type="button" class="qodef-full-screen-menu-opener qodef--open" aria-expanded="false" aria-label="' . esc_attr__( 'Open the menu', 'qi-blocks-premium' ) . '">';
					if ( isset( $attributes['fullScreenOpenerIcon'] ) && ! empty( $attributes['fullScreenOpenerIcon'] ) && ! empty( $attributes['fullScreenOpenerIcon']['html'] ) ) {
						$html .= $attributes['fullScreenOpenerIcon']['html'];
					} else {
						$html .= qi_blocks_get_svg_icon( 'menu' );
					}
					$html .= '</button>';
				} else {
					$html .= $nav_html;

					if ( 'with-active-floating-underline' === $attributes['menuItemStyle'] ) {
						$html .= '<span class="qodef-navigation-line"></span>';
					}

					$html .= '<button type="button" class="qodef-mobile-menu-opener" aria-expanded="false" aria-label="' . esc_attr__( 'Open the menu', 'qi-blocks-premium' ) . '">';
					if ( isset( $attributes['mobileOpenerIcon'] ) && ! empty( $attributes['mobileOpenerIcon'] ) && ! empty( $attributes['mobileOpenerIcon']['html'] ) ) {
						$html .= $attributes['mobileOpenerIcon']['html'];
					} else {
						$html .= qi_blocks_get_svg_icon( 'menu' );
					}
					$html .= '</button>';
				}

				$html .= '</div>';
				$html .= '</div>';
			} else {
				$html .= esc_html__( 'Please choose an Navigation menu', 'qi-blocks-premium' );
			}

			return $html;
		}

		function add_nav_menu_item_icon( $title, $item, $args, $depth ) {
			$attributes   = $this->get_block_attributes();
			$icon_options = array();

			if ( isset( $attributes['menuItemStyle'] ) && in_array( $attributes['menuItemStyle'], array( 'with-icon', 'with-active-icon', 'with-active-background-svg' ), true ) ) {
				$icon_options['type'] = $attributes['menuItemStyle'];

				if ( ! empty( $attributes['itemIcon'] ) && ! empty( $attributes['itemIcon']['html'] ) ) {
					$icon_options['icon'] = $attributes['itemIcon']['html'];
				}

				if ( 'with-icon' === $attributes['menuItemStyle'] && ! empty( $attributes['moveIconOnHover'] ) ) {
					$icon_options['iconHover'] = $attributes['moveIconOnHover'];
				}
			}

			$icon_html    = '';

			$title = '<span class="qodef-m-text">' . wp_kses_post( $title ) . '</span>';

			if ( in_array( 'menu-item-has-children', $item->classes, true ) && $depth > 0 && 'full-screen' !== $attributes['layout'] ) {
				$title .= qi_blocks_get_svg_icon( 'menu-arrow-right', 'qodef-menu-item-arrow' );
			}

			if ( ! empty( $icon_options ) && 0 === $depth ) {
				$type = $icon_options['type'] ?? '';
				$icon = $icon_options['icon'] ?? '';

				if ( ! empty( $type ) && ! empty( $icon ) ) {

					if ( 'with-icon' === $type ) {
						$icon_html = '<span class="qodef-m-icon">' . $icon;

						if ( isset( $icon_options['iconHover'] ) && in_array( $icon_options['iconHover'], array( 'horizontal', 'vertical', 'diagonal' ), true ) ) {
							$icon_html .= $icon;
						}

						$icon_html .= '</span>';
					}

					if ( 'with-active-icon' === $type ) {
						$icon_html = '<span class="qodef-m-active-icon">' . $icon . '</span>';
					}

					if ( 'with-active-background-svg' === $type ) {
						$icon_html = '<span class="qodef-m-svg-icon">' . $icon . '</span>';
					}
				}
			}

			return $title . $icon_html;
		}

		function add_nav_menu_mobile_item_icon( $args, $item ) {
			$attributes  = $this->get_block_attributes();
			$args->after = '';

			$arrow_class = 'full-screen' === $attributes['layout'] ? 'full-screen-menu' : 'mobile-menu';

			if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
				$args->after = '<button type="button" class="qodef-' . $arrow_class . '-item-arrow" aria-expanded="false" aria-label="' . esc_attr__( 'Open the menu', 'qi-blocks-premium' ) . '"><span class="screen-reader-text">' . esc_html__( 'Show sub menu', 'qi-blocks-premium' ) . '</span>' . qi_blocks_get_svg_icon( 'menu-arrow-right' ) . '</button>';
			}

			return $args;
		}
	}

	Qi_Blocks_Premium_Advanced_Navigation_Block::get_instance();
}

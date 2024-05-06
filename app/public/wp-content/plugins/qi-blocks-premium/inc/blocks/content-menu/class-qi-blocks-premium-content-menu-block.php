<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Qi_Blocks_Premium_Content_Menu_Block' ) ) {
	class Qi_Blocks_Premium_Content_Menu_Block extends Qi_Blocks_Blocks {
		private static $instance;
		private $block_attributes = array();

		public function __construct() {
			// Set block data
			$this->set_block_type( 'premium' );
			$this->set_block_name( 'content-menu' );
			$this->set_block_title( esc_html__( 'Content Menu', 'qi-blocks-premium' ) );
			$this->set_block_subcategory( esc_html__( 'Showcase/Presentational', 'qi-blocks-premium' ) );
			$this->set_block_demo_url( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/content-menu/' );
			$this->set_block_documentation( 'https://qodeinteractive.com/qi-blocks-for-gutenberg/documentation/#content_menu' );
			$this->set_block_video( 'https://www.youtube.com/watch?v=u2AU0Q4N3a8' );

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
						'navigationMenus' => array(
							'type' => 'array',
							'default' => array(
							),
						),
						'navigationMenuID' => array(
							'type' => 'number',
							'default' => '',
						),
						'navigationMenuHTML' => array(
							'type' => 'string',
							'default' => '',
						),
						'layout' => array(
							'type' => 'string',
							'default' => 'horizontal',
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
						'enableResponsiveMenu' => array(
							'type' => 'boolean',
							'default' => false,
						),
						'responsiveMenuBreakpoint' => array(
							'type' => 'string',
							'default' => '768',
						),
					),
					qi_blocks_get_block_option_typography_attributes( 'menu' ),
					array(
						'itemColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'itemBackgroundColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'itemEvenBackgroundColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'itemHoverColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'itemHoverBackgroundColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'itemActiveColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'itemActiveBackgroundColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'itemVerticalPadding' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemVerticalPaddingUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'itemVerticalPaddingDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemVerticalPaddingTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemVerticalPaddingMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemVerticalPaddingUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'itemVerticalPaddingUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'itemVerticalPaddingDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemVerticalPaddingDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemHorizontalPadding' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemHorizontalPaddingUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'itemHorizontalPaddingDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemHorizontalPaddingTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemHorizontalPaddingMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemHorizontalPaddingUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'itemHorizontalPaddingUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'itemHorizontalPaddingDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemHorizontalPaddingDecimalMobile' => array(
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
						'enableBorderBetweenItems' => array(
							'type' => 'boolean',
							'default' => false,
						),
						'itemBorderColor' => array(
							'type' => 'string',
							'default' => '',
						),
						'itemBorderThickness' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemBorderThicknessUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'menuItemStyle' => array(
							'type' => 'string',
							'default' => 'default',
						),
						'itemIcon' => array(
							'type' => 'object',
							'default' => array(
								'html' => '',
							),
						),
						'moveIconOnHover' => array(
							'type' => 'string',
							'default' => '',
						),
						'itemIconAppear' => array(
							'type' => 'string',
							'default' => 'fade-in',
						),
						'itemIconPosition' => array(
							'type' => 'string',
							'default' => 'right',
						),
						'itemIconVerticalOffset' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemIconVerticalOffsetUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'itemIconVerticalOffsetTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemIconVerticalOffsetMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemIconVerticalOffsetUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'itemIconVerticalOffsetUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'itemIconSize' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemIconSizeUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'itemIconSizeDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemIconSizeTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemIconSizeMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemIconSizeUnitTablet' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'itemIconSizeUnitMobile' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'itemIconSizeDecimalTablet' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemIconSizeDecimalMobile' => array(
							'type' => 'number',
							'default' => '',
						),
						'spaceBetweenItemAndIcon' => array(
							'type' => 'number',
							'default' => '',
						),
						'spaceBetweenItemAndIconUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'itemUnderlineDistance' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemUnderlineDistanceUnit' => array(
							'type' => 'string',
							'default' => 'px',
						),
						'itemUnderlineDistanceDecimal' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemUnderlineThickness' => array(
							'type' => 'number',
							'default' => '',
						),
						'itemUnderlineThicknessUnit' => array(
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
		 * @return Qi_Blocks_Premium_Content_Menu_Block
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
			$block_classes = qi_blocks_get_block_holder_classes( 'content-menu', $attributes );

			if ( ! empty( $attributes['layout'] ) ) {
				$block_classes[] = 'qodef-layout--' . esc_attr( $attributes['layout'] );
			}

			if ( ! empty( $attributes['enableResponsiveMenu'] ) && ! empty( $attributes['responsiveMenuBreakpoint'] ) ) {
				$block_classes[] = 'qodef-responsive--' . esc_attr( $attributes['responsiveMenuBreakpoint'] );
			}

			if ( ! empty( $attributes['enableBorderBetweenItems'] ) ) {
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

			if ( 'vertical' === $attributes['layout'] && in_array( $attributes['menuItemStyle'], array( 'with-icon', 'with-active-icon' ), true ) && ! empty( $attributes['itemIconStructure'] ) ) {
				$block_classes[] = 'qodef-item-icon-structure--' . esc_attr( $attributes['itemIconStructure'] );
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
					'depth'           => 1,
					'echo'            => false,
				);

				$this->set_block_attributes( $attributes );

				add_filter( 'nav_menu_item_title', array( $this, 'add_nav_menu_item_icon' ) );

				$nav_html = wp_nav_menu( $nav_menu_args );

				remove_filter( 'nav_menu_item_title', array( $this, 'add_nav_menu_item_icon' ) );

				$html .= '<div ' . qi_blocks_get_block_container_html_attributes_string( $attributes ) . '>';
				$html .= '<div class="' . implode( ' ', $block_classes ) . '">';

				if ( 'with-active-floating-underline' === $attributes['menuItemStyle'] ) {
					$html .= '<span class="qodef-navigation-line"></span>';
				}

				$html .= $nav_html;

				$html .= '</div>';
				$html .= '</div>';
			} else {
				$html .= esc_html__( 'Please choose an Navigation menu', 'qi-blocks-premium' );
			}

			return $html;
		}

		function add_nav_menu_item_icon( $title ) {
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

			if ( ! empty( $icon_options ) ) {
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
	}

	Qi_Blocks_Premium_Content_Menu_Block::get_instance();
}

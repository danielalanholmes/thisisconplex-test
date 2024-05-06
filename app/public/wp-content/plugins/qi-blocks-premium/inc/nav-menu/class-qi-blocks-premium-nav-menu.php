<?php

class Qi_Blocks_Premium_Nav_Menu {
	private static $instance;
	private $post_id = 0;
	private $menu_layout = '';
	private $menu_item_icon_options = array();

	public function __construct() {
		// Function which registers navigation menus
		add_action( 'init', array( $this, 'register_navigation_menus' ) );

		// Extend main rest api routes with new case
		add_filter( 'qi_blocks_filter_rest_api_routes', array( $this, 'add_rest_api_routes' ) );
	}

	/**
	 * @return Qi_Blocks_Premium_Nav_Menu
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function get_post_id() {
		return $this->post_id;
	}

	public function set_post_id( $post_id ) {
		$this->post_id = intval( $post_id );
	}

	public function get_menu_layout() {
		return $this->menu_layout;
	}

	public function set_menu_layout( $menu_layout ) {
		$this->menu_layout = $menu_layout;
	}

	public function get_menu_item_icon_options() {
		return $this->menu_item_icon_options;
	}

	public function set_menu_item_icon_options( $menu_item_icon_options ) {
		$this->menu_item_icon_options = $menu_item_icon_options;
	}

	function register_navigation_menus() {
		$navigation_menus = apply_filters( 'qi_blocks_premium_filter_register_navigation_menus', array( 'qi-blocks-navigation' => esc_html__( 'Qi Blocks Navigation', 'qi-blocks-premium' ) ) );

		if ( ! empty( $navigation_menus ) ) {
			register_nav_menus( $navigation_menus );
		}
	}

	function add_rest_api_routes( $routes ) {
		$routes['get-nav-menus'] = array(
			'route'               => 'get-nav-menus',
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => array( $this, 'get_nav_menu_callback' ),
			'permission_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		);

		$routes['render-nav-menu'] = array(
			'route'               => 'render-nav-menu',
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => array( $this, 'render_nav_menu_callback' ),
			'permission_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
			'args'                => array(
				'navigationMenuID' => array(
					'required'          => true,
					'validate_callback' => function ( $param ) {
						return intval( $param );
					},
				),
			),
		);

		return $routes;
	}

	function get_nav_menu_callback() {

		if ( empty( $_GET ) ) {
			qi_blocks_get_ajax_status( 'error', esc_html__( 'Get method is invalid', 'qi-blocks-premium' ), array() );
		} else {
			$results = array();
			$menus   = wp_get_nav_menus();

			foreach ( $menus as $menu ) {
				$results[ $menu->term_id ] = esc_attr( $menu->name );
			}

			if ( ! empty( $results ) ) {
				qi_blocks_get_ajax_status( 'success', esc_html__( 'Navigation menus are successfully returned', 'qi-blocks-premium' ), $results );
			} else {
				qi_blocks_get_ajax_status( 'error', esc_html__( 'No available navigation menus', 'qi-blocks-premium' ), array() );
			}
		}
	}

	function render_nav_menu_callback( $response ) {

		if ( ! isset( $response ) || empty( $response->get_body() ) ) {
			qi_blocks_get_ajax_status( 'error', esc_html__( 'Rest is invalid', 'qi-blocks-premium' ), array() );
		} else {
			$response_data    = json_decode( $response->get_body() );
			$post_id          = isset( $response_data->postID ) && ! empty( $response_data->postID ) ? intval( $response_data->postID ) : 0;
			$nav_menu_id      = isset( $response_data->navigationMenuID ) && ! empty( $response_data->navigationMenuID ) ? intval( $response_data->navigationMenuID ) : '';
			$theme_location   = empty( $nav_menu_id ) && has_nav_menu( 'qi-blocks-navigation' ) ? 'qi-blocks-navigation' : '';
			$nav_menu_layout  = isset( $response_data->menuLayout ) && ! empty( $response_data->menuLayout ) ? esc_attr( $response_data->menuLayout ) : '';
			$icon_options     = isset( $response_data->menuItemIconOptions ) && ! empty( $response_data->menuItemIconOptions ) ? (array) $response_data->menuItemIconOptions : array();
			$menu_depth       = isset( $response_data->menuDepth ) && ! empty( $response_data->menuDepth ) ? intval( $response_data->menuDepth ) : 0;
			$is_advanced_menu = isset( $response_data->isAdvancedMenu ) && ! empty( $response_data->isAdvancedMenu );

			if ( ! empty( $nav_menu_id ) || ! empty( $theme_location ) ) {
				$nav_menu_args = array(
					'container'       => 'nav',
					'container_class' => 'qodef-navigation-menu',
					'menu'            => $nav_menu_id,
					'theme_location'  => $theme_location,
					'depth'           => $menu_depth,
					'echo'            => false,
				);

				if ( ! empty( $post_id ) ) {
					$this->set_post_id( $post_id );
				}

				if ( ! empty( $nav_menu_layout ) ) {
					$this->set_menu_layout( $nav_menu_layout );
				}

				if ( ! empty( $icon_options ) ) {
					$this->set_menu_item_icon_options( $icon_options );
				}

				add_filter( 'nav_menu_css_class', array( $this, 'add_additional_nav_menu_item_classes' ), 10, 2 );
				add_filter( 'nav_menu_item_title', array( $this, 'add_nav_menu_item_icon' ), 10, 4 );
				add_filter( 'nav_menu_item_id', '__return_empty_string' );

				if ( $is_advanced_menu ) {
					add_filter( 'nav_menu_item_args', array( $this, 'add_nav_menu_mobile_item_icon' ), 10, 2 );
				}

				$html = wp_nav_menu( $nav_menu_args );

				if ( empty( $html ) ) {
					$html = esc_html__( 'No menu was found or there are no items inside it', 'qi-blocks-premium' );
				}

				remove_filter( 'nav_menu_css_class', array( $this, 'add_additional_nav_menu_item_classes' ) );
				remove_filter( 'nav_menu_item_title', array( $this, 'add_nav_menu_item_icon' ) );
				remove_filter( 'nav_menu_item_id', '__return_empty_string' );

				if ( $is_advanced_menu ) {
					remove_filter( 'nav_menu_item_args', array( $this, 'add_nav_menu_mobile_item_icon' ) );
				}

				qi_blocks_get_ajax_status( 'success', esc_html__( 'Returned navigation menu HTML content', 'qi-blocks-premium' ), $html );
			} else {
				qi_blocks_get_ajax_status( 'success', esc_html__( 'Parameters are invalid', 'qi-blocks-premium' ), esc_html__( 'Please choose an Navigation menu', 'qi-blocks-premium' ) );
			}
		}
	}

	function add_additional_nav_menu_item_classes( $classes, $item ) {

		if ( isset( $item->object_id ) && intval( $item->object_id ) === $this->get_post_id() ) {
			$classes[] = 'current-menu-item';
		}

		return $classes;
	}

	function add_nav_menu_item_icon( $title, $item, $args, $depth ) {
		$menu_layout  = $this->get_menu_layout();
		$icon_options = $this->get_menu_item_icon_options();
		$icon_html    = '';

		$title = '<span class="qodef-m-text">' . wp_kses_post( $title ) . '</span>';

		if ( in_array( 'menu-item-has-children', $item->classes, true ) && $depth > 0 && 'full-screen' !== $menu_layout ) {
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
		$menu_layout = $this->get_menu_layout();
		$args->after = '';

		$arrow_class = 'full-screen' === $menu_layout ? 'full-screen-menu' : 'mobile-menu';

		if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
			$args->after = '<button type="button" class="qodef-' . $arrow_class . '-item-arrow" aria-expanded="false" aria-label="' . esc_attr__( 'Open the menu', 'qi-blocks-premium' ) . '"><span class="screen-reader-text">' . esc_html__( 'Show sub menu', 'qi-blocks-premium' ) . '</span>' . qi_blocks_get_svg_icon( 'menu-arrow-right' ) . '</button>';
		}

		return $args;
	}
}

Qi_Blocks_Premium_Nav_Menu::get_instance();

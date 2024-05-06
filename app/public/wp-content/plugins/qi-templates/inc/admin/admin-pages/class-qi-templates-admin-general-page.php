<?php

if ( ! class_exists( 'Qi_Templates_Admin_General_Page' ) ) {
	class Qi_Templates_Admin_General_Page {
		private static $instance;
		private $menu_slug;
		private $title;
		private $sub_pages;
		private $transient;

		function __construct() {
			$this->menu_slug = 'qi_templates_welcome';
			$this->title     = esc_html__( 'Qi Templates', 'qi-templates' );
			$this->transient = 'qi_templates_set_redirect';

			add_action( 'init', array( $this, 'register_sub_pages' ) );

			add_action( 'admin_menu', array( $this, 'dashboard_add_page' ) );

			add_action( 'admin_init', array( $this, 'redirect' ) );

			add_filter( 'admin_body_class', array( $this, 'add_admin_body_classes' ) );
		}

		/**
		 * @return Qi_Templates_Admin_General_Page
		 */
		public static function get_instance() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function set_sub_pages( Qi_Templates_Admin_Sub_Pages $sub_page ) {
			$this->sub_pages[ $sub_page->get_position() ] = $sub_page;
		}

		function get_sub_pages() {
			return $this->sub_pages;
		}

		function get_menu_slug() {
			return $this->menu_slug;
		}

		function get_title() {
			return $this->title;
		}

		function dashboard_add_page() {
			$page = add_menu_page(
				$this->get_title(),
				$this->get_title(),
				'edit_theme_options',
				$this->get_menu_slug(),
				null,
				QI_TEMPLATES_ADMIN_URL_PATH . '/admin-pages/assets/img/logo-qi.png',
				998
			);

			add_action( 'load-' . $page, array( $this, 'load_admin_css' ) );

			$subpages_array = $this->get_sub_pages();

			ksort( $subpages_array );

			foreach ( $subpages_array as $key => $sub_page ) {
				$sub_page_instance = add_submenu_page(
					$this->get_menu_slug(),
					$sub_page->get_title(),
					$sub_page->get_title(),
					'edit_theme_options',
					$sub_page->get_menu_slug(),
					array( $sub_page, 'render' ),
					$sub_page->get_position()
				);

				add_action( 'load-' . $sub_page_instance, array( $this, 'load_admin_css' ) );
			}
		}

		function get_header( $object = null ) {
			$object = ! empty( $object ) ? $object : $this;

			$args = array(
				'welcome_page_title' => Qi_Templates_Admin_General_Page::get_instance()->get_title(),
				'menu_slug'          => $object->get_menu_slug(),
				'menu_title'         => $object->get_title(),
				'menu_url'           => admin_url( 'admin.php?page=' . $this->get_menu_slug() ),
			);

			qi_templates_template_part( 'admin/admin-pages', 'templates/header', '', $args );
		}

		function get_footer() {
			qi_templates_template_part( 'admin/admin-pages', 'templates/footer' );
		}

		function get_sidebar() {
			qi_templates_template_part( 'admin/admin-pages', 'templates/sidebar' );
		}

		function get_content() {
			qi_templates_template_part( 'admin/admin-pages', 'templates/general' );
		}

		function render_holder() {
			$args = array(
				'this_object' => $this,
			);

			qi_templates_template_part( 'admin/admin-pages', 'templates/holder', '', $args );
		}

		public function register_sub_pages() {
			$sub_pages = apply_filters( 'qi_templates_filter_add_sub_page', array() );

			if ( ! empty( $sub_pages ) ) {
				foreach ( $sub_pages as $sub_page ) {

					if ( class_exists( $sub_page ) ) {
						$sub_object = new $sub_page();
						$this->set_sub_pages( $sub_object );
					}
				}
			}
		}

		function load_admin_css() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		function enqueue_styles() {
			wp_enqueue_style( 'qi-templates-dashboard-style', QI_TEMPLATES_ADMIN_URL_PATH . '/admin-pages/assets/css/dashboard.min.css' );
		}

		function enqueue_scripts() {
			do_action( 'qi_templates_action_admin_pages_additional_scripts' );
		}

		function add_admin_body_classes( $classes ) {
			$pages = $this->get_all_dashboard_slugs();

			if ( isset( $_GET['page'] ) && in_array( $_GET['page'], $pages, true ) ) {
				$classes = $classes . ' qi-templates-dashboard';
			}

			return $classes;
		}

		function get_all_dashboard_slugs() {
			$pages = array(
				$this->get_menu_slug(),
			);

			foreach ( $this->sub_pages as $sub_page ) {
				$pages[] = $sub_page->get_menu_slug();
			}

			return $pages;
		}

		function redirect() {

			if ( wp_doing_ajax() ) {
				return;
			}

			if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
				return;
			}

			if ( ! empty( get_transient( QI_TEMPLATES_ACTIVATED_TRANSIENT ) ) && empty( get_transient( $this->transient ) ) ) {
				set_transient( $this->transient, 1 );

				wp_safe_redirect(
					esc_url( admin_url( 'admin.php?page=' . $this->get_menu_slug() ) )
				);

				exit;
			}

		}

	}

	Qi_Templates_Admin_General_Page::get_instance();
}

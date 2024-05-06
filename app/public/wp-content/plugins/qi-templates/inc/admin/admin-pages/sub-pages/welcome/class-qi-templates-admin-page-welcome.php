<?php

if ( ! function_exists( 'qi_templates_add_welcome_sub_page_to_list' ) ) {
	/**
	 * Function that add additional sub-page item into general page list
	 *
	 * @param array $sub_pages
	 *
	 * @return array
	 */
	function qi_templates_add_welcome_sub_page_to_list( $sub_pages ) {
		$sub_pages[] = 'Qi_Templates_Admin_Page_Welcome';

		return $sub_pages;
	}

	add_filter( 'qi_templates_filter_add_sub_page', 'qi_templates_add_welcome_sub_page_to_list' );
}

if ( class_exists( 'Qi_Templates_Admin_Sub_Pages' ) ) {
	class Qi_Templates_Admin_Page_Welcome extends Qi_Templates_Admin_Sub_Pages {
		private static $instance;

		public function __construct() {
			parent::__construct();

			add_action( 'qi_templates_action_admin_pages_additional_scripts', array( $this, 'set_additional_scripts' ) );
		}

		/**
		 * @return Qi_Templates_Admin_Page_Welcome
		 */
		public static function get_instance() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function add_sub_page() {
			$this->set_base( 'welcome' );
			$this->set_menu_slug( 'qi_templates_welcome' );
			$this->set_title( esc_html__( 'Welcome Page', 'qi-templates' ) );
			$this->set_position( 1 );
		}

		function set_additional_scripts() {
			if ( isset( $_GET['page'] ) && $_GET['page'] === $this->get_menu_slug() ) {
				wp_enqueue_script( 'mailchimp', QI_TEMPLATES_ADMIN_URL_PATH . '/admin-pages/assets/plugins/mailchimp/mailchimp.min.js', array( 'jquery' ), false, true );
			}
		}
	}
}

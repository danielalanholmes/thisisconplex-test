<?php

if ( ! function_exists( 'qi_templates_add_import_sub_page_to_list' ) ) {
	/**
	 * Function that add additional sub page item into general page list
	 *
	 * @param array $sub_pages
	 *
	 * @return array
	 */
	function qi_templates_add_import_sub_page_to_list( $sub_pages ) {

		$demos = qi_templates_fetch_demos();
		if ( ! empty( $demos ) && qi_templates_is_plugin_activated() ) {
			$sub_pages[] = 'Qi_Templates_Admin_Sub_Page_Import';
		}

		return $sub_pages;
	}

	add_filter( 'qi_templates_filter_add_sub_page', 'qi_templates_add_import_sub_page_to_list' );
}

if ( class_exists( 'Qi_Templates_Admin_Sub_Pages' ) ) {
	class Qi_Templates_Admin_Sub_Page_Import extends Qi_Templates_Admin_Sub_Pages {
		private static $instance;

		public function __construct() {
			parent::__construct();

			add_action( 'qi_templates_action_admin_pages_additional_scripts', array( $this, 'set_additional_scripts' ) );
			add_action( 'wp_ajax_qi_templates_open_demo_single', array( $this, 'open_demo_single' ) );
			add_action( 'wp_ajax_qi_templates_reload_demo_import', array( $this, 'reload_demo_import' ) );
		}

		/**
		 * @return Qi_Templates_Admin_Sub_Page_Import
		 */
		public static function get_instance() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function add_sub_page() {
			$this->set_base( 'import-page' );
			$this->set_menu_slug( 'qi_templates_import_page' );
			$this->set_title( esc_html__( 'Import', 'qi-templates' ) );
			$this->set_position( 2 );
		}

		function render() {
			$args                   = $this->get_atts();
			$args['this_object']    = $this;
			$args['holder_classes'] = isset( $_GET['demo-id'] ) ? 'qodef-demo-import-single-opened' : '';

			qi_templates_template_part( 'admin/admin-pages/sub-pages/import', 'templates/holder', '', $args );
		}

		function get_content() {
			$params                       = array();
			$params['import_title']       = esc_html__( 'Find a demo you wish to import', 'qi-templates' );
			$params['welcome_page_url']   = admin_url( 'admin.php?page=' . Qi_Templates_Admin_Page_Welcome::get_instance()->get_menu_slug() );
			$params['welcome_page_title'] = Qi_Templates_Admin_Page_Welcome::get_instance()->get_title();
			$params['demos']              = qi_templates_fetch_demos();
			$params['categories']         = qi_templates_fetch_demo_categories();
			$params['page_name']          = $this->get_menu_slug();
			$params['single_demo']        = isset( $_GET['demo-id'] ) ? $params['demos'][ $_GET['demo-id'] ] : '';
			$params['single_demo_id']     = isset( $_GET['demo-id'] ) ? $_GET['demo-id'] : '';
			$params['content_files']      = isset( $_GET['demo-id'] ) ? $this->count_files( $params['demos'][ $_GET['demo-id'] ] ) : '';
			$params['this_object']        = $this;

			qi_templates_template_part( 'admin/admin-pages/sub-pages/import', '/templates/content', 'demos', $params );
		}

		function set_additional_scripts() {
			if ( isset( $_GET['page'] ) && $_GET['page'] === $this->get_menu_slug() ) {
				wp_enqueue_style( 'swiper' );
				wp_enqueue_script( 'swiper' );
				wp_enqueue_script( 'isotope' );
				wp_enqueue_script( 'packery' );
				wp_enqueue_script( 'easyautocomplete' );
			}
		}

		function open_demo_single() {
			if ( isset( $_POST ) && ! empty( $_POST ) && '' !== $_POST['demoId'] ) {
				check_ajax_referer( 'qi_templates_demo_import_nonce', 'nonce' );
				$demo_id = $_POST['demoId'];
				$params  = array(
					'demo_id' => $demo_id,
				);

				if ( '' !== $demo_id ) {
					$demos                   = qi_templates_fetch_demos();
					$demo                    = $demos[ $demo_id ];
					$params['demo']          = $demo;
					$params['demo_key']      = $demo_id;
					$params['content_files'] = $this->count_files( $demos[ $demo_id ] );
					$html                    = qi_templates_get_template_part( 'admin/admin-pages/sub-pages/import', 'templates/content-single', '', $params );;

					qi_templates_get_ajax_status( 'success', esc_html__( 'Demo Opened', 'qi-templates' ), $html );
				}
			}

			wp_die();
		}

		function count_files( $demo ) {

			$files         = array();
			$content_files = 0;
			$other_files   = 0;

			if ( isset( $demo['demo_content_file_url'] ) ) {

				//posts + terms from xml file
				$content_files += 2;

				//attachments from xml file
				$chunk_files   = Qi_Templates_General_Import::get_instance()->get_chunk_number();
				$content_files += $chunk_files;
			}
			if ( isset( $demo['demo_widgets_file_url'] ) ) {
				$other_files += 1;
			}
			if ( isset( $demo['demo_settings_page_file_url'] ) ) {
				$other_files += 1;
			}
			if ( isset( $demo['demo_menu_settings_file_url'] ) ) {
				$other_files += 1;
			}
			if ( isset( $demo['demo_options'] ) ) {
				$other_files += 1;
			}

			$files['content_files'] = $content_files;
			$files['other_files']   = $other_files;

			return $files;
		}

		function reload_demo_import() {
			check_ajax_referer( 'qi_templates_reload_demo_import', 'nonce' );

			$params['demos']              = qi_templates_fetch_demos( false );
			$params['categories']         = qi_templates_fetch_demo_categories( false );
			$params['this_object']        = $this;

			$html = qi_templates_get_template_part( 'admin/admin-pages/sub-pages/import', '/templates/demos-list', '', $params );

			qi_templates_get_ajax_status( 'success', esc_html__( 'Demos Reloaded', 'qi-templates' ), $html );

			wp_die();
		}
	}
}

<?php
/*
Plugin Name: Qi Templates
Description: Templates for websites in all kinds of niches - from business to fashion, from tech to wedding. Developed by Qode Interactive.
Author: Qode Interactive
Author URI: https://qodeinteractive.com/
Plugin URI: https://qodeinteractive.com/qi-templates/
Version: 1.0.2
Requires at least: 5.8
Requires PHP: 7.0
Text Domain: qi-templates
*/
if ( ! class_exists( 'QiTemplates' ) ) {
	class QiTemplates {
		private static $instance;

		function __construct() {
			define( 'QI_TEMPLATES_PLUGIN_BASE_FILE', plugin_basename( __FILE__ ) ); // constant is defined here because it's not possible to get main plugin file name from constant.php ( it would return 'constant.php' itself )

			// Include required files
			require_once dirname( __FILE__ ) . '/constants.php';

			require_once QI_TEMPLATES_ABS_PATH . '/helpers/helper.php';

			// Make plugin available for translation
			add_action( 'plugins_loaded', array( $this, 'load_plugin_text_domain' ) );

			// Add plugin's body classes
			add_filter( 'body_class', array( $this, 'add_body_classes' ) );

			// Enqueue plugin's frontend assets
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'localize_js_scripts' ) );

			// Enqueue plugin's admin assets
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'localize_admin_js_scripts' ) );

			// Include plugin's modules
			$this->include_modules();
		}

		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function enqueue_assets() {

		}

		function localize_js_scripts() {

		}

		function enqueue_admin_assets() {
			// Register swiper scripts
			wp_register_style( 'swiper', QI_TEMPLATES_ASSETS_URL_PATH . '/css/plugins/swiper/swiper.min.css' );
			wp_register_script( 'swiper', QI_TEMPLATES_ASSETS_URL_PATH . '/js/plugins/swiper/swiper.min.js', array( 'jquery' ), false, true );

			// Register masonry scripts
			wp_register_script( 'isotope', QI_TEMPLATES_ASSETS_URL_PATH . '/js/plugins/isotope/isotope.pkgd.min.js', array( 'jquery' ), false, true );
			wp_register_script( 'packery', QI_TEMPLATES_ASSETS_URL_PATH . '/js/plugins/packery/packery-mode.pkgd.min.js', array( 'jquery' ), false, true );

			// Register autocomplete script
			wp_register_script( 'easyautocomplete', QI_TEMPLATES_ADMIN_URL_PATH . '/admin-pages/assets/plugins/easyautocomplete/jquery.easy-autocomplete.min.js', array( 'jquery' ), false, true );

			// Enqueue main admin js script
			wp_enqueue_script( 'qi-templates-admin', QI_TEMPLATES_URL_PATH . 'assets/js/qi-templates-admin.min.js', array( 'jquery' ), false, true );
		}

		function localize_admin_js_scripts() {
			wp_localize_script(
				'qi-templates-admin',
				'qiTemplatesAdmin',
				array(
					'vars' => apply_filters( 'qi_templates_filter_localize_admin_js', array() ),
				)
			);
		}

		function include_modules() {
			// Hook to include additional element before modules inclusion
			do_action( 'qi_templates_action_before_include_modules' );

			foreach ( glob( QI_TEMPLATES_INC_PATH . '/*/include.php' ) as $module ) {
				include_once $module;
			}

			// Hook to include additional element after modules inclusion
			do_action( 'qi_templates_action_after_include_modules' );
		}

		function load_plugin_text_domain() {
			load_plugin_textdomain( 'qi-templates', false, QI_TEMPLATES_REL_PATH . '/languages' );
		}

		function add_body_classes( $classes ) {
			$classes[] = 'qi-templates-' . QI_TEMPLATES_VERSION;

			return $classes;
		}
	}

	QiTemplates::get_instance();
}

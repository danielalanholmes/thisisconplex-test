<?php
/*
Plugin Name: Qi Blocks Premium
Plugin URI: https://qodeinteractive.com
Description: A selection of premium blocks for the Gutenberg block editor, developed by Qode Interactive.
Author: Qode Interactive
Author URI: https://qodeinteractive.com/
Plugin URI: https://qodeinteractive.com/qi-blocks-for-gutenberg/
Version: 1.0.6
Requires at least: 5.8
Requires PHP: 7.0
Text Domain: qi-blocks-premium
*/
if ( ! class_exists( 'Qi_Blocks_Premium' ) ) {
	class Qi_Blocks_Premium {
		private static $instance;

		public function __construct() {
			// Set the main plugin file name
			define( 'QI_BLOCKS_PREMIUM_PLUGIN_BASE_FILE', plugin_basename( __FILE__ ) );
			define( 'QI_BLOCKS_PREMIUM_PLUGIN_LANGUAGES_PATH', plugin_dir_path( __FILE__ ) . '/languages/' );

			// Include required files
			require_once dirname( __FILE__ ) . '/constants.php';

			// Check if Gutenberg editor exists
			if ( class_exists( 'WP_Block_Type' ) ) {
				require_once QI_BLOCKS_PREMIUM_ABS_PATH . '/helpers/helper.php';

				// Make plugin available for translation
				add_action( 'plugins_loaded', array( $this, 'load_plugin_text_domain' ) );

				// Add plugin's body classes
				add_filter( 'body_class', array( $this, 'add_body_classes' ) );

				// Include plugin's modules
				add_action( 'plugins_loaded', array( $this, 'include_modules' ), 11 ); // Permission 11 is set to be sure that free plugins is loaded
			}
		}

		/**
		 * @return Qi_Blocks_Premium
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function load_plugin_text_domain() {
			// Make plugin available for translation
			load_plugin_textdomain( 'qi-blocks-premium', false, QI_BLOCKS_PREMIUM_REL_PATH . '/languages' );
		}

		function add_body_classes( $classes ) {
			$classes[] = 'qi-blocks-premium-' . QI_BLOCKS_PREMIUM_VERSION;

			return $classes;
		}

		function include_modules() {
			// Hook to include additional element before modules inclusion
			do_action( 'qi_blocks_premium_action_before_include_modules' );

			if ( class_exists( 'Qi_Blocks' ) ) {
				foreach ( glob( QI_BLOCKS_PREMIUM_INC_PATH . '/*/include.php' ) as $module ) {
					include_once $module;
				}
			}

			// Hook to include additional element after modules inclusion
			do_action( 'qi_blocks_premium_action_after_include_modules' );
		}
	}

	Qi_Blocks_Premium::get_instance();
}

if ( ! function_exists( 'qi_blocks_premium_activation_trigger' ) ) {
	/**
	 * Function that trigger hooks on plugin activation
	 */
	function qi_blocks_premium_activation_trigger() {

		// Hook to add additional code on plugin activation
		do_action( 'qi_blocks_premium_action_on_activation' );
	}

	register_activation_hook( __FILE__, 'qi_blocks_premium_activation_trigger' );
}

if ( ! function_exists( 'qi_blocks_premium_deactivation_trigger' ) ) {
	/**
	 * Function that trigger hooks on plugin deactivation
	 */
	function qi_blocks_premium_deactivation_trigger() {

		// Hook to add additional code on plugin deactivation
		do_action( 'qi_blocks_premium_action_on_deactivation' );
	}

	register_deactivation_hook( __FILE__, 'qi_blocks_premium_deactivation_trigger' );
}

if ( ! function_exists( 'qi_blocks_premium_check_requirements' ) ) {
	/**
	 * Function that check plugin requirements
	 */
	function qi_blocks_premium_check_requirements() {
		if ( ! defined( 'QI_BLOCKS_VERSION' ) ) {
			add_action( 'admin_notices', 'qi_blocks_premium_admin_notice_content' );
		}
	}

	add_action( 'plugins_loaded', 'qi_blocks_premium_check_requirements' );
}

if ( ! function_exists( 'qi_blocks_premium_admin_notice_content' ) ) {
	/**
	 * Function that display the error message if the requirements are not met
	 */
	function qi_blocks_premium_admin_notice_content() {
		echo sprintf( '<div class="notice notice-error"><p>%s</p></div>', esc_html__( 'Qi Blocks plugin is required for Qi Blocks Premium plugin to work properly. Please install/activate it first.', 'qi-blocks-premium' ) );

		if ( function_exists( 'deactivate_plugins' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
	}
}

<?php

if ( ! class_exists( 'Qi_Templates_Settings_Pages_Import' ) ) {
	class Qi_Templates_Settings_Pages_Import {

		/**
		 * @var instance of current class
		 */
		private static $instance;

		function __construct() {

		}

		/**
		 * @return Qi_Templates_Settings_Pages_Import
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function import( $demo ) {

			if ( isset( $demo['demo_settings_page_file_url'] ) ) {

				$fields = array(
					'show_on_front'  => get_option( 'show_on_front' ),
					'page_on_front'  => get_option( 'page_on_front' ),
					'page_for_posts' => get_option( 'page_for_posts' ),
				);

				$settings_url  = $demo['demo_settings_page_file_url'];
				$pages         = qi_templates_unserialize_base64_encoded_content( $settings_url );
				$new_ids       = get_transient( 'qi_templates_imported_posts' );
				$fields_status = true;

				if ( false !== $pages ) {

					if ( $pages['show_on_front'] !== $fields['show_on_front'] ) {
						$fields_status = update_option( 'show_on_front', $pages['show_on_front'] );
					}

					if ( false !== $new_ids ) {
						if ( 0 !== (int) $pages['page_on_front'] && ( (int) $new_ids[ $pages['page_on_front'] ] !== (int) $fields['page_on_front'] ) ) {
							$fields_status = update_option( 'page_on_front', $new_ids[ $pages['page_on_front'] ] );
						}
						if ( 0 !== (int) $pages['page_for_posts'] && ( (int) $new_ids[ $pages['page_for_posts'] ] !== (int) $fields['page_for_posts'] ) ) {
							$fields_status = update_option( 'page_for_posts', $new_ids[ $pages['page_for_posts'] ] );
						}
					} else {
						if ( 0 !== (int) $pages['page_on_front'] && ( (int) $pages['page_on_front'] !== (int) $fields['page_on_front'] ) ) {
							$fields_status = update_option( 'page_on_front', $pages['page_on_front'] );
						}
						if ( 0 !== (int) $pages['page_for_posts'] && ( (int) $pages['page_for_posts'] !== (int) $fields['page_for_posts'] ) ) {
							$fields_status = update_option( 'page_for_posts', $pages['page_for_posts'] );
						}
					}

					if ( false === $fields_status ) {
						qi_templates_get_ajax_status( 'error', esc_html__( 'Problem Occurred During Settings Pages Import', 'qi-templates' ) );
					} else {
						qi_templates_get_ajax_status( 'success', esc_html__( 'Settings Pages Imported Successfully', 'qi-templates' ) );
					}
				} else {
					qi_templates_get_ajax_status( 'error', esc_html__( 'Problem With File Content', 'qi-templates' ) );
				}
			}
		}

	}

}

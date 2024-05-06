<?php

if ( ! class_exists( 'Qi_Templates_Options_Import' ) ) {
	class Qi_Templates_Options_Import {

		/**
		 * @var instance of current class
		 */
		private static $instance;

		function __construct() {

		}

		/**
		 * @return Qi_Templates_Options_Import
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function import( $demo ) {

			if ( isset( $demo['demo_options'] ) ) {

				$demo_options  = $demo['demo_options'];
				$options_name  = $demo_options['demo_options_name'];
				$import_values = $demo_options['demo_options_file_url'];
				$file_format   = $demo_options['demo_options_file_format'];
				$return_value  = true;

				if ( ! empty( $import_values ) ) {
					if ( $file_format === 'txt' ) {
						$response = qi_templates_unserialize_base64_encoded_content( $import_values );
					} else if ( $file_format === 'json' ) {
						$response = qi_templates_decode_content( $import_values );
					}

					$current_options = get_option( $options_name );

					if ( $current_options != $response ) {
						if ( false !== $response ) {
							$status = update_option( $options_name, $response );

							if ( true !== $status ) {
								$return_value = false;
							}
						}
					}
				}

				if ( true === $return_value ) {
					$this->update_options_after_import( $demo );
					$this->adjust_wp_templates_with_current_theme();
					qi_templates_get_ajax_status( 'success', esc_html__( 'Options Imported Successfully', 'qi-templates' ) );
				} else {
					qi_templates_get_ajax_status( 'error', esc_html__( 'Problem Occurred During Options import', 'qi-templates' ) );
				}
			}

		}

		function update_options_after_import( $demo ) {
			global $wpdb;

			$url           = esc_url( home_url( '/' ) );
			$demo_url      = esc_url( $demo['demo_preview_url'] );
			$options_name  = $demo['demo_options']['demo_options_name'];
			$new_ids       = get_transient( 'qi_templates_imported_posts' );
			$options       = get_option( $options_name );
			$options_posts = ! empty( $options['posts'] ) ? $options['posts'] : '';

			//First update array indices ( if imported post ids are different from exported ones )
			if ( ! empty( $options_posts ) && is_array( $new_ids ) && count( $new_ids ) > 0 ) {
				foreach ( $new_ids as $old_post_id => $new_post_id ) {
					if ( $old_post_id !== $new_post_id ) {
						$options_posts = $this->change_array_indices( $options_posts, $old_post_id, $new_post_id );
					}
				}
			}

			$options['posts'] = $options_posts;
			update_option( $options_name, $options );

			//Then update options entries
			$sql_query = "SELECT option_id, option_value FROM {$wpdb->options} WHERE option_name = '" . $options_name . "';";
			$options   = $wpdb->get_results( $sql_query );
			$options   = ! empty( $options[0] ) ? $options[0] : '';

			if ( ! empty( $options ) ) {
				//Change domain url within style values
				$new_value = qi_templates_recalculate_serialized_lengths( str_replace( $demo_url, $url, $options->option_value ) );

				//Change post id ( if necessary ) within style selectors
				if ( is_array( $new_ids ) && count( $new_ids ) > 0 ) {
					foreach ( $new_ids as $old_post_id => $new_post_id ) {
						if ( $old_post_id !== $new_post_id ) {
							$new_value = qi_templates_recalculate_serialized_lengths( str_replace( 'body[class*="-' . $old_post_id . '"]', 'body[class*="-' . $new_post_id . '"]', $new_value ) );
						}
					}
				}

				$wpdb->update( $wpdb->options, array( 'option_value' => $new_value ), array( 'option_id' => $options->option_id ) );
			}
		}

		function change_array_indices( $array, $old_key, $new_key ) {
			if ( ! array_key_exists( $old_key, $array ) ) {
				return $array;
			}

			$keys                                    = array_keys( $array );
			$keys[ array_search( $old_key, $keys ) ] = $new_key;

			return array_combine( $keys, $array );
		}

		function adjust_wp_templates_with_current_theme( $old_theme_slug = 'twentytwentytwo' ) {
			global $wpdb;

			$current_theme      = function_exists( 'wp_get_theme' ) ? wp_get_theme() : '';
			$current_theme_slug = ! empty( $current_theme ) ? $current_theme->get_stylesheet() : '';

			if ( ! empty( $current_theme_slug ) && $current_theme_slug !== $old_theme_slug ) {
				$current_theme_term = get_term_by( 'slug', $current_theme_slug, 'wp_theme' );
				$old_theme_term     = get_term_by( 'slug', $old_theme_slug, 'wp_theme' );

				if ( is_object( $current_theme_term ) && is_object( $old_theme_term ) ) {
					$current_theme_term_id = $current_theme_term->term_id;
					$old_theme_term_id     = $old_theme_term->term_id;

					if ( ! empty( $current_theme_term_id ) && ! empty( $old_theme_term_id ) ) {
						$sql_query       = $wpdb->prepare( "SELECT object_id FROM {$wpdb->term_relationships} WHERE term_taxonomy_id = %s", $old_theme_term_id );
						$objects_results = $wpdb->get_results( $sql_query );

						$objects_ids = array();
						if ( is_array( $objects_results ) && count( $objects_results ) > 0 ) {
							foreach ( $objects_results as $objects_result ) {
								$objects_ids[] = $objects_result->object_id;
							}
						}

						$sql_query = $wpdb->prepare( "UPDATE {$wpdb->term_relationships} SET term_taxonomy_id = %s WHERE term_taxonomy_id = %s", $current_theme_term_id, $old_theme_term_id );
						$wpdb->query( $sql_query );

						if ( count( $objects_ids ) > 0 ) {

							// Make placeholder for $wpdb->prepare formatting, so it can be used with arrays and mysql IN properly
							$strings_placeholders = array_fill( 0, count( $objects_ids ), '%s' );
							$strings_placeholders = implode( ',', $strings_placeholders );

							$sql_query    = $wpdb->prepare( "SELECT ID, post_content FROM {$wpdb->posts} WHERE post_type = 'wp_template' AND ID IN ($strings_placeholders)", $objects_ids );
							$post_results = $wpdb->get_results( $sql_query );

							if ( is_array( $post_results ) && count( $post_results ) > 0 ) {
								foreach ( $post_results as $post_result ) {
									$changed_content = str_replace( $old_theme_slug, $current_theme_slug, $post_result->post_content );
									$sql_query       = $wpdb->prepare( "UPDATE {$wpdb->posts} SET post_content = %s WHERE ID = %s", $changed_content, $post_result->ID );
									$wpdb->query( $sql_query );
								}
							}
						}
					}
				}
			}
		}
	}
}

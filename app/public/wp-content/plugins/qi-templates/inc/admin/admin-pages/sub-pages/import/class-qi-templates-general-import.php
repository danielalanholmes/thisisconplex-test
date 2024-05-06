<?php

if ( ! class_exists( 'Qi_Templates_General_Import' ) ) {
	class Qi_Templates_General_Import {

		/**
		 * @var instance of current class
		 */
		private static $instance;
		private $chunk_number;
		private $import_images;
		private $transient_name;

		function __construct() {

			add_action( 'after_setup_theme', array( $this, 'load_importer_files' ) );

			$this->chunk_number   = 10;
			$this->import_images  = true;
			$this->transient_name = 'qi_templates_import_block_';

			// start import
			add_action( 'wp_ajax_qi_templates_import_action', array( &$this, 'import_action' ) );

		}

		/**
		 * @return Qi_Templates_General_Import
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function load_importer_files() {
			require_once QI_TEMPLATES_INC_PATH . '/wp/wp-importer/wordpress-importer.php';
		}

		function get_chunk_number() {
			return $this->chunk_number;
		}

		public function import_action() {

			if ( isset( $_POST ) || ! empty( $_POST ) ) {

				if ( wp_verify_nonce( $_POST['options']['nonce'], 'qi_templates_import_nonce' ) ) {

					$demo_key  = $_POST['options']['demo'];
					$demo_list = qi_templates_fetch_demos();
					$demo      = $demo_list[ $demo_key ];

					switch ( $_POST['options']['action'] ) :
						case 'settings-page':
							Qi_Templates_Settings_Pages_Import::get_instance()->import( $demo );
							break;
						case 'options':
							Qi_Templates_Options_Import::get_instance()->import( $demo );
							break;
						case 'content':
							$this->adjust_page_template();
							$this->import_content( $demo, $_POST['options'] );
							break;
					endswitch;
				}
			}

			wp_die();
		}

		public function adjust_page_template() {
			global $wpdb;

			$current_templates = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}posts WHERE post_name = 'wp-custom-template-qi-blocks-full-width'" );

			if ( is_array( $current_templates ) && count( $current_templates ) > 0 ) {
				foreach ( $current_templates as $current_template ) {
					wp_delete_post( $current_template->ID );
				}
			}
		}

		public function import_content( $demo, $options ) {

			$options_type = isset( $options['contentType'] ) ? $options['contentType'] : 'posts';
			$demo_url     = $demo['demo_content_file_url'];

			switch ( $options_type ) :
				case 'posts':
					$this->import_posts( $demo_url, $demo );
					break;
				case 'attachments':
					$this->import_images = isset( $_POST['options']['images'] ) && 1 === (int) $_POST['options']['images'] ? true : false;
					$this->import_attachments( $options['attachmentNumber'], $demo );
					break;
				case 'terms':
					$this->import_terms( $demo_url );
					break;
			endswitch;

		}

		public function import_terms( $demo_url ) {

			ob_start();

			if ( qi_templates_is_installed( 'woocommerce' ) ) {
				add_filter( 'wp_import_posts', array( $this, 'process_wc_attributes' ) );
			}

			add_filter( 'wp_import_posts', array( $this, 'save_block_attachments' ) );

			$import_object = new Qi_Templates_WP_Import();
			set_time_limit( 0 );
			$import_object->import( $demo_url );

			$attachments_blocks = apply_filters( 'qi_templates_filter_import_attachments_blocks', 0 );

			ob_get_clean();

			qi_templates_get_ajax_status( 'success', esc_html__( 'Terms Imported Successfully', 'qi-templates' ), array( 'number_of_blocks' => $attachments_blocks ) );

		}

		public function import_attachments( $i, $demo ) {
			$ajax_data                     = array();
			$ajax_data['attachment_block'] = $i;

			if ( false === $this->import_images ) {
				qi_templates_get_ajax_status( 'success', esc_html__( 'Skip Import Attachments', 'qi-templates' ), $ajax_data );
			}

			$attachments = get_transient( $this->transient_name . $i );

			if ( ! empty( $attachments ) ) {

				$import_results            = $this->proceed_attachments( $i, $attachments );
				$ajax_data['imported_ids'] = $import_results;

				$this->adjust_cropped_images( $import_results, $demo );

				//if ( true === $import_results ) {
				qi_templates_get_ajax_status( 'success', esc_html__( 'Attachments Imported Successfully - Block ', 'qi-templates' ) . $i, $ajax_data );
				//}

			}
		}

		public function proceed_attachments( $block, $attachments, $imported = array(), $errors = array() ) {

			ob_start();
			$import_object = new Qi_Templates_WP_Import();
			set_time_limit( 0 );

			add_filter( 'upload_mimes', array( $this, 'enable_svg_import' ) );

			$import_object->fetch_attachments = $this->import_images;

			$import_object->posts = $attachments;
			$import_results       = $import_object->process_posts();
			ob_get_clean();

			$imported_ids = apply_filters( 'qi_templates_filter_import_attachments_success', $imported );
			$error_ids    = apply_filters( 'qi_templates_filter_import_attachments_errors', $errors );

			if ( count( $attachments ) !== count( $imported_ids ) ) {
				$this->proceed_attachments( $block, array_intersect_key( $attachments, $error_ids ), $imported_ids, $error_ids );
			} else {
				delete_transient( $this->transient_name . $block );
			}

			return $imported_ids;
		}

		public function import_posts( $demo_url, $demo ) {

			ob_start();

			add_filter( 'wp_import_posts', array( $this, 'prepare_posts' ) );
			add_filter( 'wp_import_categories', array( $this, 'prepare_terms' ) );
			add_filter( 'wp_import_tags', array( $this, 'prepare_terms' ) );
			add_filter( 'wp_import_terms', array( $this, 'prepare_terms' ) );

			$import_object = new Qi_Templates_WP_Import();
			set_time_limit( 0 );

			$import_object->import( $demo_url );

			ob_get_clean();

			$this->update_content_after_import( $demo );

			qi_templates_get_ajax_status( 'success', esc_html__( 'Posts Imported Successfully', 'qi-templates' ) );


		}

		function save_block_attachments( $posts ) {

			$attachments        = array();
			$attachments_blocks = array();

			foreach ( $posts as $post ) {

				if ( 'attachment' === $post['post_type'] ) {
					$attachments[ $post['post_id'] ] = $post;
				}
			}

			$attachments_blocks = array_chunk( $attachments, $this->chunk_number, true );
			$number_of_blocks   = count( $attachments_blocks );

			if ( $number_of_blocks > 0 ) {
				for ( $i = 1; $i <= $number_of_blocks; $i ++ ) {
					set_transient( $this->transient_name . $i, $attachments_blocks[ $i - 1 ] );
				}
			}

			add_filter(
				'qi_templates_filter_import_attachments_blocks',
				function () use ( $number_of_blocks ) {
					return $number_of_blocks;
				},
				10,
				2
			);

			set_transient( 'qi_templates_total_import_blocks', $number_of_blocks );

			$posts = array();

			return $posts;

		}

		public function prepare_posts( $posts ) {
			$posts_wa = array();

			foreach ( $posts as $post ) {
				if ( 'attachment' !== $post['post_type'] ) {
					$posts_wa[] = $post;
				}
			}

			return $posts_wa;

		}

		public function prepare_terms( $terms ) {

			$terms = array();

			return $terms;

		}

		public function enable_svg_import( $mimes ) {

			$mimes['svg'] = 'image/svg+xml';

			return $mimes;

		}

		function process_wc_attributes( $posts ) {

			foreach ( $posts as $post ) {
				if ( 'product' === $post['post_type'] && ! empty( $post['terms'] ) ) {
					foreach ( $post['terms'] as $term ) {
						if ( strstr( $term['domain'], 'pa_' ) ) {
							if ( ! taxonomy_exists( $term['domain'] ) ) {
								$attribute_name = wc_attribute_taxonomy_slug( $term['domain'] );

								// Create the taxonomy.
								if ( ! in_array( $attribute_name, wc_get_attribute_taxonomies(), true ) ) {
									wc_create_attribute(
										array(
											'name'         => $attribute_name,
											'slug'         => $attribute_name,
											'type'         => 'select',
											'order_by'     => 'menu_order',
											'has_archives' => false,
										)
									);
								}

								// Register the taxonomy now so that the import works!
								register_taxonomy(
									$term['domain'],
									apply_filters( 'woocommerce_taxonomy_objects_' . $term['domain'], array( 'product' ) ),
									apply_filters(
										'woocommerce_taxonomy_args_' . $term['domain'],
										array(
											'hierarchical' => true,
											'show_ui'      => false,
											'query_var'    => true,
											'rewrite'      => false,
										)
									)
								);
							}
						}
					}
				}
			}

			return $posts;
		}

		function update_content_after_import( $demo ) {
			global $wpdb;

			$url      = esc_url( home_url( '/' ) );
			$demo_url = esc_url( $demo['demo_preview_url'] );

			$sql_query      = "SELECT ID, post_content FROM {$wpdb->posts} WHERE post_content LIKE '%" . esc_url( $demo_url ) . "%';";
			$posts_contents = $wpdb->get_results( $sql_query );

			if ( ! empty( $posts_contents ) ) {
				foreach ( $posts_contents as $posts_content ) {
					$new_value = qi_templates_recalculate_serialized_lengths( str_replace( $demo_url, $url, $posts_content->post_content ) );

					$wpdb->update( $wpdb->posts, array( 'post_content' => $new_value ), array( 'ID' => $posts_content->ID ) );
				}
			}
		}

		function adjust_cropped_images( $imported_attachments, $demo ) {
			$cropped_images_file_url = $demo['demo_cropped_images_file_url'];
			$cropped_images          = qi_templates_unserialize_base64_encoded_content( $cropped_images_file_url );

			if ( is_array( $cropped_images ) && count( $cropped_images ) > 0 ) {
				foreach ( $cropped_images as $cropped_image ) {
					$old_attachment_id = intval( $cropped_image['attachment_id'] );

					if ( array_key_exists( $old_attachment_id, $imported_attachments ) ) {
						$new_attachment_id = $imported_attachments[ $old_attachment_id ];

						$custom_size = array(
							'width'  => intval( $cropped_image['width'] ),
							'height' => intval( $cropped_image['height'] ),
						);

						qi_templates_resize_image( $new_attachment_id, $custom_size );
					}
				}
			}
		}
	}

	Qi_Templates_General_Import::get_instance();
}

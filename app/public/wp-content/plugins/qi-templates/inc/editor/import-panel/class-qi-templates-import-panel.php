<?php

require_once( ABSPATH . 'wp-admin/includes/image.php' );

if ( ! class_exists( 'Qi_Templates_Import_Panel' ) ) {
	class Qi_Templates_Import_Panel {
		private static $instance;

		public function __construct() {

			// Add popup button
			add_action( 'admin_footer', array( $this, 'print_admin_import_button_template_script' ) );

			// Add popup
			add_action( 'admin_footer', array( $this, 'print_admin_import_modal_template' ) );

			// Handle import data reloading
			add_action( 'wp_ajax_qi_templates_action_reload_import_data', array( $this, 'reload_import_data' ) );

			// Handle import list functionality
			add_action( 'wp_ajax_qi_templates_action_import_list', array( $this, 'import_list' ) );

			// Handle import item functionality
			add_action( 'wp_ajax_qi_templates_action_import_item', array( $this, 'import_item' ) );

			// Enqueue necessary scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

			// Enqueue plugin's editor assets
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_blocks_editor_assets' ) );
		}

		/**
		 * @return Qi_Templates_Import_Panel
		 */
		public static function get_instance() {
			$demos = qi_templates_fetch_demos();
			if ( ! empty( $demos ) && qi_templates_is_plugin_activated() && is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function is_editor_page() {
			$current_screen = get_current_screen();

			return $current_screen->is_block_editor;
		}

		function enqueue_admin_scripts() {
			if ( $this->is_editor_page() ) {
				wp_enqueue_script( 'isotope' );
				wp_enqueue_script( 'packery' );
				wp_enqueue_script( 'easyautocomplete' );
			}
		}

		function enqueue_blocks_editor_assets() {
			wp_enqueue_style( 'qi-templates-import-panel', QI_TEMPLATES_INC_URL_PATH . '/editor/import-panel/assets/css/import-default.min.css' );
		}

		function print_admin_import_button_template_script() {
			if ( $this->is_editor_page() ) { ?>
				<script id="qodef-import-modal-button-trigger" type="text/html">
					<?php qi_templates_template_part( 'editor/import-panel', 'templates/import-button' ); ?>
				</script>
			<?php }
		}

		function print_admin_import_modal_template() {
			if ( $this->is_editor_page() ) {
				qi_templates_template_part( 'editor/import-panel', 'templates/import-modal' );
			}
		}

		function save_as_file( $file_name, $output, $save_to_file = false ) {
			if ( $save_to_file ) {
				$upload_dir = wp_upload_dir();
				if ( file_put_contents( $upload_dir['path'] . '/' . $file_name, $output ) ) {
					return array(
						'full_path' => $upload_dir['path'] . '/' . $file_name,
						'filename'  => $file_name
					);
				}

				return false;
			} else {
				header( "Content-type: application/text", true, 200 );
				header( "Content-Disposition: attachment; filename=$file_name" );
				header( "Pragma: no-cache" );
				header( "Expires: 0" );
				print $output;
				exit;
			}
		}

		function reload_import_data() {
			check_ajax_referer( 'qi_templates_reload_import_data_nonce', 'nonce' );

			$patterns   = qi_templates_fetch_patterns( false );
			$templates  = qi_templates_fetch_templates( false );
			$wireframes = qi_templates_fetch_wireframes( false );

			if ( $patterns && $templates && $wireframes ) {
				qi_templates_get_ajax_status( 'success', esc_html__( 'Import data successfully reloaded', 'qi-templates' ) );
			}

			qi_templates_get_ajax_status( 'fail', esc_html__( 'Something went wrong. Please try again later.', 'qi-templates' ) );
		}

		function import_list() {
			check_ajax_referer( 'qi_templates_list_nonce', 'nonce' );

			$type = $_POST['type'];

			if ( 'initialize' === $type ) {
				$import_type = 'patterns';
			} else {
				$import_type = $_POST['import_type'];
			}

			switch ( $import_type ) {
				case 'templates':
					$list_items = qi_templates_fetch_templates();
					break;
				case 'wireframes':
					$list_items = qi_templates_fetch_wireframes();
					break;
				default:
					$list_items = qi_templates_fetch_patterns();
					break;
			}

			$params['list_items']  = $list_items;
			$params['import_type'] = $import_type;

			$html = qi_templates_get_template_part( 'editor/import-panel', 'templates/parts/import-list', '', $params );

			if ( ! empty( $html ) ) {
				qi_templates_get_ajax_status( 'success', esc_html__( 'Results filtered successfully', 'qi-templates' ), $html );
			} else {
				qi_templates_get_ajax_status( 'fail', esc_html__( 'Something went wrong. Please try again later.', 'qi-templates' ) );
			}

			qi_templates_get_ajax_status( 'fail', esc_html__( 'Something went wrong. Please try again later.', 'qi-templates' ) );
		}

		function import_item() {
			check_ajax_referer( 'qi_templates_item_nonce', 'nonce' );

			$import_type    = $_POST['import_type'];
			$import_item_id = $_POST['import_item_id'];

			// Post type and post id are necessary for checking whether post types of imported item and currently edited item are the same
			$post_type      = $_POST['post_type'];
			$post_id        = $_POST['post_id'];

			// While editing post/page page id is available but if you are adding new page/post there is post type within $_GET array that is passed through AJAX
			if( ! empty( $post_id ) ) {
				$post_type = get_post_type( $post_id );
			}

			switch ( $import_type ) {
				case 'templates':
					$list_items = qi_templates_fetch_templates();
					break;
				case 'wireframes':
					$list_items = qi_templates_fetch_wireframes();
					break;
				default:
					$list_items = qi_templates_fetch_patterns();
					break;
			}

			$item_to_import = $list_items[ $import_item_id ];

			if ( ! empty( $item_to_import ) ) {
				$data = false;

				$required_plugins           = $item_to_import['required_plugins'];
				$essential_plugins          = array();
				$show_essential_plugins_box = false;

				if ( is_array( $required_plugins ) && count( $required_plugins ) > 0 ) {
					foreach ( $required_plugins as $plugin_slug => $required_plugin ) {
						if ( $required_plugin['essential'] ) {
							$essential_plugins[ $plugin_slug ] = $required_plugin;
						}
					}
				}

				if ( count( $essential_plugins ) > 0 ) {
					foreach ( $essential_plugins as $plugin => $plugin_value ) {
						$prepared_plugin = Qi_Templates_Install_Plugins::get_instance()->prepare_plugin( $plugin );
						if ( $prepared_plugin['status'] !== 'activated' ) {
							$show_essential_plugins_box = true;
							break;
						}
					}
				}

				if ( $show_essential_plugins_box ) {
					$params['demo']['required_plugins'] = $essential_plugins;

					$html['content'] = qi_templates_get_template_part( 'admin/admin-pages/sub-pages/import', 'templates/plugins', '', $params );
					$html['additional_info'] = esc_html__( 'Please note that after you successfully install/activate all essential plugins import process will continue automatically. Once the import is finished page will reload and you can continue editing it.', 'qi-templates' );

					qi_templates_get_ajax_status( 'install-plugins', esc_html__( 'Item imported successfully', 'qi-templates' ), $html );
				}

				if ( $import_type === 'patterns' || $import_type === 'wireframes' || $import_type === 'templates' ) {
					$data = $this->import_pattern_or_template( $item_to_import, $post_type, $import_type );
				}

				if ( $data ) {
					if( 'warning' === $data['status'] ) {

						$html['content'] = '<h3>' . esc_html__( 'Warning!', 'qi-templates' ) . '</h3>';
						$html['additional_info'] = $data['message'];

						qi_templates_get_ajax_status( 'warning', esc_html__( 'Item imported successfully', 'qi-templates' ), $html );
					} else {
						qi_templates_get_ajax_status( 'success', esc_html__( 'Item imported successfully', 'qi-templates' ), $data );
					}
				} else {
					qi_templates_get_ajax_status( 'fail', esc_html__( 'Something went wrong. Please try again later.', 'qi-templates' ) );
				}
			}

			qi_templates_get_ajax_status( 'fail', esc_html__( 'Something went wrong. Please try again later.', 'qi-templates' ) );
		}

		function import_pattern_or_template( $page, $post_type, $import_type ) {
			$result                     = array();
			$is_media_imported          = true;
			$is_media_cropping_adjusted = true;
			$is_wp_template_imported    = true;

			$content_file_url = $page['content_file_url'];
			$page_content     = qi_templates_decode_content( $content_file_url );

			if ( ! empty( $page_content ) ) {
				$post_content = $page_content['content'];
				$demo_url     = $page['demo_url'];

				//If demo url is not within main json check within exported content. This is usually used for wireframes since they do not have demo url stored in demos.json file
				if( empty( $demo_url ) ) {
					$demo_url = $page_content['demo_url'];
				}

				if( 'templates' === $import_type ) {
					if( 'page' === $post_type && 'post' === $page_content['post_type'] ) {
						$result['status'] = 'warning';
						$result['message'] = esc_html__( 'You are trying to import post template on page. Please import post template on post.', 'qi-templates' );

						return $result;
					}

					if( 'post' === $post_type && 'post' !== $page_content['post_type'] ) {
						$result['status'] = 'warning';
						$result['message'] = esc_html__( 'You are trying to import page template on post. Please import page template on page.', 'qi-templates' );

						return $result;
					}
				}

				if( isset( $page_content['post_template'] ) && isset( $page_content['post_template_title'] ) && isset( $page_content['post_template_content'] ) ) {
					$result['template'] = $page_content['post_template'];

					$demo_templates = array(
						'page_templates' => array(
							$page_content['post_template'] => array(
								'post_title' => $page_content['post_template_title'],
								'post_content' => $page_content['post_template_content'],
							)
						)
					);

					$is_wp_template_imported = $this->perform_wp_template_import( $demo_templates, $demo_url );
				}

				if ( ! empty( $demo_url ) ) {
					$post_content = $this->adjust_page_content_media_domain_name( $post_content, $demo_url );
				}

				if ( ! empty( $page_content['xml_media_export'] ) ) {
					$is_media_imported = $this->perform_xml_string_media_import( $page_content['xml_media_export'] );
				}

				if ( ! empty( $page_content['cropped_images'] ) ) {
					$is_media_cropping_adjusted = $this->adjust_cropped_images( $page_content['cropped_images'] );
				}

				if ( ! empty( $post_content ) && $is_media_imported && $is_media_cropping_adjusted && $is_wp_template_imported ) {
					$result['content'] = $post_content;

					return $result;
				}

				return false;
			}

			return false;
		}

		// TODO remove this and all related methods if not needed since it is unused for now but it is here as an example of importing WordPress templates and template parts
		function import_demo() {
			$demo_id = $_POST['demo_id'];
			$demos   = qi_templates_fetch_demos();
			if ( ! empty( $demos[ $demo_id ] ) ) {
				$demo           = $demos[ $demo_id ];
				$demo_templates = $demo['templates'];
				$demo_url       = $demo['demo_url'];

				if ( class_exists( 'Qi_Blocks_Page_Templates' ) ) {
					Qi_Blocks_Page_Templates::get_instance()->add_full_site_custom_page_template();
				};

				$imported_template_parts = $this->perform_wp_template_parts_import( $demo_templates, $demo_url );
				$imported_template       = $this->perform_wp_template_import( $demo_templates, $demo_url );
				$imported_media          = $this->perform_xml_string_media_import( $demo['xml_media_export'] );

				if ( ! $imported_template_parts || ! $imported_template || ! $imported_media ) {
					qi_templates_get_ajax_status( 'fail', esc_html__( 'Something went wrong. Please try again later.', 'qi-templates' ) );
				}

				qi_templates_get_ajax_status( 'success', esc_html__( 'Item imported successfully', 'qi-templates' ) );
			}

			qi_templates_get_ajax_status( 'fail', esc_html__( 'Something went wrong. Please try again later.', 'qi-templates' ) );
		}

		function import_wp_template_as_post( $key, $template, $post_type, $demo_url ) {
			global $wpdb;

			$existing_template = $wpdb->get_results( $wpdb->prepare( "SELECT `ID` FROM {$wpdb->prefix}posts WHERE post_name = %s", $key ) );

			$post_content = $template['post_content'];

			if ( ! empty( $demo_url ) ) {
				$post_content = $this->adjust_page_content_media_domain_name( $post_content, $demo_url );
			}

			$params                   = array();
			$params['post_status']    = 'publish';
			$params['post_type']      = $post_type;
			$params['comment_status'] = 'closed';
			$params['post_title']     = $template['post_title'];
			$params['post_content']   = $post_content;
			$params['post_name']      = $key;

			if ( is_array( $existing_template ) && count( $existing_template ) !== 0 ) {
				$params['ID'] = $existing_template[0]->ID;
			}

			return wp_insert_post( $params );
		}

		function perform_xml_string_media_import( $xml_file_content_as_string ) {
			if ( ! empty( $xml_file_content_as_string ) ) {
				$temp_file = $this->save_as_file( 'xml-media-temp-file.xml', $xml_file_content_as_string, true );
				if ( $temp_file ) {
					include_once QI_TEMPLATES_INC_PATH . '/wp/wp-importer/wordpress-importer.php';

					$importer    = new QI_Templates_WP_Import();
					$importer->fetch_attachments = true;
					$is_imported = $importer->import( $temp_file['full_path'] );
					unlink( $temp_file['full_path'] );

					return ! is_wp_error( $is_imported );
				}
			}

			return true;
		}

		function adjust_cropped_images( $cropped_images ) {
			$done = true;

			if ( is_array( $cropped_images ) && count( $cropped_images ) > 0 ) {
				foreach ( $cropped_images as $cropped_image ) {
					$done = $done && qi_templates_resize_image( $cropped_image['attachment_id'], array( 'width'  => $cropped_image['width'], 'height' => $cropped_image['height'] ) );
				}
			}

			return $done;
		}

		function adjust_page_content_media_domain_name( $post_content, $demo_url ) {
			return str_replace( $demo_url, esc_url( home_url( '/' ) ), $post_content );
		}

		function perform_wp_template_import( $template_to_import, $demo_url ) {
			$success = true;

			if ( is_array( $template_to_import['page_templates'] ) && count( $template_to_import['page_templates'] ) > 0 ) {
				foreach ( $template_to_import['page_templates'] as $key => $template ) {

					$post_id = $this->import_wp_template_as_post( $key, $template, 'wp_template', $demo_url );

					if ( ! $post_id ) {
						return false;
					} else {
						$success = $success && $this->connect_post_with_wp_template_or_part( $post_id, 'wp_template' );;
					}
				}
			}

			return $success;
		}

		function perform_wp_template_parts_import( $template_to_import, $demo_url ) {
			$template_parts_compact_array = array();

			if ( is_array( $template_to_import['header_templates'] ) && count( $template_to_import['header_templates'] ) > 0 ) {
				$template_parts_compact_array[ WP_TEMPLATE_PART_AREA_HEADER ] = $template_to_import['header_templates'];
			}

			if ( is_array( $template_to_import['footer_templates'] ) && count( $template_to_import['footer_templates'] ) > 0 ) {
				$template_parts_compact_array[ WP_TEMPLATE_PART_AREA_FOOTER ] = $template_to_import['footer_templates'];
			}

			$success = true;

			foreach ( $template_parts_compact_array as $area => $template_parts ) {
				if ( is_array( $template_parts ) && count( $template_parts ) > 0 ) {
					foreach ( $template_parts as $key => $template_part ) {

						$post_id = $this->import_wp_template_as_post( $key, $template_part, 'wp_template_part', $demo_url );

						if ( ! $post_id ) {
							return false;
						} else {
							$success = $success && $this->connect_post_with_wp_template_or_part( $post_id, 'wp_template_part_area', $area );
						}
					}
				}
			}

			return $success;
		}

		function connect_post_with_wp_template_or_part( $post_id, $type, $area = '' ) {
			$theme_slug = wp_get_theme()->get( 'TextDomain' );

			$term = get_term_by( 'slug', $theme_slug, 'wp_theme' );
			if ( ! is_object( $term ) ) {
				wp_create_term( $area, 'wp_theme' );
				$term = get_term_by( 'slug', $area, $type );
			}

			$term_id = $term->term_id;
			$success = wp_set_object_terms( $post_id, $term_id, 'wp_theme' );

			if ( is_wp_error( $success ) ) {
				return false;
			}

			if ( ! empty( $area ) ) {
				$term = get_term_by( 'slug', $area, $type );
				if ( ! is_object( $term ) ) {
					wp_create_term( $area, 'wp_template_part_area' );
					$term = get_term_by( 'slug', $area, $type );
				}
				$term_id = $term->term_id;
				$success = wp_set_object_terms( $post_id, $term_id, 'wp_template_part_area' );

				if ( is_wp_error( $success ) ) {
					return false;
				}
			}

			return true;
		}
	}

	Qi_Templates_Import_Panel::get_instance();
}

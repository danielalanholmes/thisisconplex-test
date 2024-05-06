<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'qi_templates_get_ajax_status' ) ) {
	/**
	 * Function that return status from ajax functions
	 *
	 * @param string $status - success or error
	 * @param string $message - ajax message value
	 * @param string|array $data - returned value
	 * @param string $redirect - url address
	 */
	function qi_templates_get_ajax_status( $status, $message, $data = null, $redirect = '' ) {
		$response = array(
			'status'   => esc_attr( $status ),
			'message'  => esc_html( $message ),
			'data'     => $data,
			'redirect' => ! empty( $redirect ) ? esc_url( $redirect ) : '',
		);

		$output = json_encode( $response );

		exit( $output ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'qi_templates_is_installed' ) ) {
	/**
	 * Function check is some plugin/theme is installed
	 *
	 * @param string $plugin name
	 *
	 * @return bool
	 */
	function qi_templates_is_installed( $plugin ) {
		switch ( $plugin ) :
			case 'qi-blocks':
				return defined( 'QI_BLOCKS_VERSION' );
			case 'woocommerce':
				return class_exists( 'WooCommerce' );
			default:
				return apply_filters( 'qi_templates_is_plugin_installed', false, $plugin );

		endswitch;
	}
}

if ( ! function_exists( 'qi_templates_execute_template_with_params' ) ) {
	/**
	 * Loads module template part.
	 *
	 * @param string $template path to template that is going to be included
	 * @param array $params params that are passed to template
	 *
	 * @return string - template html
	 */
	function qi_templates_execute_template_with_params( $template, $params ) {
		if ( ! empty( $template ) && file_exists( $template ) ) {
			// Extract params so they could be used in template
			if ( is_array( $params ) && count( $params ) ) {
				extract( $params ); // @codingStandardsIgnoreLine
			}

			ob_start();
			include $template;
			$html = ob_get_clean();

			return $html;
		} else {
			return '';
		}
	}
}

if ( ! function_exists( 'qi_templates_get_template_with_slug' ) ) {
	/**
	 * Loads module template part.
	 *
	 * @param string $temp temp path to file that is being loaded
	 * @param string $slug slug that should be checked if exists
	 *
	 * @return string - string with template path
	 */
	function qi_templates_get_template_with_slug( $temp, $slug ) {
		$template = '';

		if ( ! empty( $temp ) ) {
			if ( ! empty( $slug ) ) {
				$template = "$temp-$slug.php";

				if ( ! file_exists( $template ) ) {
					$template = $temp . '.php';
				}
			} else {
				$template = $temp . '.php';
			}
		}

		return $template;
	}
}

if ( ! function_exists( 'qi_templates_get_template_part' ) ) {
	/**
	 * Loads module template part.
	 *
	 * @param string $module name of the module from inc folder
	 * @param string $template full path of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @return string - string containing html of template
	 */
	function qi_templates_get_template_part( $module, $template, $slug = '', $params = array() ) {
		$temp = QI_TEMPLATES_INC_PATH . '/' . $module . '/' . $template;

		$template = qi_templates_get_template_with_slug( $temp, $slug );

		return qi_templates_execute_template_with_params( $template, $params );
	}
}

if ( ! function_exists( 'qi_templates_template_part' ) ) {
	/**
	 * Echo module template part.
	 *
	 * @param string $module name of the module from inc folder
	 * @param string $template full path of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 */
	function qi_templates_template_part( $module, $template, $slug = '', $params = array() ) {
		echo qi_templates_get_template_part( $module, $template, $slug, $params );
	}
}

if ( ! function_exists( 'qi_templates_class_attribute' ) ) {
	/**
	 * Function that echoes class attribute
	 *
	 * @param string|array $value - value of class attribute
	 *
	 * @see qi_templates_get_class_attribute()
	 */
	function qi_templates_class_attribute( $value ) {
		echo qi_templates_get_class_attribute( $value );
	}
}

if ( ! function_exists( 'qi_templates_get_class_attribute' ) ) {
	/**
	 * Function that returns generated class attribute
	 *
	 * @param string|array $value - value of class attribute
	 *
	 * @return string generated class attribute
	 *
	 * @see qi_templates_get_inline_attr()
	 */
	function qi_templates_get_class_attribute( $value ) {
		return qi_templates_get_inline_attr( $value, 'class', ' ' );
	}
}

if ( ! function_exists( 'qi_templates_id_attribute' ) ) {
	/**
	 * Function that echoes id attribute
	 *
	 * @param string|array $value - value of id attribute
	 *
	 * @see qi_templates_get_id_attribute()
	 */
	function qi_templates_id_attribute( $value ) {
		echo qi_templates_get_id_attribute( $value );
	}
}

if ( ! function_exists( 'qi_templates_get_id_attribute' ) ) {
	/**
	 * Function that returns generated id attribute
	 *
	 * @param string|array $value - value of id attribute
	 *
	 * @return string generated id attribute
	 *
	 * @see qi_templates_get_inline_attr()
	 */
	function qi_templates_get_id_attribute( $value ) {
		return qi_templates_get_inline_attr( $value, 'id', ' ' );
	}
}

if ( ! function_exists( 'qi_templates_inline_attrs' ) ) {
	/**
	 * Echo multiple inline attributes
	 *
	 * @param array $attrs
	 * @param bool $allow_zero_values
	 */
	function qi_templates_inline_attrs( $attrs, $allow_zero_values = false ) {
		echo qi_templates_get_inline_attrs( $attrs, $allow_zero_values );
	}
}

if ( ! function_exists( 'qi_templates_get_inline_attrs' ) ) {
	/**
	 * Generate multiple inline attributes
	 *
	 * @param array $attrs
	 * @param bool $allow_zero_values
	 *
	 * @return string
	 */
	function qi_templates_get_inline_attrs( $attrs, $allow_zero_values = false ) {
		$output = '';
		if ( is_array( $attrs ) && count( $attrs ) ) {
			if ( $allow_zero_values ) {
				foreach ( $attrs as $attr => $value ) {
					$output .= ' ' . qi_templates_get_inline_attr( $value, $attr, '', true );
				}
			} else {
				foreach ( $attrs as $attr => $value ) {
					$output .= ' ' . qi_templates_get_inline_attr( $value, $attr );
				}
			}
		}

		$output = ltrim( $output );

		return $output;
	}
}

if ( ! function_exists( 'qi_templates_get_inline_attr' ) ) {
	/**
	 * Function that generates html attribute
	 *
	 * @param string|array $value value of html attribute
	 * @param string $attr - name of html attribute to generate
	 * @param string $glue - glue with which to implode $attr. Used only when $attr is arrayed
	 * @param bool $allow_zero_values - allow data to have zero value
	 *
	 * @return string generated html attribute
	 */
	function qi_templates_get_inline_attr( $value, $attr, $glue = '', $allow_zero_values = false ) {
		if ( $allow_zero_values ) {
			if ( '' !== $value ) {

				if ( is_array( $value ) && count( $value ) ) {
					$properties = implode( $glue, $value );
				} else {
					$properties = $value;
				}

				return $attr . '="' . esc_attr( $properties ) . '"';
			}
		} else {
			if ( ! empty( $value ) ) {

				if ( is_array( $value ) && count( $value ) ) {
					$properties = implode( $glue, $value );
				} elseif ( '' !== $value ) {
					$properties = $value;
				} else {
					return '';
				}

				return $attr . '="' . esc_attr( $properties ) . '"';
			}
		}

		return '';
	}
}

if ( ! function_exists( 'qi_templates_get_attachment_id_from_url' ) ) {
	/**
	 * Function that retrieves attachment id for passed attachment url
	 *
	 * @param string $attachment_url
	 *
	 * @return null|string
	 */
	function qi_templates_get_attachment_id_from_url( $attachment_url ) {
		global $wpdb;
		$attachment_id = '';

		if ( '' !== $attachment_url ) {

			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid=%s", $attachment_url ) );

			// Additional check for undefined reason when guid is not image src
			if ( empty( $attachment_id ) ) {
				$modified_url = substr( $attachment_url, strrpos( $attachment_url, '/' ) + 1 );

				// Get attachment id
				$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_wp_attached_file' AND meta_value LIKE %s", '%' . $modified_url . '%' ) );
			}
		}

		return $attachment_id;
	}
}

if ( ! function_exists( 'qi_templates_resize_image' ) ) {
	/**
	 * Function that generates custom thumbnail for given attachment
	 *
	 * @param int|string $attachment - attachment id or url of image to resize
	 * @param array $custom_size desired - width and height of custom thumbnail
	 * @param bool $crop - whether to crop image or not
	 *
	 * @return array returns array containing img_url, width and height
	 *
	 * @see qi_templates_get_attachment_id_from_url()
	 * @see get_attached_file()
	 * @see wp_get_attachment_url()
	 * @see wp_get_image_editor()
	 */
	function qi_templates_resize_image( $attachment, $custom_size = array(), $crop = true ) {
		$return_array = array();

		if ( ! empty( $attachment ) ) {
			if ( is_int( $attachment ) ) {
				$attachment_id = $attachment;
			} else {
				$attachment_id = qi_templates_get_attachment_id_from_url( $attachment );
			}

			$is_size_set = ! empty( $custom_size ) && isset( $custom_size['width'] ) && isset( $custom_size['height'] );

			if ( ! empty( $attachment_id ) && $is_size_set ) {
				$width  = intval( $custom_size['width'] );
				$height = intval( $custom_size['height'] );

				// Get file path of the attachment
				$img_path = get_attached_file( $attachment_id );

				// Get attachment url
				$img_url = wp_get_attachment_url( $attachment_id );

				// Break down img path to array, so we can use its components in building thumbnail path
				$img_path_array = pathinfo( $img_path );

				// Build thumbnail path
				$new_img_path = $img_path_array['dirname'] . '/' . $img_path_array['filename'] . '-' . $width . 'x' . $height . '.' . $img_path_array['extension'];

				// Build thumbnail url
				$new_img_url = str_replace( $img_path_array['filename'], $img_path_array['filename'] . '-' . $width . 'x' . $height, $img_url );

				// Check if thumbnail exists by its path
				if ( ! file_exists( $new_img_path ) ) {
					// Get image manipulation object
					$image_object = wp_get_image_editor( $img_path );

					if ( ! is_wp_error( $image_object ) ) {
						// Resize image and save it new to path
						$image_object->resize( $width, $height, $crop );
						$image_object->save( $new_img_path );

						// Get sizes of newly created thumbnail.
						// We don't use $width and $height because those might differ from end result based on $crop parameter
						$image_sizes = $image_object->get_size();

						$width  = $image_sizes['width'];
						$height = $image_sizes['height'];
					} else {
						return array();
					}
				}

				// Generate data to be returned
				$return_array = array(
					'url'    => $new_img_url,
					'width'  => $width,
					'height' => $height,
				);

				// Attachment wasn't found in gallery, but it is not empty
			} elseif ( '' !== $attachment && $is_size_set ) {
				$width  = intval( $custom_size['width'] );
				$height = intval( $custom_size['height'] );

				// Generate data to be returned
				$return_array = array(
					'url'    => $attachment,
					'width'  => $width,
					'height' => $height,
				);
			}
		}

		return $return_array;
	}
}

if ( ! function_exists( 'qi_templates_decode_content' ) ) {
	/**
	 * Function that decode content
	 *
	 * @return array/bool
	 */
	function qi_templates_decode_content( $url ) {

		$content = qi_templates_get_file_content( $url );

		if ( false !== $content ) {
			$decoded_content = json_decode( $content, true );

			return $decoded_content;
		}

		return false;
	}
}

if ( ! function_exists( 'qi_templates_unserialize_base64_encoded_content' ) ) {
	/**
	 * Function that decode content
	 *
	 * @return string/bool
	 */
	function qi_templates_unserialize_base64_encoded_content( $url ) {
		$options = qi_templates_get_file_content( $url );

		if ( $options ) {
			return unserialize( base64_decode( $options ) );
		}

		return false;
	}
}

if ( ! function_exists( 'qi_templates_get_file_content' ) ) {
	/**
	 * Function that return file content
	 *
	 * @return bool
	 */
	function qi_templates_get_file_content( $url ) {

		$response = wp_remote_get( $url );

		if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
			return wp_remote_retrieve_body( $response );
		}

		return false;

	}
}

if ( ! function_exists( 'qi_templates_recalculate_serialized_lengths' ) ) {
	function qi_templates_recalculate_serialized_lengths( $s_object ) {
		$ret = preg_replace_callback(
			'!s:(\d+):"(.*?)";!',
			'qi_templates_recalculate_serialized_lengths_callback',
			$s_object
		);

		return $ret;
	}
}

if ( ! function_exists( 'qi_templates_recalculate_serialized_lengths_callback' ) ) {
	function qi_templates_recalculate_serialized_lengths_callback( $matches ) {
		return "s:" . strlen( $matches[2] ) . ":\"$matches[2]\";";
	}
}

if( ! function_exists( 'qi_templates_fetch_type_from_premium_cdn' ) ) {
	function qi_templates_fetch_type_from_premium_cdn( $type ) {
		$result = false;

		$api_uri        = 'https://api.qodeinteractive.com/qi-templates.php';
		$licence_key    = qi_templates_get_license();

		if ( false !== $licence_key && ! empty( $licence_key ) ) {

			$url = add_query_arg(
				array(
					'licence_key' => $licence_key,
					'url'         => home_url(),
					'item_id'     => QI_TEMPLATES_ITEM_ID,
					'item_name'   => rawurlencode( QI_TEMPLATES_ITEM_NAME ),
				),
				$api_uri
			);

			$response = wp_remote_get(
				$url,
				array(
					'user-agent' => 'WordPress/' . get_bloginfo( 'version' ) . '; ' . esc_url( home_url( '/' ) ),
					'timeout'    => 300,
				)
			);

			if ( is_wp_error( $response ) ) {
				return $response;
			}

			$code = wp_remote_retrieve_response_code( $response );

			if ( 200 === $code ) {
				$body         = wp_remote_retrieve_body( $response );
				$body_decoded = json_decode( $body, true );

				if ( ! empty( $body_decoded ) || is_array( $body_decoded ) ) {
					if( isset( $body_decoded[$type] ) ) {
						$result = $body_decoded[$type];
					}
				}
			}
		}

		return $result;
	}
}
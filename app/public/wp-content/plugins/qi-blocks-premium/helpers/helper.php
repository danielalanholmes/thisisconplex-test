<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'qi_blocks_premium_extend_block_categories' ) ) {
	/**
	 * Function that extend default array of block categories
	 *
	 * @param array $block_categories - Array of block categories
	 *
	 * @return array
	 */
	function qi_blocks_premium_extend_block_categories( $block_categories ) {

		return array_merge(
			array(
				array(
					'slug'  => 'qi-blocks-premium',
					'title' => esc_html__( 'Qi Blocks - Pro', 'qi-blocks-premium' ),
				),
			),
			$block_categories
		);
	}

	if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
		add_filter( 'block_categories_all', 'qi_blocks_premium_extend_block_categories' );
	} else {
		add_filter( 'block_categories', 'qi_blocks_premium_extend_block_categories' );
	}
}

if ( ! function_exists( 'qi_blocks_premium_is_installed' ) ) {
	/**
	 * Function check is some plugin is installed
	 *
	 * @param string $plugin name
	 *
	 * @return bool
	 */
	function qi_blocks_premium_is_installed( $plugin ) {
		switch ( $plugin ) :
			case 'free':
				return defined( 'QI_BLOCKS_VERSION' );
			case 'qi-templates':
				return defined( 'QI_TEMPLATES_VERSION' );
			case 'woocommerce':
				return class_exists( 'WooCommerce' );
			case 'contact_form_7':
				return defined( 'WPCF7_VERSION' );
			case 'wp_forms':
				return defined( 'WPFORMS_VERSION' );
			case 'full_site_editing':
				return get_theme_support( 'block-templates' );
			default:
				return apply_filters( 'qi_blocks_premium_is_plugin_installed', false, $plugin );

		endswitch;
	}
}

if ( ! function_exists( 'qi_blocks_premium_execute_template_with_params' ) ) {
	/**
	 * Loads module template part.
	 *
	 * @param string $template path to template that is going to be included
	 * @param array  $params params that are passed to template
	 *
	 * @return string - template html
	 */
	function qi_blocks_premium_execute_template_with_params( $template, $params ) {
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

if ( ! function_exists( 'qi_blocks_premium_get_template_with_slug' ) ) {
	/**
	 * Loads module template part.
	 *
	 * @param string $temp temp path to file that is being loaded
	 * @param string $slug slug that should be checked if exists
	 *
	 * @return string - string with template path
	 */
	function qi_blocks_premium_get_template_with_slug( $temp, $slug ) {
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

if ( ! function_exists( 'qi_blocks_premium_get_template_part' ) ) {
	/**
	 * Loads module template part.
	 *
	 * @param string $module name of the module from inc folder
	 * @param string $template full path of the template to load
	 * @param string $slug
	 * @param array  $params array of parameters to pass to template
	 *
	 * @return string - string containing html of template
	 */
	function qi_blocks_premium_get_template_part( $module, $template, $slug = '', $params = array() ) {
		$temp = QI_BLOCKS_PREMIUM_INC_PATH . '/' . $module . '/' . $template;

		$template = qi_blocks_premium_get_template_with_slug( $temp, $slug );

		return qi_blocks_premium_execute_template_with_params( $template, $params );
	}
}

if ( ! function_exists( 'qi_blocks_premium_template_part' ) ) {
	/**
	 * Echo module template part.
	 *
	 * @param string $module name of the module from inc folder
	 * @param string $template full path of the template to load
	 * @param string $slug
	 * @param array  $params array of parameters to pass to template
	 */
	function qi_blocks_premium_template_part( $module, $template, $slug = '', $params = array() ) {
		echo qi_blocks_premium_get_template_part( $module, $template, $slug, $params );
	}
}

if ( ! function_exists( 'qi_blocks_premium_get_block_list_template_part' ) ) {
	/**
	 * Echo module template part.
	 *
	 * @param string $module name of the module from inc folder
	 * @param string $template full path of the template to load
	 * @param string $slug
	 * @param array  $params array of parameters to pass to template
	 *
	 * @return string - string containing html of template
	 */
	function qi_blocks_premium_get_block_list_template_part( $module, $template, $slug = '', $params = array() ) {
		$temp_in_variation = false;

		/* In order to use this way of templating, option for list item layout must be called layoyt */
		if ( isset( $params['layout'] ) ) {
			/* Check if folder for variation exists */
			$variation_path = apply_filters( 'qi_blocks_premium_filter_block_list_layout_path', QI_BLOCKS_PREMIUM_INC_PATH . '/' . $module . '/variations/' . $params['layout'], $params );
			if ( file_exists( $variation_path ) ) {
				/* Check if template file in variation folder exists */
				$temp_file = qi_blocks_premium_get_template_with_slug( $variation_path . '/' . $template, $slug );

				if ( ! empty( $temp_file ) && file_exists( $temp_file ) ) {
					$template          = $temp_file;
					$temp_in_variation = true;
				}
			}
		}

		/* Template doesn't exist in variation folder, use default one */
		if ( ! $temp_in_variation ) {
			$temp     = QI_BLOCKS_PREMIUM_INC_PATH . '/' . $module . '/templates/' . $template;
			$template = qi_blocks_premium_get_template_with_slug( $temp, $slug );
		}

		return qi_blocks_premium_execute_template_with_params( $template, $params );
	}
}

if ( ! function_exists( 'qi_blocks_premium_get_custom_post_type_taxonomy_query_args' ) ) {
	/**
	 * Function that return query parameters
	 *
	 * @param array $params - options valueadditionalParams
	 * @param array $include - additional query arguments
	 *
	 * @return array
	 */
	function qi_blocks_premium_get_custom_post_type_taxonomy_query_args( $params, $include = array() ) {
		$args = array();

		if ( isset( $params['taxonomy'] ) && ! empty( $params['taxonomy'] ) ) {
			$args['taxonomy'] = $params['taxonomy'];
		}

		if ( isset( $params['postsPerPage'] ) && ! empty( $params['postsPerPage'] ) ) {
			$args['number'] = $params['postsPerPage'];
		}

		if ( isset( $params['orderBy'] ) && ! empty( $params['orderBy'] ) ) {
			$args['orderby'] = $params['orderBy'];
		}

		if ( isset( $params['order'] ) && ! empty( $params['order'] ) ) {
			$args['order'] = $params['order'];
		}

		$args['hide_empty'] = isset( $params['hideEmpty'] ) && 'yes' === $params['hideEmpty'];

		if ( isset( $params['additionalParams'] ) && ! empty( $params['additionalParams'] ) ) {
			if ( isset( $params['taxonomyIDs'] ) && ! empty( $params['taxonomyIDs'] ) ) {
				$args['include'] = explode( ',', trim( $params['taxonomyIDs'] ) );
			}
		}

		if ( ! empty( $include ) ) {
			foreach ( $include as $key => $value ) {
				if ( ! array_key_exists( $key, $args ) ) {
					$args[ $key ] = $value;
				}
			}
		}

		return $args;
	}
}

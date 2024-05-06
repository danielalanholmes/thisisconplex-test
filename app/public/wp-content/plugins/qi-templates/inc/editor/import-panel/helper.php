<?php

if ( ! function_exists( 'qi_templates_fetch_patterns' ) ) {
	function qi_templates_fetch_patterns( $with_transient_check = true ) {
		$transient_name = 'qi_templates_importable_patterns_' . str_replace( '.', '_', QI_TEMPLATES_VERSION );
		$patterns       = false;

		if ( $with_transient_check ) {
			$patterns = get_transient( $transient_name );
		}

		if ( empty( $patterns ) ) {
			//Delete transient if exists, in order to replace it with newly fetched
			if ( get_transient( $transient_name ) ) {
				delete_transient( $transient_name );
			}

			$patterns = qi_templates_fetch_type_from_premium_cdn( 'patterns' );

			set_transient( $transient_name, $patterns, 432000 );
		}

		return $patterns;
	}
}

if ( ! function_exists( 'qi_templates_fetch_wireframes' ) ) {
	function qi_templates_fetch_wireframes( $with_transient_check = true ) {
		$transient_name = 'qi_templates_importable_wireframes_' . str_replace( '.', '_', QI_TEMPLATES_VERSION );
		$wireframes     = false;

		if ( $with_transient_check ) {
			$wireframes = get_transient( $transient_name );
		}

		if ( empty( $wireframes ) ) {
			//Delete transient if exists, in order to replace it with newly fetched
			if ( get_transient( $transient_name ) ) {
				delete_transient( $transient_name );
			}

			$wireframes = qi_templates_fetch_type_from_premium_cdn( 'wireframes' );

			set_transient( $transient_name, $wireframes, 432000 );
		}

		return $wireframes;
	}
}

if ( ! function_exists( 'qi_templates_fetch_templates' ) ) {
	function qi_templates_fetch_templates( $with_transient_check = true ) {
		$transient_name = 'qi_templates_importable_templates_' . str_replace( '.', '_', QI_TEMPLATES_VERSION );
		$templates      = false;

		if ( $with_transient_check ) {
			$templates = get_transient( $transient_name );
		}

		if ( empty( $templates ) ) {
			//Delete transient if exists, in order to replace it with newly fetched
			if ( get_transient( $transient_name ) ) {
				delete_transient( $transient_name );
			}

			$templates = qi_templates_fetch_type_from_premium_cdn( 'templates' );

			set_transient( $transient_name, $templates, 432000 );
		}

		return $templates;
	}
}

if ( ! function_exists( 'qi_templates_prepare_import_panel_list_of_search_predictions' ) ) {
	function qi_templates_prepare_import_panel_list_of_search_predictions( $global_variables ) {
		if ( null !== Qi_Templates_Import_Panel::get_instance() && Qi_Templates_Import_Panel::get_instance()->is_editor_page() ) {
			$category_names  = array();
			$pattern_names   = array();
			$template_names  = array();
			$wireframe_names = array();
			$regex           = '/^\s+/m'; //remove white space from beginning of string

			$categories = qi_templates_fetch_demo_categories();
			if( is_array( $categories ) && count( $categories ) > 0 ) {
				foreach ( $categories as $slug => $name ) {
					$category_names[] = preg_replace( $regex, '', $name );
				}
			}

			$patterns = qi_templates_fetch_patterns();
			if( is_array( $patterns ) && count( $patterns ) > 0 ) {
				foreach ( $patterns as $pattern ) {
					$pattern_names[] = preg_replace( $regex, '', $pattern['title'] );
				}
			}

			$templates = qi_templates_fetch_templates();
			if( is_array( $templates ) && count( $templates ) > 0 ) {
				foreach ( $templates as $template ) {
					$template_names[] = preg_replace( $regex, '', $template['title'] );
				}
			}

			$wireframes = qi_templates_fetch_wireframes();
			if( is_array( $wireframes ) && count( $wireframes ) > 0 ) {
				foreach ( $wireframes as $wireframe ) {
					$wireframe_names[] = preg_replace( $regex, '', $wireframe['title'] );
				}
			}

			$global_variables['searchPredictions'] = array_merge( array( 'category_names' => $category_names ), array( 'pattern_names' => $pattern_names ), array( 'template_names' => $template_names ), array( 'wireframe_names' => $wireframe_names ) );
		}

		return $global_variables;
	}

	add_filter( 'qi_templates_filter_localize_admin_js', 'qi_templates_prepare_import_panel_list_of_search_predictions' );
}
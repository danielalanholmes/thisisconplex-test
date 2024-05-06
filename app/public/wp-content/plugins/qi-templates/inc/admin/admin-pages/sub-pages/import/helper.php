<?php

if ( ! function_exists( 'qi_templates_fetch_demos' ) ) {
	function qi_templates_fetch_demos( $with_transient_check = true ) {
		$transient_name = 'qi_templates_importable_demos_' . str_replace( '.', '_', QI_TEMPLATES_VERSION );
		$demos          = false;

		if ( $with_transient_check ) {
			$demos = get_transient( $transient_name );
		}

		if ( empty( $demos ) ) {
			//Delete transient if exists, in order to replace it with newly fetched
			if ( get_transient( $transient_name ) ) {
				delete_transient( $transient_name );
			}

			$demos = qi_templates_fetch_type_from_premium_cdn( 'demos' );

			set_transient( $transient_name, $demos, 432000 );
		}

		return apply_filters( 'qi_templates_filter_demos_list', $demos );
	}
}

if ( ! function_exists( 'qi_templates_fetch_demo_categories' ) ) {
	function qi_templates_fetch_demo_categories( $with_transient_check = true ) {
		$categories     = false;
		$transient_name = 'qi_templates_demo_categories_' . str_replace( '.', '_', QI_TEMPLATES_VERSION );

		if ( $with_transient_check ) {
			$categories = get_transient( $transient_name );
		}

		if ( ! $categories ) {

			//Delete transient if exists, in order to replace it with newly fetched
			if ( get_transient( $transient_name ) ) {
				delete_transient( $transient_name );
			}

			$categories = qi_templates_fetch_type_from_premium_cdn( 'categories' );

			set_transient( $transient_name, $categories, 432000 );
		}

		return $categories;
	}
}

if ( ! function_exists( 'qi_templates_prepare_demos_list_search_predictions' ) ) {
	function qi_templates_prepare_demos_list_search_predictions( $global_variables ) {
		if ( isset( $_GET['page'] ) && Qi_Templates_Admin_Sub_Page_Import::get_instance()->get_menu_slug() === $_GET['page'] ) {
			$category_names = array();
			$demo_names     = array();
			$regex          = '/^\s+/m'; //remove white space from beginning of string

			$categories = qi_templates_fetch_demo_categories();
			if( is_array( $categories ) && count( $categories ) > 0 ) {
				foreach ( $categories as $slug => $name ) {
					$category_names[] = preg_replace( $regex, '', $name );
				}
			}

			$demos = qi_templates_fetch_demos();
			if( is_array( $demos ) && count( $demos ) ) {
				foreach ( $demos as $demo ) {
					$demo_names[] = preg_replace( $regex, '', $demo['demo_name'] );
				}
			}

			$global_variables['searchPredictions'] = array_merge( array( 'category_names' => $category_names ), array( 'demo_names' => $demo_names ) );
		}

		return $global_variables;
	}

	add_filter( 'qi_templates_filter_localize_admin_js', 'qi_templates_prepare_demos_list_search_predictions' );
}
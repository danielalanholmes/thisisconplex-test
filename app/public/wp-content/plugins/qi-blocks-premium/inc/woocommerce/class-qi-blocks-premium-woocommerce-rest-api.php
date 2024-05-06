<?php

class Qi_Blocks_Premium_Woocommerce_Rest_API {
	private static $instance;

	public function __construct() {

		// Localize main editor js script with additional variables
		add_filter( 'qi_blocks_filter_localize_main_js', array( $this, 'localize_script' ) );

		// Extend main rest api routes with new case
		add_filter( 'qi_blocks_filter_rest_api_routes', array( $this, 'add_rest_api_routes' ) );
	}

	/**
	 * @return Qi_Blocks_Premium_Woocommerce_Rest_API
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function localize_script( $global ) {
		$global['viewCartText'] = esc_attr__( 'View Cart', 'qi-blocks-premium' );

		return $global;
	}

	function add_rest_api_routes( $routes ) {

		$routes['get-product-category-list'] = array(
			'route'               => 'get-product-category-list',
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => array( $this, 'get_product_category_list_callback' ),
			'permission_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
			'args'                => array(
				'queryAttributes' => array(
					'required'          => true,
					'validate_callback' => function ( $param ) {
						return intval( $param );
					},
				),
			),
		);

		return $routes;
	}

	function get_product_category_list_callback( $response ) {
		$results = array();

		if ( ! isset( $response ) || empty( $response->get_body() ) ) {
			qi_blocks_get_ajax_status( 'error', esc_html__( 'Rest is invalid', 'qi-blocks-premium' ), array() );
		} else {
			$response_data = json_decode( $response->get_body() );

			if ( ! empty( $response_data ) ) {
				$atts           = (array) $response_data->queryAttributes;
				$taxonomy_items = get_terms( qi_blocks_premium_get_custom_post_type_taxonomy_query_args( $atts ) );

				if ( ! empty( $taxonomy_items ) ) {
					foreach ( $taxonomy_items as $taxonomy_item ) {

						$category_classes    = wc_get_product_cat_class( 'qodef-e qodef-gutenberg-column', $taxonomy_item );
						$category_slug       = $taxonomy_item->slug;
						$category_link       = get_term_link( $category_slug, 'product_cat' );
						$category_id         = $taxonomy_item->term_id;
						$category_image_meta = get_term_meta( $category_id, 'thumbnail_id', true );
						$category_image_id   = ! empty( $category_image_meta ) ? $category_image_meta : get_option( 'woocommerce_placeholder_image', 0 );
						$category_image      = '';

						if ( ! empty( $category_image_id ) ) {
							$category_image = qi_blocks_get_list_block_item_image( $atts[ 'imagesProportion' ], $category_image_id, $atts[ 'customImageWidth' ], $atts[ 'customImageHeight' ] );
						}

						$results[] = array(
							'categoryName'    => $taxonomy_item->name,
							'categoryID'      => $category_id,
							'categoryClasses' => $category_classes,
							'categoryLink'    => $category_link,
							'categoryImage'   => $category_image,
						);
					}
					qi_blocks_get_ajax_status( 'success', esc_html__( 'Product categories are successfully returned', 'qi-blocks-premium' ), $results );
				} else {
					qi_blocks_get_ajax_status( 'success', esc_html__( 'No products matching query!', 'qi-blocks-premium' ), $results );
				}

				wp_reset_postdata();
			}
		}
	}
}

Qi_Blocks_Premium_Woocommerce_Rest_API::get_instance();

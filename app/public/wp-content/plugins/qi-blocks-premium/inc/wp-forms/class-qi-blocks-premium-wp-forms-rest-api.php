<?php

class Qi_Blocks_Premium_WP_Forms_Rest_API {
	private static $instance;

	public function __construct() {
		// Extend main rest api routes with new case
		add_filter( 'qi_blocks_filter_rest_api_routes', array( $this, 'add_rest_api_routes' ) );
	}

	/**
	 * @return Qi_Blocks_Premium_WP_Forms_Rest_API
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function add_rest_api_routes( $routes ) {
		$routes['get-wp-forms'] = array(
			'route'               => 'get-wp-forms',
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => array( $this, 'get_wp_forms_callback' ),
			'permission_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		);

		$routes['render-wp-forms'] = array(
			'route'               => 'render-wp-forms',
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => array( $this, 'render_wp_forms_callback' ),
			'permission_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
			'args'                => array(
				'formID' => array(
					'required'          => true,
					'validate_callback' => function ( $param ) {
						return intval( $param );
					},
				),
			),
		);

		return $routes;
	}

	function get_wp_forms_callback() {

		if ( empty( $_GET ) ) {
			qi_blocks_get_ajax_status( 'error', esc_html__( 'Get method is invalid', 'qi-blocks-premium' ), array() );
		} else {
			$results = array();
			$items   = new WP_Query(
				array(
					'post_status'    => 'publish',
					'post_type'      => 'wpforms',
					'posts_per_page' => - 1,
					'fields'         => 'ids',
				)
			);

			if ( $items->have_posts() ) {
				foreach ( $items->posts as $form_id ) :
					$results[ $form_id ] = esc_html( get_the_title( $form_id ) );
				endforeach;
			}

			wp_reset_postdata();

			if ( ! empty( $results ) ) {
				qi_blocks_get_ajax_status( 'success', esc_html__( 'Contact forms are successfully returned', 'qi-blocks-premium' ), $results );
			} else {
				qi_blocks_get_ajax_status( 'error', esc_html__( 'No available contact forms', 'qi-blocks-premium' ), array() );
			}
		}
	}

	function render_wp_forms_callback( $response ) {

		if ( ! isset( $response ) || empty( $response->get_body() ) ) {
			qi_blocks_get_ajax_status( 'error', esc_html__( 'Rest is invalid', 'qi-blocks-premium' ), array() );
		} else {
			$response_data = json_decode( $response->get_body() );
			$formID        = isset( $response_data->formID ) && ! empty( $response_data->formID ) ? intval( $response_data->formID ) : 0;

			if ( ! empty( $formID ) ) {
				$html = do_shortcode( '[wpforms id="' . esc_attr( $formID ) . '"]' );

				qi_blocks_get_ajax_status( 'success', esc_html__( 'Returned contact form HTML content', 'qi-blocks-premium' ), $html );
			} else {
				qi_blocks_get_ajax_status( 'error', esc_html__( 'Parameters are invalid', 'qi-blocks-premium' ), array() );
			}
		}
	}
}

Qi_Blocks_Premium_WP_Forms_Rest_API::get_instance();

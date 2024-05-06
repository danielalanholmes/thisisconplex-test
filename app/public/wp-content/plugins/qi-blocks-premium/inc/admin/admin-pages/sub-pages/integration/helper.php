<?php

if ( ! function_exists( 'qi_blocks_premium_get_integration_keys' ) ) {

	/**
	 * Function that return api keys from db
	 *
	 * @param string $key - requested key
	 *
	 * @return mixed Values if existed, otherwise false
	 */
	function qi_blocks_premium_get_integration_keys( $key ) {
		$integration_keys = get_option( 'QI_BLOCKS_PREMIUM_INTEGRATION_KEYS' );
		$return_value     = false;

		if ( false !== $integration_keys && isset( $integration_keys[ $key ] ) ) {
			$return_value = $integration_keys[ $key ];
		}

		return $return_value;
	}
}

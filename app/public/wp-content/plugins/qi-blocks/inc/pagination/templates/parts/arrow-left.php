<?php

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$icon = ! empty( $paginationArrowPrevIcon ) && isset( $paginationArrowPrevIcon['html'] ) ? $paginationArrowPrevIcon['html'] : '';

if ( ! empty( $icon ) ) {
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo qi_blocks_get_svg_icon_content( $icon );
} else {
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo qi_blocks_get_svg_icon( 'icon-arrow-left', 'qodef-m-pagination-icon' );
}

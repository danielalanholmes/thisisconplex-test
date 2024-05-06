<?php

if ( ! empty( $taxonomy_items ) ) {
	foreach ( $taxonomy_items as $taxonomy_item ) {
		$params['category_slug'] = $taxonomy_item->slug;
		$params['category_name'] = $taxonomy_item->name;
		$params['category_id']   = $taxonomy_item->term_id;

		echo qi_blocks_premium_get_block_list_template_part( 'blocks/product-category-list', 'layouts/' . $layout, '', $params );
	}
} else {
	// Include global posts not found
	qi_blocks_template_part( 'woocommerce', 'templates/parts/posts-not-found' );
}

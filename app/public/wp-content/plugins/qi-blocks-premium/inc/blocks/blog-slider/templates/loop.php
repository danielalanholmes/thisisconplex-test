<?php

if ( $query_result->have_posts() ) {
	while ( $query_result->have_posts() ) :
		$query_result->the_post();

		echo qi_blocks_premium_get_block_list_template_part( 'blocks/blog-slider', 'layouts/' . $layout, '', $params );
	endwhile; // End of the loop.
} else {
	// Include global posts not found
	qi_blocks_template_part( 'blog', 'templates/parts/posts-not-found' );
}

wp_reset_postdata();

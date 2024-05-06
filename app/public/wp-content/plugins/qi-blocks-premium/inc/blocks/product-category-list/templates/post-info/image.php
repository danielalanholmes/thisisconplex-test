<?php
$taxonomy_image_meta = get_term_meta( $category_id, 'thumbnail_id', true );
$taxonomy_image      = ! empty( $taxonomy_image_meta ) ? $taxonomy_image_meta : get_option( 'woocommerce_placeholder_image', 0 );

if ( ! empty( $taxonomy_image ) ) {
	?>
	<div class="qodef-e-img-holder">
		<?php echo qi_blocks_get_list_block_item_image( $imagesProportion, $taxonomy_image, $customImageWidth, $customImageHeight ); ?>
	</div>
	<?php
}

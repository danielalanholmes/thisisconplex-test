<?php
$title_tag = isset( $titleTag ) && ! empty( $titleTag ) ? $titleTag : 'h2';
$with_link = isset( $with_link ) && ! empty( $with_link );
?>
<<?php echo esc_attr( $title_tag ); ?> class="qodef-e-title woocommerce-loop-category__title">
	<?php if ( $with_link ) { ?>
		<a href="<?php echo get_term_link( $category_slug, 'product_cat' ); ?>">
	<?php } ?>
		<?php echo wp_kses_post( $category_name ); ?>
	<?php if ( $with_link ) { ?>
		</a>
	<?php } ?>
</<?php echo esc_attr( $title_tag ); ?>>

<div <?php wc_product_cat_class( $item_classes ); ?>>
	<div class="qodef-e-holder-inner">
		<div class="qodef-e-image">
			<a href="<?php echo get_term_link( $category_slug, 'product_cat' ); ?>">
				<?php qi_blocks_premium_template_part( 'blocks/product-category-list', 'templates/post-info/image', '', $params ); ?>
			</a>
		</div>
		<div class="qodef-e-content">
			<?php
			qi_blocks_premium_template_part(
				'blocks/product-category-list',
				'templates/post-info/title',
				'',
				array_merge(
					$params,
					array( 'with_link' => true )
				)
			);
			?>
			<?php qi_blocks_premium_template_part( 'blocks/product-category-list', 'templates/post-info/button', '', $params ); ?>
		</div>
	</div>
</div>

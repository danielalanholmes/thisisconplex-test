<div <?php wc_product_class( $item_classes ); ?>>
	<div class="qodef-e-product-inner">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="qodef-e-product-image">
				<?php qi_blocks_template_part( 'woocommerce', 'templates/parts/post-info/mark', '', $params ); ?>
				<div class="qodef-e-product-image-holder">
					<?php qi_blocks_template_part( 'woocommerce', 'templates/parts/post-info/image', '', $params ); ?>
				</div>
				<div class="qodef-e-product-image-inner qodef-image-content">
					<?php qi_blocks_template_part( 'woocommerce', 'templates/parts/post-info/link' ); ?>
					<div class="qodef-e-product-top">
						<div class="qodef-e-product-heading">
							<?php qi_blocks_template_part( 'woocommerce', 'templates/parts/post-info/title', '', $params ); ?>
							<?php qi_blocks_template_part( 'woocommerce', 'templates/parts/post-info/price', '', $params ); ?>
						</div>
						<?php qi_blocks_template_part( 'woocommerce', 'templates/parts/post-info/category', '', $params ); ?>
						<?php qi_blocks_template_part( 'woocommerce', 'templates/parts/post-info/rating', '', $params ); ?>
					</div>
					<div class="qodef-e-product-bottom">
						<?php qi_blocks_template_part( 'woocommerce', 'templates/parts/post-info/add-to-cart', '', $params ); ?>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>

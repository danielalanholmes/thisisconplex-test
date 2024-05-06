<div <?php echo qi_blocks_get_block_container_html_attributes_string( $params ); ?>>
	<div <?php qi_blocks_class_attribute( $holder_classes ); ?>>
		<div <?php qi_blocks_class_attribute( $slider_classes ); ?> <?php echo qi_blocks_get_inline_attr( $slider_attr, 'data-options' ); ?>>
			<div class="swiper-wrapper">
				<?php
				// Include items
				qi_blocks_premium_template_part( 'blocks/product-slider', 'templates/loop', '', $params );
				?>
			</div>
			<?php
			if ( 'inside' === $sliderNavigationPosition ) {
				qi_blocks_template_part( 'slider', 'templates/swiper-nav', '', $params );
			}
			if ( 'inside' === $sliderPaginationPosition ) {
				qi_blocks_template_part( 'slider', 'templates/swiper-pag', '', $params );
			}
		?>
		</div>
		<?php
		if ( 'outside' === $sliderNavigationPosition || 'together' === $sliderNavigationPosition ) {
			qi_blocks_template_part( 'slider', 'templates/swiper-nav', 'outside', $params );
		}
		if ( 'outside' === $sliderPaginationPosition ) {
			qi_blocks_template_part( 'slider', 'templates/swiper-pag', $sliderPaginationPosition, $params );
		}
		?>
	</div>
</div>

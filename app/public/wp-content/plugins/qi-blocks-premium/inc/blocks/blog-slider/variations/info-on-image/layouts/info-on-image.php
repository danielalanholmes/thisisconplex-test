<?php
$image_class = '';
if ( ! has_post_thumbnail() ) {
	$image_class = 'qodef-without-image';
}
?>
<div class="qodef-e swiper-slide">
	<article <?php post_class( array( $item_classes, $image_class ) ); ?>>
		<div class="qodef-e-inner">
			<?php
			if ( 'no' !== $showMedia && has_post_thumbnail() ) {
				// Include post media
				qi_blocks_template_part( 'blog', 'templates/parts/post-info/media', 'image', $params );
			}
			?>
			<div class="qodef-e-content">
				<?php if ( 'no' !== $showCategory || 'no' !== $showAuthor || 'no' !== $showDate ) { ?>
					<div class="qodef-e-info qodef-info--top">
						<?php

						if ( 'no' !== $showDate ) {
							// Include post date
							qi_blocks_template_part( 'blog', 'templates/parts/post-info/date', '', $params );
						}				
						if ( 'no' !== $showCategory ) {
							// Include post category info
							qi_blocks_template_part( 'blog', 'templates/parts/post-info/category', '', $params );
						}

						if ( 'no' !== $showAuthor ) {
							// Include post author info
							qi_blocks_template_part( 'blog', 'templates/parts/post-info/author', '', $params );
						}

						?>
					</div>
				<?php } ?>
				<div class="qodef-e-text">
					<?php
					// Include post title
					qi_blocks_template_part( 'blog', 'templates/parts/post-info/title', '', $params );
					?>
				</div>
			</div>
		</div>
	</article>
</div>

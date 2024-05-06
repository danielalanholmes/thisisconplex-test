<div class="qodef-single-holder qodef-admin-content-grid">
	<div class="qodef-single-top">
		<h2><?php echo esc_html( $demo['demo_name'] ); ?></h2>
		<a href="#"
		   class="qodef-return-to-demo-list qodef-btn qodef-btn-outlined"><?php esc_html_e( 'Demo List', 'qi-templates' ); ?></a>
	</div>
	<div class="qodef-single-content">
		<div class="qodef-single-demo-images">
			<?php
			if ( isset( $demo['demo_image_url'] ) && ! isset( $demo['demo_additional_images_urls'] ) ) {
				qi_templates_template_part( 'admin/admin-pages/sub-pages/import', 'templates/image', '', $params );
			} else if ( isset( $demo['demo_image_url'] ) && isset( $demo['demo_additional_images_urls'] ) ) {
				qi_templates_template_part( 'admin/admin-pages/sub-pages/import', 'templates/additional-images', '', $params );
			}
			?>
		</div>
		<div class="qodef-single-demo-actions">
			<?php qi_templates_template_part( 'admin/admin-pages/sub-pages/import', 'templates/plugins', '', $params ); ?>
			<?php qi_templates_template_part( 'admin/admin-pages/sub-pages/import', 'templates/form', '', $params ); ?>
		</div>
	</div>
	<div class="qodef-single-banners">
		<?php qi_templates_template_part( 'admin/admin-pages/sub-pages/import', 'templates/single-banner-templates', '', $params ); ?>
		<?php qi_templates_template_part( 'admin/admin-pages/sub-pages/import', 'templates/single-banner-blocks', '', $params ); ?>
	</div>
</div>

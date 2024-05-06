<div class="qodef-admin-integration-page">
	<form class="qodef-integration-form qodef-dashboard-ajax-form" data-action="premium_integration">
		<div class="qodef-admin-integration-header">
			<div class="qodef-integration-header-left">
				<div class="qodef-integration-header-left-inner">
					<h2><?php esc_html_e( 'Integration Page', 'qi-blocks-premium' ); ?></h2>
				</div>
			</div>
			<div class="qodef-integration-header-right">
				<div class="qodef-integration-header-right-inner">
					<?php qi_blocks_template_part( 'admin/admin-pages', 'templates/parts/save', '', array( 'page_slug' => 'integration', 'nonce_slug' => 'premium_integration' ) ); ?>
				</div>
			</div>
		</div>
		<?php
		if ( ! empty( $integration_services ) ) {
			foreach ( $integration_services as $integration_service ) {
				qi_blocks_premium_template_part(
					'admin/admin-pages',
					'sub-pages/integration/templates/parts/service',
					'',
					array(
						'integration_service' => $integration_service,
						'api_key_values'      => $api_key_values,
					)
				);
			}
		}
		?>
	</form>
	<?php qi_blocks_template_part( 'admin/admin-pages', 'templates/parts/subscribe' ); ?>
	<?php qi_blocks_template_part( 'admin/admin-pages', 'templates/footer' ); ?>
</div>

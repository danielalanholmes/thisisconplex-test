<div class="qodef-admin-registration-page">
	<form class="qodef-registration-form" data-action="<?php echo esc_attr( $action_name ); ?>">
		<div class="qodef-admin-registration-header">
			<div class="qodef-registrations-header-left">
				<div class="qodef-registrations-header-left-inner">
					<h2><?php esc_html_e( 'Welcome to Qi Blocks', 'qi-blocks-premium' ); ?></h2>
				</div>
			</div>
		</div>
		<div class="qodef-section-box-content">
			<h3><?php esc_html_e( 'Registration', 'qi-blocks-premium' ); ?></h3>
			<p class="qodef-large"><?php esc_html_e( 'Please input the purchase code received with your copy of Qi Blocks Premium in order to register the plugin', 'qi-blocks-premium' ); ?></p>
		</div>
		<div class="qodef-section-box-content qodef-section-box-register-form">
			<h3><?php esc_html_e( 'Register Qi Blocks', 'qi-blocks-premium' ); ?></h3>
			<div class="qodef-section-field">
				<input name="qi_blocks_premium_license_key" id="qodef-license-key" placeholder="<?php esc_attr_e( 'Purchase code', 'qi-blocks-premium' ); ?>" value="<?php echo esc_attr( $license_key ); ?>" class="qodef-input" />
			</div>
			<div class="qodef-section-field">
				<input type="submit" class="qodef-btn qodef-btn-solid-red <?php echo esc_attr( $button_class ); ?>" name="<?php echo esc_attr( $button_name ); ?>" value="<?php echo esc_attr( $button_text ); ?>" />
				<span class="qodef-waiting-message"><?php esc_html_e( 'Please Wait...', 'qi-blocks-premium' ); ?></span>
				<span class="qodef-registration-message"></span>
				<?php wp_nonce_field( 'qi_blocks_premium_registration_nonce', 'qi_blocks_premium_registration_nonce' ); ?>
			</div>
		</div>
	</form>
	<?php qi_blocks_template_part( 'admin/admin-pages', 'templates/parts/subscribe' ); ?>
	<?php qi_blocks_template_part( 'admin/admin-pages', 'templates/footer' ); ?>
</div>

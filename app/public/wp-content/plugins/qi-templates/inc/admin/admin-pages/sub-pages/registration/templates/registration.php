<div class="qodef-admin-registration-page">
	<form class="qodef-registration-form" id="qi_templates_registration_framework_ajax_form" data-action-name="<?php echo esc_attr( $action_name ); ?>">
		<div class="qodef-admin-registration-header">
			<div class="qodef-registrations-header-left">
				<div class="qodef-registrations-header-left-inner">
					<h2><?php esc_html_e( 'Welcome to Qi Templates', 'qi-templates' ); ?></h2>
				</div>
			</div>
		</div>
		<div class="qodef-section-box-content">
			<h3><?php esc_html_e( 'Registration', 'qi-templates' ); ?></h3>
			<p class="qodef-large"><?php esc_html_e( 'Please input the purchase code you received with your copy of Qi Theme in order to register the Qi Templates plugin', 'qi-templates' ); ?></p>
		</div>
		<div class="qodef-section-box-content qodef-section-box-register-form">
			<h3><?php esc_html_e( 'Register Qi Templates', 'qi-templates' ); ?></h3>
			<div class="qodef-section-field">
				<input name="qi_templates_license_key" id="qodef-license-key" placeholder="<?php esc_html_e( 'Purchase code', 'qi-templates' ); ?>" value="<?php echo esc_attr( $license_key ); ?>" class="qodef-input" />
			</div>
			<div class="qodef-section-field">
				<input type="submit" class="qodef-btn qodef-btn-solid-red <?php echo esc_attr( $button_class ); ?>" name="<?php echo esc_attr( $button_name ); ?>" value="<?php echo esc_attr( $button_text ); ?>" />
				<span class="qodef-waiting-message"><?php esc_attr_e( 'Please Wait...', 'qi-templates' ); ?></span>
				<span class="qodef-registration-message"></span>
				<?php wp_nonce_field( 'qi_templates_registration_nonce', 'qi_templates_registration_nonce' ); ?>
			</div>
		</div>
	</form>
	<?php qi_templates_template_part( 'admin/admin-pages', 'templates/parts/subscribe' ); ?>
</div>

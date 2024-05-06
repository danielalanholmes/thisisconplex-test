<form method="post" class="qodef-import-form"
      data-confirm-message="<?php esc_attr_e( 'Are you sure, you want to import Demo Data now?', 'qi-templates' ); ?>"
      data-empty-import-type-message="<?php esc_attr_e( 'Please select import type!', 'qi-templates' ); ?>"
      data-content-files="<?php echo esc_attr( $content_files['content_files'] ); ?>"
      data-other-files="<?php echo esc_attr( $content_files['other_files'] ); ?>">
	<input type="hidden" class="qodef-import-demo" value="<?php echo esc_attr( $demo_key ); ?>"/>
	<div class="qodef-form-section qodef-form-section-attachments">
		<h4 class="qodef-form-label"><?php esc_html_e( 'Import Attachments', 'qi-templates' ); ?></h4>
		<div class="qodef-import-checkbox-toggle qodef-import-field">
			<input type="checkbox" class="qodef-import-attachments" id="import_attachments" name="import_attachments"
			       value="yes" checked/>
			<label for="import_attachments"><?php esc_attr_e( 'Import Attachments', 'qi-templates' ); ?></label>
		</div>
	</div>
	<div class="qodef-form-section qodef-form-section-progress">
		<span class="qodef-progress-label"><?php esc_html_e( 'The import process may take some time. Please be patient.', 'qi-templates' ); ?></span>
		<progress id="qodef-progress-bar" value="0" max="100"></progress>
		<span class="qodef-progress-percent"><?php esc_attr_e( '0%', 'qi-templates' ); ?></span>
	</div>
	<div class="qodef-form-section qodef-form-section-messages">
		<p class="qodef-import-is-completed"><?php esc_html_e( 'Import is completed', 'qi-templates' ); ?></p>
		<p class="qodef-import-went-wrong"><?php esc_html_e( 'Something went wrong.', 'qi-templates' ); ?> <a
					href="https://helpcenter.qodeinteractive.com"
					target="_blank"><?php esc_html_e( 'Please contact support.', 'qi-templates' ); ?></a></p>
		<?php if ( ini_get( 'allow_url_fopen' ) ) { ?>
			<input type="submit" class="qodef-btn qodef-btn-solid-red qodef-disabled"
			       value="<?php esc_attr_e( 'Import Demo', 'qi-templates' ); ?>" name="import"
			       id="qodef-import-demo-data"/>
		<?php } else { ?>
			<div class="qodef-allow-url-fopen-error">
				<p><?php esc_html_e( 'In order to complete the import process successfully, the \'allow_url_fopen\' has to be enabled on your server.', 'qi-templates' ); ?></p>
			</div>
		<?php } ?>
	</div>
	<?php wp_nonce_field( 'qi_templates_import_nonce', 'qi_templates_import_nonce' ); ?>
</form>

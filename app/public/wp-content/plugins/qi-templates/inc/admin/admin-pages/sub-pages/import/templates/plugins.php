<?php
if ( ! empty( $demo['required_plugins'] ) ) { ?>
	<div class="qodef-required-plugins-holder">
		<h3><?php esc_html_e( 'The following plugins should be installed & activated before import:', 'qi-templates' ); ?></h3>
		<?php
		foreach ( $demo['required_plugins'] as $plugin => $plugin_value ) {
			$prepared_plugin         = Qi_Templates_Install_Plugins::get_instance()->prepare_plugin( $plugin );
			$plugin_holder_classes   = array( 'qodef-plugin' );
			$plugin_holder_classes[] = $plugin_value['essential'] ? 'qodef-essential-plugin' : '';
			?>
			<p <?php qi_templates_class_attribute( $plugin_holder_classes ); ?>>
                <span class="qodef-plugin-label">
                    <?php echo esc_html( $plugin_value['name'] ); ?>
                </span>
				<a class="qodef-install-plugin-link" href="#"
				   data-plugin-action="<?php echo esc_html( $prepared_plugin['status'] ); ?>"
				   data-plugin-slug="<?php echo esc_html( $prepared_plugin['key'] ); ?>"
				   data-plugin-action-label="<?php echo esc_html( $prepared_plugin['action_label'] ); ?>">
					<span class=""></span> <?php echo esc_html( $prepared_plugin['label'] ); ?>
				</a>
				<span class="qodef-plugin-installing-spinner">
					<span class="qodef-spinner-dot"></span>
					<span class="qodef-spinner-dot"></span>
					<span class="qodef-spinner-dot"></span>
				</span>
			</p>
		<?php } ?>
		<?php wp_nonce_field( 'qi_templates_install_plugins_nonce', 'qi_templates_install_plugins_nonce' ); ?>
	</div>
	<?php
}

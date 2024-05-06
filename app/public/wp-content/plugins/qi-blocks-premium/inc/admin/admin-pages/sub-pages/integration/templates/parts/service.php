<div class="qodef-section-box-integration qodef-section-service">
	<div class="qodef-section-box-content">
		<?php if ( ! empty( $integration_service['title'] ) ) { ?>
			<h3><?php echo esc_html( $integration_service['title'] ); ?></h3>
		<?php } ?>
		<?php if ( ! empty( $integration_service['description'] ) ) { ?>
			<p><?php echo esc_html( $integration_service['description'] ); ?></p>
		<?php } ?>
		<?php
		foreach ( $integration_service['fields'] as $field ) :
			$field_value = $api_key_values[ $field['field_name'] ] ?? '';
			?>
			<input
				class="qodef-input"
				name="<?php echo esc_attr( $field['field_name'] ); ?>"
				id="<?php echo esc_attr( $field['field_name'] ); ?>"
				value="<?php echo esc_attr( $field_value ); ?>"
				placeholder="<?php esc_attr_e( 'Type here...', 'qi-blocks-premium' ); ?>"
			/>
		<?php endforeach; ?>
	</div>
</div>

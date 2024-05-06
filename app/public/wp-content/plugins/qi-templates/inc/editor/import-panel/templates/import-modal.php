<div id="qi-templates-import-modal">
	<div class="qi-templates-import-modal-inner">

		<?php qi_templates_template_part( 'editor/import-panel', 'templates/parts/notice' ); ?>

		<?php qi_templates_template_part( 'editor/import-panel', 'templates/parts/header' ); ?>

		<?php qi_templates_template_part( 'editor/import-panel', 'templates/parts/content', '', $params ); ?>

		<?php wp_nonce_field( 'qi_templates_list_nonce', 'qi_templates_list_nonce' ); ?>
	</div>
</div>

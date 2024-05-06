<div class="qi-templates-import-modal-content">
	<div class="qi-templates-import-modal-content-inner">

		<?php qi_templates_template_part( 'editor/import-panel', 'templates/parts/top-filters', '', $params ); ?>

		<div class="qi-templates-import-modal-content-main-section">

			<?php qi_templates_template_part( 'editor/import-panel', 'templates/parts/left-filters', '', $params ); ?>

			<div class="qi-templates-import-modal-content-list-holder">

				<div class="qi-templates-import-modal-content-list-inner">
					<?php qi_templates_template_part( 'editor/import-panel', 'templates/parts/import-list', '', $params ); ?>
				</div>

				<?php qi_templates_template_part( 'editor/import-panel', 'templates/parts/demos-import', '', $params ); ?>

				<?php qi_templates_template_part( 'editor/import-panel', 'templates/parts/spinner', '', $params ); ?>

			</div>
		</div>
	</div>
</div>

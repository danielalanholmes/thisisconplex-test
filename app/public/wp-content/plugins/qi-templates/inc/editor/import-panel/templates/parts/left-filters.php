<?php $categories = qi_templates_fetch_demo_categories(); ?>

<div class="qi-templates-import-modal-content-left-filters">
	<div class="qodef-im-category-filters-list">
		<?php if( is_array( $categories ) && count( $categories ) > 0 ) { ?>
			<ul class="qodef-filter-list">
				<li class="qodef-filter-item qodef-demos-filter qodef--active" data-filter-title="all" data-filter="">
					<span class="qodef-filter-item-name"><?php esc_html_e( 'All', 'qi-templates' ); ?></span>
				</li>
				<?php foreach ( $categories as $slug => $name ) { ?>
					<li class="qodef-filter-item qodef-demos-filter" data-taxonomy="category"
					    data-filter-title="<?php echo esc_attr( $name ); ?>"
					    data-filter=".demo-category-<?php echo esc_attr( $slug ); ?>">
						<span class="qodef-filter-item-name"><?php echo esc_attr( $name ); ?></span>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	</div>
</div>
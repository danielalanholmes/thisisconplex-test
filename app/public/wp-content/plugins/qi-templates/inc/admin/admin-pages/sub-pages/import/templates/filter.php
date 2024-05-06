<div class="qodef-filter-holder">
	<div class="qodef-filter-holder-inner">
		<div class="qodef-filter-group qodef-filter-category">
			<h6 class="qodef-filter-group-title"><?php esc_html_e( 'Categories', 'qi-templates' ); ?></h6>
			<ul class="qodef-filter-list">
				<li class="qodef-filter-item qodef-demos-filter qodef--active" data-filter-title="all" data-filter="">
					<span class="qodef-filter-item-name"><?php esc_html_e( 'All Categories', 'qi-templates' ); ?></span>
				</li>
				<?php foreach ( $categories as $slug => $name ) { ?>
					<li class="qodef-filter-item qodef-demos-filter" data-taxonomy="category"
					    data-filter-title="<?php echo esc_attr( $name ); ?>"
					    data-filter=".demo-category-<?php echo esc_attr( $slug ); ?>">
						<span class="qodef-filter-item-name"><?php echo esc_attr( $name ); ?></span>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>

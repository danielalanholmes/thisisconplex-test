<?php if ( is_array( $demos ) && count( $demos ) > 0 ) { ?>
	<div class="qodef-import-masonry-list qodef-import-demos-inner">
		<div class="qodef-demos-holder">
			<?php qi_templates_template_part( 'admin/admin-pages/sub-pages/import', 'templates/filter-top', '', $params ); ?>
			<div class="qodef-grid-inner">
				<div class="qodef-import-masonry-grid-sizer"></div>
				<div class="qodef-import-masonry-grid-gutter"></div>
				<?php foreach ( $demos as $id => $demo ) {

					$item_classes = array();
					if ( ! empty( $demo['categories'] ) ) {
						foreach ( $demo['categories'] as $key => $value ) {
							$item_classes[] = 'demo-category-' . $key;
						}
					}

					if ( ! empty( $demo['status'] ) ) {
						$item_classes[] = 'demo-status-' . $demo['status'];
					}

					?>
					<article
						class="qodef-masonry-item qodef-import-demo <?php echo implode( ' ', $item_classes ); ?>">
						<div class="qodef-import-demo-inner">
							<div class="qodef-import-demo-image">
								<div class="qodef-lazy-load">
									<img itemprop="image" data-image="<?php echo esc_url( $demo['demo_image_url'] ); ?>" width="570" height="580" src="<?php echo esc_url( QI_TEMPLATES_ADMIN_URL_PATH . '/admin-pages/sub-pages/import/assets/img/demo-placeholder.jpg' ); ?>" alt="<?php echo esc_attr( $demo['demo_name'] ); ?>"/>
									<a class="qodef-import-demo-image-link-overlay" href="<?php echo esc_url( $demo['demo_preview_url'] ); ?>" target="_blank"></a>
								</div>
							</div>
							<div class="qodef-import-demo-text">
								<h4 class="qodef-import-demo-title">
									<a href="<?php echo esc_url( $demo['demo_preview_url'] ); ?>" target="_blank">
										<?php echo esc_attr( $demo['demo_name'] ); ?>
									</a>
								</h4>
								<div class="qodef-imort-demo-actions">
									<a class="qodef-import-demo-link"
									   data-demo-id="<?php echo esc_attr( $id ); ?>"
									   href="<?php echo add_query_arg( array( 'item-id' => esc_attr( $id ) ), menu_page_url( $page_name, false ) ); ?>">
										<span><?php esc_html_e( 'Import', 'qi-templates' ); ?></span>
										<svg xmlns="http://www.w3.org/2000/svg"
										     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										     width="13px" height="11px" viewBox="0 0 13 11"
										     enable-background="new 0 0 13 11" xml:space="preserve">
                                                    <g>
	                                                    <g>
		                                                    <path d="M7.017,0.498v6.258l2.225-2.118C9.479,4.39,9.721,4.384,9.966,4.624c0.248,0.238,0.242,0.472-0.016,0.7L6.855,8.313
                                                                C6.813,8.375,6.759,8.416,6.694,8.437C6.63,8.458,6.565,8.468,6.501,8.468S6.372,8.458,6.308,8.437
                                                                C6.243,8.416,6.189,8.375,6.146,8.313L3.052,5.324c-0.258-0.229-0.263-0.462-0.016-0.7c0.247-0.24,0.489-0.234,0.726,0.015
                                                                l2.224,2.118V0.498c0-0.146,0.048-0.265,0.145-0.358S6.351,0,6.501,0c0.15,0,0.274,0.047,0.371,0.14S7.017,0.353,7.017,0.498z"/>
	                                                    </g>
	                                                    <path d="M12.855,5.878c-0.097-0.093-0.22-0.14-0.371-0.14c-0.149,0-0.273,0.047-0.37,0.14s-0.146,0.213-0.146,0.358v3.767H1.032
                                                            V6.237c0-0.146-0.048-0.265-0.145-0.358s-0.221-0.14-0.371-0.14c-0.151,0-0.274,0.047-0.371,0.14S0.001,6.091,0.001,6.237L0,11
                                                            h0.001H13V6.237C13,6.091,12.952,5.972,12.855,5.878z"/>
                                                    </g>
										        </svg>
									</a>
									<a class="qodef-view-demo-link"
									   href="<?php echo esc_url( $demo['demo_preview_url'] ); ?>" target="_blank">
										<span><?php esc_html_e( 'View', 'qi-templates' ); ?></span>
										<svg xmlns="http://www.w3.org/2000/svg"
										     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="9px"
										     height="9px" viewBox="0 0 9 9" enable-background="new 0 0 9 9"
										     xml:space="preserve">
	                                                <g>
		                                                <path fill="#010101" d="M0.164,8.067c0.013-0.014,6.985-6.983,6.985-6.983L2.332,1.06C1.963,1.075,1.779,0.9,1.781,0.533
	                                                            c0-0.367,0.184-0.542,0.55-0.526h6.134C8.544-0.008,8.617,0,8.68,0.032C8.744,0.064,8.8,0.103,8.848,0.151
	                                                            C8.897,0.199,8.936,0.255,8.97,0.318C9,0.383,9.008,0.454,8.992,0.534v6.13c0.017,0.366-0.158,0.551-0.526,0.55
	                                                            c-0.368,0.001-0.544-0.183-0.527-0.55L7.916,1.85L0.93,8.832C0.818,8.944,0.69,9,0.547,9C0.054,9-0.182,8.413,0.164,8.067z"/>
	                                                </g>
	                                            </svg>
									</a>
								</div>
								<div class="qodef-filter-category-holder">
									<?php
									foreach ( $demo['categories'] as $slug => $name ) {
										echo '<span>' . $name . '</span>';
									}
									?>
								</div>
							</div>
						</div>
					</article>
				<?php } ?>
				<?php wp_nonce_field( 'qi_templates_demo_import_nonce', 'qi_templates_demo_import_nonce' ); ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ( ! empty( $list_items ) && is_array( $list_items ) && count( $list_items ) > 0 ) { ?>
	<div class="qodef-import-masonry-list qi-templates-import-list qi-templates-import-list-<?php echo esc_attr( $import_type ); ?>">
		<div class="qodef-grid-inner">
			<div class="qodef-import-masonry-grid-sizer"></div>
			<div class="qodef-import-masonry-grid-gutter"></div>
			<?php foreach ( $list_items as $key => $list_item ) {

				$item_classes = array();
				if ( ! empty( $list_item['categories'] ) ) {
					foreach ( $list_item['categories'] as $cat_key => $cat_value ) {
						$item_classes[] = 'demo-category-' . $cat_key;
					}
				}

				?>
				<article class="qodef-masonry-item qi-templates-import-item qi-templates-import-item-<?php echo esc_attr( $import_type ); ?> <?php echo implode( ' ', $item_classes ); ?>">
					<div class="qi-templates-import-item-inner">
						<div class="qi-templates-import-item-image">
							<div class="qi-templates-import-item-image-media">
								<div class="qodef-lazy-load">
									<a href="#" class="qi-templates-import-item-button" data-import-type="<?php echo esc_attr( $import_type ); ?>" data-import-item-id="<?php echo esc_attr( $key ); ?>">
										<img itemprop="image" data-image="<?php echo esc_url( $list_items[$key]['preview_image'] ); ?>" width="470" height="540" src="<?php echo esc_url( QI_TEMPLATES_ADMIN_URL_PATH . '/admin-pages/sub-pages/import/assets/img/demo-placeholder.jpg' ); ?>" alt="<?php echo esc_html__( 'Qode Import Item Preview Image', 'qi-templates' ); ?>"/>
									</a>
								</div>
							</div>
							<?php if( 'templates' === $import_type ) { ?>
								<img itemprop="image" width="301" height="350" src="<?php echo esc_url( QI_TEMPLATES_INC_URL_PATH . '/editor/import-panel/assets/img/templates-frame.png' ); ?>" alt="<?php esc_attr_e( 'Import Modal Template Frame', 'qi-templates' ); ?>" />
							<?php } ?>
						</div>
						<div class="qi-templates-import-item-info-holder">
							<h4 class="qi-templates-import-item-title"><?php echo esc_html( $list_item['title'] ) ?></h4>
							<a href="#" class="qi-templates-import-item-button" data-import-type="<?php echo esc_attr( $import_type ); ?>" data-import-item-id="<?php echo esc_attr( $key ); ?>">
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
						</div>
					</div>
				</article>
			<?php } ?>
		</div>
	</div>
	<?php wp_nonce_field( 'qi_templates_item_nonce', 'qi_templates_item_nonce' ); ?>
<?php }

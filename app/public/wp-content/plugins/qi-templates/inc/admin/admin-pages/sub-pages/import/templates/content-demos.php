<?php

$license_active = qi_templates_is_plugin_activated();

if( $license_active ) { ?>
	<div class="qodef-import-demos">
		<div class="qodef-import-top">
			<div class="qodef-import-top-title-holder">
				<h1 class="qodef-import-top-title"><?php echo esc_html( $import_title ); ?></h1>
			</div>
			<div class="qodef-import-top-actions-holder">
				<a href="#" class="qodef-import-top-button qodef-import-top-reload-button">
					<span><?php echo esc_html__( 'Reload', 'qi-templates' )?></span>
					<svg x="0px" y="0px" width="16.497px" height="14.063px" viewBox="0 0 16.497 14.063" enable-background="new 0 0 16.497 14.063" xml:space="preserve">
	                    <g>
		                    <path d="M16.242,6.223L13.5,8.965c-0.141,0.141-0.329,0.211-0.563,0.211c-0.234,0-0.422-0.07-0.563-0.211L9.668,6.223
	                            c-0.329-0.375-0.329-0.75,0-1.125c0.375-0.328,0.75-0.328,1.125,0l1.512,1.512c-0.118-1.406-0.691-2.602-1.723-3.586
	                            C9.55,2.039,8.332,1.547,6.926,1.547c-1.477,0-2.737,0.533-3.779,1.6C2.104,4.213,1.582,5.508,1.582,7.031
	                            c0,1.524,0.521,2.818,1.564,3.885c1.042,1.067,2.314,1.6,3.814,1.6c1.078,0,2.086-0.316,3.023-0.949
	                            c0.188-0.141,0.387-0.193,0.598-0.158s0.375,0.146,0.492,0.334c0.304,0.422,0.246,0.786-0.176,1.09
	                            c-1.172,0.821-2.484,1.23-3.938,1.23c-1.922,0-3.563-0.686-4.922-2.057C0.68,10.635,0,8.977,0,7.031
	                            c0-1.945,0.68-3.604,2.039-4.975C3.398,0.686,5.039,0,6.961,0c1.781,0,3.334,0.61,4.658,1.828c1.324,1.219,2.068,2.73,2.232,4.535
	                            l1.23-1.266c0.375-0.328,0.75-0.328,1.125,0C16.582,5.473,16.594,5.848,16.242,6.223z"></path>
	                    </g>
	                </svg>
				</a>

				<?php wp_nonce_field( 'qi_templates_reload_demo_import', 'qi_templates_reload_demo_import' ); ?>

				<a href="<?php echo esc_url( $welcome_page_url ); ?>" class="qodef-import-top-button">
					<span><?php echo esc_html( $welcome_page_title ); ?></span>
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					     width="9px" height="9px" viewBox="0 0 9 9" enable-background="new 0 0 9 9" xml:space="preserve">
		                <g>
			                <path fill="#010101" d="M0.164,8.067c0.013-0.014,6.985-6.983,6.985-6.983L2.332,1.06C1.963,1.075,1.779,0.9,1.781,0.533
		                            c0-0.367,0.184-0.542,0.55-0.526h6.134C8.544-0.008,8.617,0,8.68,0.032C8.744,0.064,8.8,0.103,8.848,0.151
		                            C8.897,0.199,8.936,0.255,8.97,0.318C9,0.383,9.008,0.454,8.992,0.534v6.13c0.017,0.366-0.158,0.551-0.526,0.55
		                            c-0.368,0.001-0.544-0.183-0.527-0.55L7.916,1.85L0.93,8.832C0.818,8.944,0.69,9,0.547,9C0.054,9-0.182,8.413,0.164,8.067z"/>
		                </g>
		            </svg>
				</a>
			</div>
		</div>

		<div class="qodef-import-masonry-list-holder">
			<?php qi_templates_template_part( 'admin/admin-pages/sub-pages/import', 'templates/demos-list', '', $params ); ?>
		</div>
	</div>

	<div class="qodef-demo-single">
		<?php
		if ( isset( $single_demo ) && '' !== $single_demo ) {
			$params = array(
				'demo'          => $single_demo,
				'demo_key'      => $single_demo_id,
				'content_files' => $content_files,
			);

			qi_templates_template_part( 'admin/admin-pages/sub-pages/import', 'templates/content-single', '', $params );
		}
		?>
	</div>
<?php } else { ?>
	<p>
		<?php echo sprintf(
	'%s <a href="%s" target="_self">%s</a> %s.',
			esc_html__( 'Plugin licence has not been activated. Please navigate to', 'qi-templates' ),
			admin_url( 'admin.php?page=' . Qi_Templates_Admin_Page_Registration::get_instance()->get_menu_slug() ),
			esc_html__( 'Registration page', 'qi-templates' ),
			esc_html__( 'and activate your licence', 'qi-templates' ),
		); ?>
	</p>
<?php }

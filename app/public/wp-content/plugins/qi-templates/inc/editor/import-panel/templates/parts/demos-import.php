<?php $url = class_exists( 'Qi_Templates_Admin_Sub_Page_Import' ) ? admin_url( 'admin.php?page=' . ( new Qi_Templates_Admin_Sub_Page_Import() )->get_menu_slug() ) : ''; ?>

<div class="qi-templates-import-modal-demos-import">
	<h2 class="qi-templates-import-modal-demos-import-title"><?php echo esc_html__( 'Click here to find a Qi demo  you wish to import.', 'qi-templates' ); ?></h2>
	<a href="<?php echo esc_url( $url ); ?>"
	   class="qi-templates-import-modal-demos-import-button"><?php echo esc_html__( 'Import Demo', 'qi-templates' ); ?></a>
</div>
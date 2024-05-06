<?php

require_once QI_TEMPLATES_ADMIN_PATH . '/admin-pages/class-qi-templates-admin-general-page.php';
require_once QI_TEMPLATES_ADMIN_PATH . '/admin-pages/class-qi-templates-admin-sub-pages.php';

foreach ( glob( QI_TEMPLATES_ADMIN_PATH . '/admin-pages/sub-pages/*/include.php' ) as $page ) {
	require_once $page;
}

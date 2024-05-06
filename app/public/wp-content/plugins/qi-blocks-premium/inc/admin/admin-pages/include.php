<?php

foreach ( glob( QI_BLOCKS_PREMIUM_ADMIN_PATH . '/admin-pages/sub-pages/*/include.php' ) as $page ) {
	require_once $page;
}

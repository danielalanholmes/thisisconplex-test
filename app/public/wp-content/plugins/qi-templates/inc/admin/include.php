<?php

foreach ( glob( QI_TEMPLATES_ADMIN_PATH . '/*/include.php' ) as $module ) {
	require_once $module;
}
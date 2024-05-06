<?php

foreach ( glob( QI_TEMPLATES_EDITOR_PATH . '/*/include.php' ) as $module ) {
	require_once $module;
}
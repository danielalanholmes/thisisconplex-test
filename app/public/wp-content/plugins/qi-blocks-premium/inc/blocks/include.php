<?php

// Hook to include additional element before blocks inclusion
do_action( 'qi_blocks_premium_action_before_include_blocks' );

foreach ( glob( QI_BLOCKS_PREMIUM_BLOCKS_PATH . '/*/*-block.php' ) as $block ) {
	require_once $block;
}

// Hook to include additional element after blocks inclusion
do_action( 'qi_blocks_premium_action_after_include_blocks' );

<?php
esc_html_e( 'We hope you\'re having a great time using the Qi Import', 'qi-templates' );
?>
	<br/>
<?php
printf(
	esc_html__( 'Leave a %s let us know about your experience!', 'qi-templates' ),
	'<a href="https://wordpress.org/plugins/qi-templates/#reviews">' . esc_html__( 'rating', 'qi-templates' ) . '</a>'
);

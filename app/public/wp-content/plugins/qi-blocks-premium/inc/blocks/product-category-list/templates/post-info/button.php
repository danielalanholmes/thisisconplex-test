<?php
$params['button_link']    = array( 'url' => get_term_link( $category_slug, 'product_cat' ) );
$params['button_classes'] = qi_blocks_button_get_holder_classes( $params );
$params['icon_classes']   = qi_blocks_button_get_icon_classes( $params );
$params['buttonText']     = ! empty( $buttonText ) ? esc_html( $buttonText ) : esc_html__( 'View More', 'qi-blocks-premium' );
$params['data_attrs']     = array( 'target' => '_self' );
?>
<div class="qodef-m-button"> 
	<?php
	qi_blocks_template_part( 'blocks/button', 'variations/' . $buttonType . '/templates/button', '', $params );
	?>
</div>

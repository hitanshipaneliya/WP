<?php



add_action( 'woocommerce_variation_options', 'add_custom_field_cage_code_to_variations', 10, 3 );
function add_custom_field_cage_code_to_variations( $loop, $variation_data, $variation ) {
    echo '<div class="cage_code_options_group options_group">';
        woocommerce_wp_text_input( array(
            'id' => 'amazon_line[' . $loop . ']',
            'label' => __( 'amazon', 'woocommerce' ),
            'value' => get_post_meta( $variation->ID, 'amazon_line', true )
        ));
        
    echo '</div>';
}

/* Save custom field on product variation save */
add_action( 'woocommerce_save_product_variation', 'magazine_save_custom_field_variations', 10, 2 );
function magazine_save_custom_field_variations( $variation_id, $i ) {
    $amazon_line = $_POST['amazon_line'][$i];
    if ( isset( $amazon_line ) ) update_post_meta( $variation_id, 'amazon_line', esc_attr( 
    $amazon_line ) );


}

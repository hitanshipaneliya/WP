<?php
// ===================================
	// color picker script
	jQuery('.color_picker').each(function(){
	    jQuery(this).wpColorPicker();
	});

// ===================================


// color picker add
add_action( 'admin_enqueue_scripts', 'color_picker_script');
if ( ! function_exists( 'color_picker_script' ) ){
    function color_picker_script($hook) {
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker');
        wp_enqueue_script( 'wp-color-picker');
    }
}
add_action( 'add_meta_boxes', 'color_picker_cases' );
function color_picker_cases() {
	add_meta_box(
		"colorp_upload",
		"Color Picker",
		"color_pickker_callback",
		"case_study",
		"normal",
		"high"
	);
}
if ( ! function_exists( 'color_pickker_callback' ) ){
    function color_pickker_callback( $post ){
        $custom = get_post_custom( $post->ID );
        $cs_bg_color = (isset($custom["cs_bg_color"][0])) ? $custom["cs_bg_color"][0] : '';
        wp_nonce_field( 'color_pickker_callback', 'color_picker_nonce' );
    ?>
     
        <div class="pagebox">
            <p class="separator">
                <h4><?php esc_attr_e('Background Color', 'mytheme_color' ); ?></h4>
                <input class="color_picker" type="text" name="cs_bg_color" value="<?php esc_attr_e($cs_bg_color); ?>"/>
            </p>
        </div>
    <?php
    }
}
// ========================================================
add_action('save_post', 'save_meta_for_case_study');
function save_meta_for_case_study($post_id){
	global $post;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	    return ;
	}
	if ( ! current_user_can( 'edit_posts', $post_id ) ){
        return ;
	}


	if ( !isset( $_POST['cs_bg_color'] ) || !wp_verify_nonce( $_POST['color_picker_nonce'], 'color_pickker_callback' ) ) {
        return;
    }
    $cs_bg_color = (isset($_POST["cs_bg_color"]) && $_POST["cs_bg_color"]!='') ? $_POST["cs_bg_color"] : '';
    update_post_meta($post_id, "cs_bg_color", $cs_bg_color);

}


// add color picker 
add_action( 'case_study_cat_add_form_fields', 'color_picker_add_taxonomy', 10, 2 );
function color_picker_add_taxonomy() {
    ?>
    <tr class="form-field">
			<th scope="row" valign="top">
				<label for="excerpt"><?php _e('Color'); ?></label>
			</th>
			<td>
				<input type="text" name="color_p" class="color_picker" value="">
			</td>
		</tr>

    <?php
}

// edit color picker
add_action( 'case_study_cat_edit_form_fields', 'color_picker_edit_taxonomy', 10, 2 );
function color_picker_edit_taxonomy($term) {
	$color_p = get_term_meta($term->term_id, 'color_p', true);
    ?>
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="excerpt"><?php _e('Color'); ?></label>
			</th>
			<td>
				<input type="text" name="color_p" class="color_picker" value="<?php echo $color_p ?>">
			</td>
		</tr>
    <?php
}

//  save code
function save_taxonomy_custom_field_meta( $term_id ) {
    if ( isset( $_POST['color_p'] ) ) {
        update_term_meta($term_id, 'color_p', $_POST['color_p']);
    }
}  
add_action( 'edited_case_study_cat', 'save_taxonomy_custom_field_meta', 10, 2 );  
add_action( 'create_case_study_cat', 'save_taxonomy_custom_field_meta', 10, 2 );
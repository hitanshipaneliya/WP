<?php
// ================================== ADD iMAGE In Taxonomy 
function taxonomy_add_custom_field() {
    ?>
    <div class="form-field term-image-wrap">
        <label for="cat-image"><?php _e( 'Image' ); ?></label>
        <p><a href="#" class="aw_upload_image_button button button-secondary"><?php _e('Upload Image'); ?></a></p>
        <input type="hidden" name="category_image" id="cat-image" value="" size="40" />
		<img src="<?php echo $image; ?>" height="100"  width="100" id="img_src" style="display:none">
    </div>
    <div class="form-field term-image-wrap">
        <label for="cat-image"><?php _e( 'Background Image' ); ?></label>
        <p><a href="#" class="aw_upload_image_button_bg button button-secondary"><?php _e('Upload background Image'); ?></a></p>
        <input type="hidden" name="category_image_bg" id="cat-image-bg" value="" size="40" />
        <img src="<?php echo $image_bg; ?>" height="100"  width="100" id="img_src_bg" style="display:none">
    </div>
    <div class="form-field term-image-wrap">
    	<label for="cat-image"><?php _e( 'content box script' ); ?></label>
        <?php
        $content_script= get_post_meta($post->ID, 'content_script' , true ) ;
        $wpEditor_script = wp_editor( htmlspecialchars_decode($content_script), 'content_script', array("media_buttons" => false) );
        ?>

    </div>

    <?php
}
add_action( 'pa_inverter_add_form_fields', 'taxonomy_add_custom_field', 10, 2 );
 
function taxonomy_edit_custom_field($term) {
    $image = get_term_meta($term->term_id, 'category_image', true);
    $image_bg = get_term_meta($term->term_id, 'category_image_bg', true);
    $alt_img_tag = get_term_meta($term->term_id, 'txt_alt_img', true);
    $content_script_1 = get_term_meta($term->term_id, 'content_script', true);
    ?>
    <tr class="form-field term-image-wrap">
        <th scope="row"><label for="category_image"><?php _e( 'Image' ); ?></label></th>
        <td>
            <p><a href="#" class="aw_upload_image_button button button-secondary"><?php _e('Upload Image'); ?></a></p><br/>
            <input type="hidden" name="category_image" id="cat-image" value="<?php echo $image; ?>" size="40" />
			<img src="<?php echo $image; ?>" height="100"  width="100" id="img_src">
        </td>
    </tr>
    <tr class="form-field term-image-wrap">
        <th scope="row"><label for="category_image_bg"><?php _e( 'Background Image' ); ?></label></th>
        <td>
            <p><a href="#" class="aw_upload_image_button_bg button button-secondary"><?php _e('Upload Image'); ?></a></p><br/>
            <input type="hidden" name="category_image_bg" id="cat-image-bg" value="<?php echo $image_bg; ?>" size="40" />
            <img src="<?php echo $image_bg; ?>" height="100"  width="100" id="img_src_bg">
        </td>
    </tr>
    <tr>
    	<th scope="row"><label for="cat-image"><?php _e( 'content box script' ); ?></label></th>
    	<td>
    		<?php
		        $wpEditor_script = wp_editor( htmlspecialchars_decode($content_script_1), 'content_script', array("media_buttons" => false) );
		        ?>
    	</td>
    </tr>

    <?php
}
add_action( 'pa_inverter_edit_form_fields', 'taxonomy_edit_custom_field', 10, 2 );


function aw_include_script() {
  
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
  
    wp_enqueue_script( 'awscript', plugins_url('our_product/js/awscript.js'), array('jquery'), null, false );
}
add_action( 'admin_enqueue_scripts', 'aw_include_script' );


// save code
function save_taxonomy_custom_meta_field( $term_id ) {
    if ( isset( $_POST['category_image'] ) ) {
        update_term_meta($term_id, 'category_image', $_POST['category_image']);
    }
    if ( isset( $_POST['category_image_bg'] ) ) {
        update_term_meta($term_id, 'category_image_bg', $_POST['category_image_bg']);
    } 
    if ( isset( $_POST['content_script'] ) ) {
        update_term_meta($term_id, 'content_script', $_POST['content_script']);
    }
}
add_action( 'edited_pa_inverter', 'save_taxonomy_custom_meta_field', 10, 2 );  
add_action( 'create_pa_inverter', 'save_taxonomy_custom_meta_field', 10, 2 );


// Register the column
function department_add_dynamic_hooks() {
	$taxonomy = 'pa_inverter';
	add_filter( 'manage_' . $taxonomy . '_custom_column', 'department_taxonomy_rows',15, 3 );
	add_filter( 'manage_edit-' . $taxonomy . '_columns',  'department_taxonomy_columns' );
}
add_action( 'admin_init', 'department_add_dynamic_hooks' );

function department_taxonomy_columns( $original_columns ) {
	$new_columns = $original_columns;
	array_splice( $new_columns, 1 );
	$new_columns['frontpage'] = esc_html__( 'Image', 'taxonomy-images' );
	return array_merge( $new_columns, $original_columns );
}

function department_taxonomy_rows( $row, $column_name, $term_id ) {
	$t_id = $term_id;
	$meta = get_option( "taxonomy_$t_id" );

 	$term_meta =  get_term_meta($t_id, 'category_image', true);
 	$image_url = '';

 	if(@$term_meta)
 	{
    	$image_url = $term_meta;
 	}
 	else{
	    $image_url = get_site_url().'/wp-content/uploads/woocommerce-placeholder.png';
 	}

	// echo "<pre>";
	// print_r($term_meta);
	// echo "</pre>";

	if ( 'frontpage' === $column_name ) {
	    if ($meta == true) {
	        // return $row . 'Yes';
	        return $row = '<img src="'.$image_url.'" width="60px" height="60px" style="object-fit:contain">';

	    } else {
	        // return $row . 'No';
	        return $row = '<img src="'.$image_url.'" width="60px" height="60px" style="object-fit:contain">';
	    }   
	}
}





// background iamge
 $('body').on('click', '.aw_upload_image_button_bg', function(e){
    e.preventDefault();
    aw_uploader = wp.media({
        title: 'Custom bg image',
        button: {
            text: 'Use this image'
        },
        multiple: false
    }).on('select', function() {
        var attachment = aw_uploader.state().get('selection').first().toJSON();
        $('#cat-image-bg').val(attachment.url);
        $('#img_src_bg').attr('src', attachment.url);
        $('#img_src_bg').show();
    })
    .open();
});
// image  upload
 $('body').on('click', '.aw_upload_image_button', function(e){
    e.preventDefault();
    aw_uploader = wp.media({
        title: 'Custom image',
        button: {
            text: 'Use this image'
        },
        multiple: false
    }).on('select', function() {
        var attachment = aw_uploader.state().get('selection').first().toJSON();
        $('#cat-image').val(attachment.url);
        $('#img_src').attr('src', attachment.url);
        $('#img_src').show();
    })
    .open();
});
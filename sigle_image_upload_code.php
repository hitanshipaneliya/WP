<!-- sigle image upload code -->
<script type="text/javascript">
// single image upload code
jQuery(document).ready(function(){

    jQuery('body').on('click', '.single_img_upload', function(e){
        e.preventDefault();

            var data_id = jQuery(this).data("id");

        aw_uploader = wp.media({
            title: 'Custom image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = aw_uploader.state().get('selection').first().toJSON();

            jQuery('#image_'+data_id+'__up').val(attachment.url);
            jQuery('#image_'+data_id+'_src').attr('src', attachment.url);
            jQuery('#image_'+data_id+'_src').show();
        })
        .open();
    });
});
</script>

<?php

add_action( 'add_meta_boxes', 'image_upload_' );
function image_upload_() {
    add_meta_box(
        "image_upload",
        "Image Upload",
        "image_upload_callback",
        "case_study",
        "normal",
        "high"
    );
}

function image_upload_callback($post){
    global $post;

    $image_1_up = get_post_meta($post->ID, 'image_1_up', true );
    ?>

    <div class="image_upload_box">
        <span class="cases_title">
            Project Logo Upload
        </span>

        <div class="form-field term-image-wrap">
            <p>
                <a href="#" class="single_img_upload button button-secondary" data-id="1"><?php _e('Upload Image'); ?></a>
            </p>
            <input type="hidden" name="image_1_up" id="image_1__up" value="<?php echo @$image_1_up; ?>" size="40" />
            <?php
                if(@$image_1_up){
            ?>
                    <img src="<?php echo @$image_1_up; ?>" height="100"  width="100" id="image_1_src">
            <?php
                }
                else{
            ?>
                    <img src="<?php echo @$image_1_up; ?>" height="100"  width="100" id="image_1_src" style="display: none;">
            <?php
                }
            ?>
        </div>

        
    </div>

    <?php
}

function aw_include_script_custom() {
  
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
  
    wp_enqueue_script( 'awscript', plugins_url('custom-our-team/assets/js/awscript.js'), array('jquery'), null, false );
}
add_action( 'admin_enqueue_scripts', 'aw_include_script_custom' );

//=============== SAVE META VALUE
add_action( 'save_post', 'wc_meta_box_save_img' );
function wc_meta_box_save_img( $post_id ) {
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return; 
    }
    if( !current_user_can( 'edit_posts' ) ){        
        return; 
    }

      // pre($_POST);
      // die;

    if(isset($_POST['image_1_up'])){
            update_post_meta($post_id, 'image_1_up',$_POST['image_1_up']);
    }
    
}

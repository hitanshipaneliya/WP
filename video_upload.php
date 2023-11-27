<?php
// video add meta box
function video_meta_box() {
  add_meta_box(
   'video_description',     // $id aa id che
   'video',     // $title aya title
   'video_add_callback',      // $callback
   'movie',                 // $page aa post type che
   'normal',                  // $context
   'high'                     // $priority
  );
}
add_action('add_meta_boxes', 'video_meta_box');
function video_add_callback($post){
    global $post;
    $postId = $post->ID;
    $album_feat_img = get_post_meta($postId,'album_feat_img',true);
    ?>

    <div class="video_row">
        <span class="oe_title">video add</span>

        <div class="form-field term-image-wrap">
            <p>
                <a href="#" class="aw_upload_image_button_featu button button-secondary"><?php _e('Upload Image'); ?></a>
                <a href="#" class="remove_video_btn button button-secondary">remove</a>
            </p>
            <input type="hidden" name="album_feat_img" id="album_feat_img" value="<?php echo @$album_feat_img; ?>" />       
            <div class="video_box">
                <?php
                    if(@$album_feat_img){
                ?>
                        <video width="320" height="240" controls id="team_image" autoplay="" muted type="video/mp4">            
                            <source src="<?php echo @$album_feat_img; ?>" autostart="false">
                        </video>
                <?php 
                    } 
                ?>
            </div>
            <!-- <iframe src="" title="" id="video_main"></iframe> -->          
        </div>
    </div>
    <script type="text/javascript">
    jQuery(function(jQuery){
       
        jQuery('body').on('click', '.aw_upload_image_button_featu', function(e){
            e.preventDefault();
            aw_uploader = wp.media({
                title: 'Custom image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            }).on('select', function() {
                var attachment = aw_uploader.state().get('selection').first().toJSON();

                console.log("attachment" , attachment);
                console.log("video url" , attachment.url);

                jQuery('#album_feat_img').val(attachment.url);
                jQuery('#album_feat_img').attr('src', attachment.url);
                jQuery('.video_box').html('<video width="320" height="240" controls id="team_image" autoplay="" muted type="video/mp4"><source src="'+attachment.url+'" type="video/mp4"  autostart="false"></video>');
                jQuery('#video_main').attr('src', attachment.url);
                jQuery('#album_feat_img').show();
            })
            .open();
        });

        // remove video code
        jQuery('body').on('click', '.remove_video_btn', function(e){
            e.preventDefault();
            jQuery('#team_image').empty();
            jQuery("#album_feat_img").val("");
            jQuery('.video_box').remove();

        });
    });
    </script>
    <?php
}

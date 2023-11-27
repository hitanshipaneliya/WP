<?php 
// photo andd video add
function photo_meta_box() {
  add_meta_box(
   'photo_description',     // $id aa id che
   'Photo and Video Upload',     // $title aya title
   'photo_callback',      // $callback
   'movie',                 // $page aa post type che
   'normal',                  // $context
   'high'                     // $priority
  );
}
add_action('add_meta_boxes', 'photo_meta_box');
function photo_callback($post){
	global $post;
	$postId = $post->ID;
	$gallery_img = get_post_meta($postId,'gallery_img', true);
	?>

	<div class="photo_row">
		<div class="galery_title">
			<span>image upload</span>

		</div>
		<?php echo multi_media_uploader_field( 'gallery_img', $gallery_img, $postId );?>
	</div>
	<?php
}
// image function
function multi_media_uploader_field($name, $value = '', $postId = 0 ) {
	$image = '">Add Media';
	$image_str = '';
	$image_size = 'full';
	$display = 'none';
	$value = explode(',', $value);

	$photo_img_type = get_post_meta($postId,'photo_img_type', true);

	if (!empty($value)) {
	    foreach ($value as $key => $values) {

	     	if ($image_attributes = wp_get_attachment_image_src($values, $image_size)) {
	        	$image_str .= '<li data-attechment-id=' . $values . '>';
	        	$image_str .= '<a href="' . $image_attributes[0] . '" target="_blank">';
	        	$image_str .= '<img src="' . $image_attributes[0] . '" />';
	        	$image_str .= '</a>';
	        	$image_str .= '<input type="hidden" name="photo_img_type[]" value="'.$photo_img_type[$key].'" id="photo_img_type">';
	        	$image_str .= '<i class="dashicons dashicons-no delete-img" data-name="'.$name.'"></i>';
	        	$image_str .= '</li>';
	      	}else{
	      			
	      		$video_url = wp_get_attachment_url( $values );
	      		// pre($video_url);
	      		if($video_url){
		      		$image_str .= '<li data-attechment-id=' . $values . '>';
		      		$image_str .= '<a href="' . $video_url . '" target="_blank">';
		      		$image_str .= '<video width="100" height="100" controls id="true_pre_image" autoplay="" muted type="video/mp4">';
		      		$image_str .= '<source src="'.$video_url.'" autostart="false">';
		      		$image_str .= '</video>';
		      		$image_str .= '</a>';
		      		$image_str .= '<input type="hidden" name="photo_img_type[]" value="'.$photo_img_type[$key].'" id="photo_img_type">';
		      		$image_str .= '<i class="dashicons dashicons-no delete-img" data-name="'.$name.'"></i>';
		      		$image_str .= '</li>';
	      		}
	      	}
	    }
	}

	if($image_str){
	  	$display = 'inline-block';
	}

  	return '<div class="multi-upload-medias '.$name.' "  ><ul class="multi_image_ul">' . $image_str . '</ul><a href="#" class="wc_multi_upload_image_button button' . $image . '</a><input type="hidden" class="attechments-ids ' . $name . '" name="' . $name . '" id="' . $name . '" value="' . esc_attr(implode(',', $value)) . '" /><a href="#" class="wc_multi_remove_image_button button img_cus_rm_btn" style="display:inline-block;display:' . $display . '">Remove media</a></div>';
}


// get js file
function aw_include_script_custom() {
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
     wp_enqueue_script( 'awscript', plugins_url('custom-movies-post/assets/js/awscript.js'), array('jquery'), null, false );
}
add_action( 'admin_enqueue_scripts', 'aw_include_script_custom' );

?>
<script type="text/javascript">

jQuery(function($)
{
  	$('body').on('click', '.wc_multi_upload_image_button', function(e) {
    	e.preventDefault();
        console.log("->>>>>>");
        var button = $(this),
        custom_uploader = wp.media({
	         title: 'Insert image',
	         button: { text: 'Use this image' },
	         multiple: true 
        }).on('select', function() {
      	var attech_ids = '';
      	attachments
      	var attachments = custom_uploader.state().get('selection'),
      	attachment_ids = new Array(),
      	i = 0;

      	console.log("attachments----->", attachments);
      	attachments.each(function(attachment) {
        attachment_ids[i] = attachment['id'];
        attech_ids += ',' + attachment['id'];
        console.log("attachment.attributes.type--->",attachment.attributes.type);

        var photoType = attachment.attributes.type;
        console.log("photoType---------->", photoType);

       
        var attachmentId = attachment['id'];

        if (attachment.attributes.type == 'image') {
          	$(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '" class="uniq_class_' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.url + '" /></a><input type="hidden" name="photo_img_type[]" placeholder="Image" id="photo_img_type"><i class=" dashicons dashicons-no delete-img"></i></li>');
        } else {
          	// $(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.icon + '" /></a><input type="text" name="photo_img_type[]" placeholder="Video" ><i class=" dashicons dashicons-no delete-img"></i></li>');

          	console.log("attachment.attributes.type--> elseee",attachment.attributes.type);
          		$(button).siblings('ul').append('<li class="uniq_class_' + attachment['id'] + '" data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"> <video width="70" height="70" controls id="true_pre_image" autoplay="" muted type="video/mp4"><source src="' + attachment.attributes.url +'" autostart="false"></video></a><input type="hidden" name="photo_img_type[]" placeholder="Enter Video" id="photo_img_type"><i class=" dashicons dashicons-no delete-img"></i></li>');
        }
         
       jQuery(".uniq_class_"+attachmentId+" input").val(photoType);

        i++;

    });

    var ids = $(button).siblings('.attechments-ids').attr('value');
    if (ids) {
        var ids = ids + attech_ids;
        $(button).siblings('.attechments-ids').attr('value', ids);
    } else {
        $(button).siblings('.attechments-ids').attr('value', attachment_ids);
    }
      	$(button).siblings('.wc_multi_remove_image_button').show();
    })
    .open();
});

$('body').on('click', '.wc_multi_remove_image_button', function() {
  	// console.log("remove ->>>>>>");
    $(this).hide().prev().val('').prev().addClass('button').html('Add Media');
    $(this).parent().find('ul').empty();
    return false;
});

});

jQuery(document).ready(function() {
  	jQuery(document).on('click', '.multi-upload-medias ul li i.delete-img', function() {
  		
        var ids = [];
        var this_c = jQuery(this);
        var this_class_name = jQuery(this).data('name');
        // console.log(" id remove ->>>>>>",this_class_name);
        jQuery(this).parent().remove();
        jQuery('.'+this_class_name+' ul li').each(function() {
          ids.push(jQuery(this).attr('data-attechment-id'));
        });
        jQuery('.'+this_class_name+'').find('input[type="hidden"]').attr('value', ids);
  	});
});

</script>
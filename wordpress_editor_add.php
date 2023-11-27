<?php

// synopsis description
function synopsis_meta_box() {
  add_meta_box(
   'synopsis_description',     // $id aa id che
   'Synopsis Description',     // $title aya title
   'synopsis_callback',      // $callback
   'movie',                 // $page aa post type che
   'normal',                  // $context
   'high'                     // $priority
  );
}
add_action('add_meta_boxes', 'synopsis_meta_box');
function synopsis_callback($post){
	global $post;
	$postId = $post->ID;
	$synopsis_content = get_post_meta($postId,'synopsis_content', true);
	?>

	<div class="synopsis_row">
		<span class="oe_title">Synopsis Description</span>
		<div class="synopsis_content">
			<?php
  			$content = get_post_meta($post->ID, 'synopsis_content' , true ) ;
        $wpEditor = wp_editor( htmlspecialchars_decode($content), 'synopsis_content', array("media_buttons" => false) );
      ?>
		</div>
	</div>

	<?php
}
// -----------------------------
//=============== SAVE META VALUE
add_action( 'save_post', 'wc_meta_box_save' );
function wc_meta_box_save( $post_id ) {
  	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    	return; 
  	}
  	if( !current_user_can( 'edit_posts' ) ){	
    	return; 
  	}

  	// pre($_POST);
  	// die;

	if(isset($_POST['synopsis_content'])){
		update_post_meta($post_id, 'synopsis_content',$_POST['synopsis_content']);
	}
}





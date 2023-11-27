<?php
//---------- blog innerpage -----------
add_shortcode('blog_inner_show','blog_inner_show'); //[blog_inner_show]
function blog_inner_show(){
	$html ="";
	$args = array(
		'post_type' => 'post',
		"posts_per_page" => 5,
		"orderby"        => "date",
		"order"          => "DESC"
	);  

  	$the_query = new WP_Query($args);  

	global $post;
	$id = $post->ID;
	$video_post_link = get_post_meta($id,'video_post_link'); 
	$date = date_format(date_create($post->post_date),"F d, Y");  
	$auth_id = $post->post_author; 
	$author = get_the_author_meta( 'display_name' , $auth_id );
	$url = wp_get_attachment_url( get_post_thumbnail_id($id), 'thumbnail');
	$image = "";
	$categories = get_categories( array(
	    'orderby' => 'name',
	    'order'   => 'ASC'
	) );

	// echo "<pre>";
	// print_r($categories);
	// echo "</pre>";

	if($url){
		$image = $url;
	}
	else{
		$image = get_site_url(). '/wp-content/uploads/woocommerce-placeholder.png';
	}

	$html .='<div class="blog_inner_box">';

		// left side
		$html .='<div class="blog_innerp_left_col">';
			$html .='<div class="blog_innner_title">';
				$html .='<span>'.get_the_title().'</span>';
			$html .='</div>';
			$html .='<div class="blog_inner_image">';
			if(@$video_post_link){
				$html .='<iframe src="'.@$video_post_link[0].'"></iframe>';
			}else{
				$html .='<img src="'.$image.'">';
			}
			$html .='</div>';
			$html .='<div class="blog_inner_detail">';
				$html .='<ul>';
					$html .='<li>';
						$html .='<i class="fa fa-calendar"></i>';
						$html .='<span>'.$date.'</span>';
					$html .='</li>';
					$html .='<li>';
						$html .='<i class="fa fa-user"></i>';
						$html .='<span>'.$author.'</span>';
					$html .='</li>';
				$html .='</ul>';
				$html .='<div class="blog_inner_text">';
					$html .='<span>'.get_the_content().'</sapn>';
				$html .='</div>';
			$html .='</div>';

		$html .='</div>';

    	// right side

	    if ( $the_query->have_posts() ) {
			$html .='<div class="blog_innerp_right_col">';
				$html .='<div class="blog_innerp_right">';
					// share button
					$html .='<div class="blog_share_icon">';
						$html .='<div class="recent_title">';
							$html .='<sapn>share</span>';
						$html .='</div>';
						$html .='<div class="social_outter_block">';
							$html .='<div class="social_inner_block">';
								$html .='<a href="https://www.facebook.com/BKCProhub/" target="_blank" rel="noopener">';
									$html .='<div class="icon_block">';
										$html .='<i class="fa fa-facebook-f" aria-hidden="true"></i>';
									$html .='</div>';
								$html .='</a>';
							$html .='</div>';
							$html .='<div class="social_inner_block">';
								$html .='<a href="https://www.instagram.com/bkcprohub/" target="_blank" rel="noopener">';
									$html .='<div class="icon_block">';
										$html .='<i class="fa fa-instagram" aria-hidden="true"></i>';
									$html .='</div>';
								$html .='</a>';
							$html .='</div>';
							$html .='<div class="social_inner_block">';
								$html .='<a href="https://www.linkedin.com/company/bkcprohub/" target="_blank" rel="noopener">';
									$html .='<div class="icon_block">';
										$html .='<i class="fa fa-linkedin" aria-hidden="true"></i>';
									$html .='</div>';
								$html .='</a>';
							$html .='</div>';
						$html .='</div>';
					$html .='</div>';

	              	// recent posts
		            $html .='<div class="recent_title">';
		              	$html .='<sapn>recent posts</span>';
		            $html .='</div>';           

					while($the_query->have_posts() ) {
						$the_query->the_post();
						global $post;
						$image_ur = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail');

						$html .='<div class="recent_blog_box">';
							$html .='<div class="recent_blog_image">';
								$html .='<a href="'.get_permalink().'"><img src="'.$image_ur.'"></a>';
							$html .='</div>';
							$html .='<div class="recent_blog_title">';
								$html .='<span>'.get_the_title().'</span>';
							$html .='</div>';
							$html .='<div class="recent_detail">';
								$html .='<ul>';
									$html .='<li>';
										$html .='<span>'.$date.'</span>';
									$html .='</li>';
									$html .='<li>';
										$html .='<span>'.$author.'</span>';
									$html .='</li>';
								$html .='</ul>';
							$html .='</div>';
						$html .='</div>';
		          	}

		          	// all category
		          	$html .='<div class="blog_all_category">';
	          			$html .='<div class="recent_title">';
			              	$html .='<sapn>category</span>';
	          			$html .='</div>';

		          	$html .= '<ul class="cat_outer">';

		         
				
		          	$catId = get_queried_object_id(); 
		          	$category_detail=get_the_category($catId);

		          	$sendArray1 = array();
		          	foreach ($category_detail as $ceFvalue) {
		          		$sendArray1[] = $ceFvalue->term_id;
		          	}
		          	
		          	$active_Class = "";

		          		foreach($categories as $cd){

		          			if (in_array($cd->term_id, $sendArray1))		          			
		          			{
		          				$active_Class = "active_cat";
		          			}
		          			else{
	          					$active_Class = "";
		          			}

						    $html .='<li class="blog_category_title '.$active_Class.' ">';
								$html .='<a href="'.get_category_link($cd->term_id).'" class="blog_cate_text">';
									$html .='<span>'.$cd->cat_name.'</span>';
								$html .='</a>';
							$html .='</li>';
						}
					$html .='</ul>';

	        	$html .='</div>';
	      	$html .='</div>';
	    }

    $html .='</div>'; 

  return $html;
}
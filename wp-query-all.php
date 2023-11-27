<?php 
'exclude'           => 35,

//  je post show na karvi hoi te
'post__not_in' => array(278),
'post__not_in'   => array( 71, 1 ),
// all post get
// =========================
$args = array(
    'post_type' => '',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'order'     => 'DESC',
);
$query = new WP_Query($args);
if($query->have_posts()) {
    while($query->have_posts()) {
        $query->the_post() ;
        global $post;
        $id = $post->ID;
        $url = wp_get_attachment_url( get_post_thumbnail_id($id), 'thumbnail');         
        $image = "";
        if($url){
            $image = $url;
        }
        else{
            $image = get_site_url(). '/wp-content/uploads/2022/08/placeholder.jpg';
        }
    }
    wp_reset_query();
}
// ============================

// texonomy get
// ============================
$terms = get_terms( array(
    'taxonomy' => 'client_logo_cat',
    'hide_empty' => 1,
    'order' => "DESC",
    'post_status' => 'publish',
    "posts_per_page" => -1,
));


$terms = get_the_terms( $post->ID, 'taxonomy');

$category_data = get_term($hashtag_cat_id);

// texonomy ni id pr thi tena data get karva
$term = get_term( $key );

// ============================


// ===========================
// specific post get 
$post_speci = array(4377, 4379, 4381);
    $args = array(
    'post_type' => 'our_product',
    'p'      => $post_speci,
    'post_status' => 'publish',
);

$the_query = new WP_Query( $args );
// ===========================




// texonomy pr thi post get

// ============================
$args = array(
  	'post_type' => 'post',  
    'post_status' => 'publish',      	    
	"posts_per_page" => -1,
	'tax_query' => array(
	    array(
	    	'taxonomy' => 'category',
	    	'field' => 'term_id',
	    	'terms' => 20
	    )
	)
);
// ============================


// get post dynamic
// ============================
function get_wp_queryPost($postType = "")
{
  	$args = array(  
        'post_type' => $postType,
        'post_status' => 'publish',
        'posts_per_page' => -1, 
        'orderby' => 'title', 
        'order' => 'DESC',
    );

   $loop = new WP_Query($args); 

   $posts = $loop->posts;

   return $posts;

}
// ============================

// get post image function dynamic
// ============================
// ================ GET POST IMAGE 
function get_postImage($postId)
{
	$url = wp_get_attachment_url( get_post_thumbnail_id($postId) );
	$image = "";

	if($url)
	{
		$image .= $url;
	}
	else{
		$image .= get_site_url() .'/wp-content/uploads/2022/10/placehodler-1-1.png';
	}	

	return $image;

}
// ============================


// category wise data get
add_shortcode('gb_service_data_show','gb_service_data_show'); // [gb_service_data_show gb_service_data_id=""]
function gb_service_data_show($cate_attr){

    $html = '';

    $get_cate_name = shortcode_atts(array(
        'gb_service_data_id' => '',
    ) , $cate_attr);
    $gb_serv_cat_id = $get_cate_name['gb_service_data_id'];


    // category na childern lav va mate
     $terms = get_terms(
        'services_category',
        array(
            'child_of' => $gb_serv_cat_id,
        )
    );


}


// date get
$date = get_the_date('d.M.Y', $id);

// // Featured image alt tag get 
// global $post

// $feat_image_id = get_post_thumbnail_id();
// attachment_url_to_postid
// $feat_image_alt = get_post_meta($feat_image_id, '_wp_attachment_image_alt', true);
// $image_alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true);

// image title get
// $feat_image_title = get_the_title($feat_image_id);



// ======================================
// only parent category show mate
$terms = get_terms( array(
    'taxonomy' => 'img_gly_cat',
    'hide_empty' => false,
    'post_status' => 'publish',
    'order' => "DESC",
    'parent' => 0
));


// sub category show karav

$sub_terms = get_terms( array(
    'taxonomy' => 'img_gly_cat', 
    'child_of' => $term_id,
    'parent' => $term_id, 
    'hide_empty' => false,
) );


// ======================================

// post type ma tag add karva
add_action( 'init', 'cases_tags' );
function cases_tags(){
    register_taxonomy( 
        'case_study_tag', //taxonomy 
        'case_study', //post-type
        array( 
            'hierarchical'  => false, 
            'label'         => __( 'Tags','taxonomy general name'), 
            'singular_name' => __( 'Tags', 'taxonomy general name' ), 
            'rewrite'       => true, 
            'query_var'     => true 
        )
    );
}
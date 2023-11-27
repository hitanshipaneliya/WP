<?php
// get the coupen 


function coupen_list()
{



    //  echo "<pre>";
    // print_r($all_categories);
    // print_r($cat_id);
    // echo "</pre>";
    // die;

    $query = new WP_Query(
        array(
            'post_type' => 'shop_coupon',
            'post_status' => 'publish',
        )
    );

    if ($query->have_posts()):

        $html = "";
        $html .= '<div class="product_coupen_main_box">';


        while ($query->have_posts()):
            $query->the_post();

            global $post;

            $post_id = get_the_ID();
            // pre($post);

            $post_excerpt = $post->post_excerpt;

            $html .= '<div class="cuopen_data_get_box">';
            $html .= '<div class="cupoen_text site_text">';
            $html .= '<span>' . $post_excerpt . '</span>';
            $html .= '</div>';
            $html .= '</div>';


        endwhile;

        $html .= '</div>';
        wp_reset_postdata();
    endif;
    return $html;


}
add_shortcode('coupen_list', 'coupen_list'); // [coupen_list]
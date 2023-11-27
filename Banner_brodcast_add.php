<?php
// Banner ma  home page ni link add karvi hoi to 
add_shortcode('get_breadcrumb','get_breadcrumb'); //[get_breadcrumb]
function get_breadcrumb() {
    $html ='';
    $html .='<a href="'.home_url().'" rel="nofollow"><span>Home</span></a>';
    if (is_category() || is_single()) {
        $html .='<span>&#187;</span>';
        // $html .=the_category(' &bull; ');
        if (is_single()) {
            // $html .=" &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
            $html .='<span>'.get_the_title().'</span>';
        }
    } 
    elseif (is_page()) {
        $html .='<span>&#187;</span>';
        $html .='<span>'.get_the_title().'</span>';
    } 
    elseif (is_search()) {
        $html .='&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ';
        $html .='<em>'.the_search_query().'</em>';
    }
    return $html;
}




// banner page title
add_shortcode('banner_title_show','banner_title_show');  // [banner_title_show]
function banner_title_show(){
    $page_id  = get_queried_object_id();

    $html = "";
    $html .=get_the_title($page_id);

    return $html;
}
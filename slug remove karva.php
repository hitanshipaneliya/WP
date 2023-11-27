<?php

// slug remove karva post type
function careerposition_remove_cpt_slug( $post_link, $post ) {
  if ( 'careerposition' === $post->post_type && 'publish' === $post->post_status ) {
      $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
  }
  return $post_link;
}
add_filter( 'post_type_link', 'careerposition_remove_cpt_slug', 10, 2 );

function careerposition_add_cpt_post_names_to_main_query( $query ) {
  // Return if this is not the main query.
  if ( ! $query->is_main_query() ) {
      return;
  }
  // Return if this query doesn't match our very specific rewrite rule.
  if ( ! isset( $query->query['page'] ) || 2 !== count( $query->query ) ) {
      return;
  }
  // Return if we're not querying based on the post name.
  if ( empty( $query->query['name'] ) ) {
      return;
  }
  // Add CPT to the list of post types WP will include when it queries based on the post name.
  $query->set( 'post_type', array( 'post', 'page', 'careerposition' ) );
}
add_action( 'pre_get_posts', 'careerposition_add_cpt_post_names_to_main_query' );







// =========================== REMOVE CUSTOM POST TYPE SLUG 
// =========================================================

function custom_remove_cpt_slug($post_link, $post, $leavename){
    if ('hk_product' != $post->post_type || 'publish' != $post->post_status)
    {
        return $post_link;
    }
    $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);

    return $post_link;
}

add_filter('post_type_link', 'custom_remove_cpt_slug', 10, 3);

function custom_parse_request_tricksy($query){
    // Only noop the main query
    if (!$query->is_main_query())
        return;

    // Only noop our very specific rewrite rule match
    if (2 != count($query->query) || !isset($query->query['page']))
    {
        return;
    }

    // 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
    if (!empty($query->query['name']))
    {
        $query->set('post_type', array('post', 'hk_product', 'page'));
    }
}

add_action('pre_get_posts', 'custom_parse_request_tricksy');

// =====================================================================
// ================== REMOVE TAXONOMY SLUG OF CUSTOM POST TYPE
add_filter('request', 'rudr_change_term_request', 1, 1 );

function rudr_change_term_request($query){
  
  $tax_name = 'hk-product-category'; // specify you taxonomy name here, it can be also 'category' or 'post_tag'
  
  // Request for child terms differs, we should make an additional check
  if( @$query['attachment'] ) :
    $include_children = true;
    $name = @$query['attachment'];
  else:
    $include_children = false;
    $name = $query['name'];
  endif;
  
  
  $term = get_term_by('slug', $name, $tax_name); // get the current term to make sure it exists
  
  if (isset($name) && $term && !is_wp_error($term)): // check it here
    
    if( $include_children ) {
      unset($query['attachment']);
      $parent = $term->parent;
      while( $parent ) {
        $parent_term = get_term( $parent, $tax_name);
        $name = $parent_term->slug . '/' . $name;
        $parent = $parent_term->parent;
      }
    } else {
      unset($query['name']);
    }
    
    switch( $tax_name ):
      case 'category':{
        $query['category_name'] = $name; // for categories
        break;
      }
      case 'post_tag':{
        $query['tag'] = $name; // for post tags
        break;
      }
      default:{
        $query[$tax_name] = $name; // for another taxonomies
        break;
      }
    endswitch;

  endif;
  
  return $query;
  
}













function custom_remove_cpt_slug($post_link, $post, $leavename)
{
    if ('services' != $post->post_type || 'publish' != $post->post_status)
    {
        return $post_link;
    }
    $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);

    return $post_link;
}

add_filter('post_type_link', 'custom_remove_cpt_slug', 10, 3);


function custom_parse_request_tricksy($query)
{
    // Only noop the main query
    if (!$query->is_main_query())
        return;

    // Only noop our very specific rewrite rule match
    if (2 != count($query->query) || !isset($query->query['page']))
    {
        return;
    }

    // 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
    if (!empty($query->query['name']))
    {
        $query->set('post_type', array('post', 'services', 'page'));
    }
}

add_action('pre_get_posts', 'custom_parse_request_tricksy');



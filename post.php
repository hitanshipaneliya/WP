<?php

// --------------------------------------------------
// featured image show menu
add_filter('manage_posts_columns', 'op_add_img_column');
function op_add_img_column($columns) {
  $columns = array_slice($columns, 0, 1, true) + array("links" => "Image") + array_slice($columns, 1, count($columns) - 1, true);
  return $columns;
}

add_filter('manage_posts_custom_column', 'op_manage_img_column', 10, 2);
function op_manage_img_column($column_name, $post_id) {
 if( $column_name == 'links' ) {
  echo get_the_post_thumbnail($post_id, 'thumbnail');
 }
 return $column_name;
}
// --------------------------------------------------
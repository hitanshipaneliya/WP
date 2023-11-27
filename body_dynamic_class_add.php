<?php
// body ma dynamic class add thai
function add_slug_body_class($classes)
{
    global $post;
    if (isset($post))
    {
        $classes[] = $post->post_type . '-site-' . $post->post_name;
    }

    return $classes;

}

add_filter('body_class', 'add_slug_body_class');


<?php

// learning
// product des meta box description
function product_meta_box()
{
    add_meta_box(
        'product_description',
        // $id aa id che
        'product Description',
        // $title aya title
        'product_callback',
        // $callback
        'product',
        // $page aa post type che
        'normal',
        // $context
        'high' // $priority
    );
}
add_action('add_meta_boxes', 'product_meta_box');
function product_callback($post)
{
    global $post;
    $postId = $post->ID;
    $product_content = get_post_meta($postId, 'product_content', true);
    ?>

    <div class="product_row">
        <span class="oe_title">Product Description</span>
        <div class="product_content">
            <?php
            $content = get_post_meta($post->ID, 'product_content', true);
            $wpEditor = wp_editor(htmlspecialchars_decode($content), 'product_content', array("media_buttons" => false));
            ?>
        </div>
    </div>

    <?php
}


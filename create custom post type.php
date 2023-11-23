<?php
// ===================================
// CREATING A SERVICE CUSTOM POST TYPE
// ===================================
function services_post_type() {
	$labels = array(
		'name'                => __( 'services' ),
		'singular_name'       => __( 'services'),
		'menu_name'           => __( 'services'),
		'parent_item_colon'   => __( 'Parent services'),
		'all_items'           => __( 'All services'),
		'view_item'           => __( 'View services'),
		'add_new_item'        => __( 'Add New services'),
		'add_new'             => __( 'Add New '),
		'edit_item'           => __( 'Edit services'),
		'update_item'         => __( 'Update services'),
		'search_items'        => __( 'Search services'),
		'not_found'           => __( 'Not Found'),
		'not_found_in_trash'  => __( 'Not found in Trash')
	);
	$args = array(
		'label'               => __( 'services'),
		'description'         => __( 'Best Service'),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'),
		'public'              => true,
    
		'hierarchical'        => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_icon'           => 'dashicons-hammer',
		'has_archive'         => true,
		'can_export'          => true,
		'exclude_from_search' => false,
	        'yarpp_support'       => true,
		
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
);
	register_post_type( 'services_post', $args );
}
add_action( 'init', 'services_post_type', 0 );

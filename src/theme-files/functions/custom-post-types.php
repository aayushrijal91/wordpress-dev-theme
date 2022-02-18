<?php
// Jobs
add_action('init', 'init_services_custom_post_type');
function init_services_custom_post_type() {
    $labels = array(
        'name'                  => __('Services'),
        'singular_name'         => __('Service'),
        'menu_name'             => __('Services'),
        'name_admin_bar'        => __('Service'),
        'add_new'               => __('Add New'),
        'add_new_item'          => __('Add New Service'),
        'new_item'              => __('New Service'),
        'edit_item'             => __('Edit Service'),
        'view_item'             => __('View Service'),
        'all_items'             => __('All Services'),
        'search_items'          => __('Search Services'),
        'parent_item_colon'     => __('Parent Services:'),
        'not_found'             => __('No Services found.'),
        'not_found_in_trash'    => __('No Services found in Trash.'),
        'featured_image'        => __('Service Image'),
        'set_featured_image'    => __('Set image'),
        'remove_featured_image' => __('Remove Service image'),
        'use_featured_image'    => __('Use as Service image'),
        'archives'              => __('Service archives'),
        'insert_into_item'      => __('Insert into Service'),
        'uploaded_to_this_item' => __('Uploaded to this Service'),
        'filter_items_list'     => __('Filter Service list'),
        'items_list_navigation' => __('Service list navigation'),
        'items_list'            => __('Service list'),        
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'services' ),
        'capability_type'    => 'post',
        'has_archive'        => 'services',
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports' => array( 'title', 'revisions', 'sticky', 'page-attributes', 'thumbnail')
    );
    register_post_type('services', $args);
}


// Let us create Taxonomy for Custom Post Type
add_action( 'init', 'init_services_taxonomy', 0 );
 
//create a custom taxonomy name it "type" for your posts
function init_services_taxonomy() {
 
  $labels = array(
    'name' => _x( 'Types', 'taxonomy general name' ),
    'singular_name' => _x( 'Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Types' ),
    'all_items' => __( 'All Types' ),
    'parent_item' => __( 'Parent Type' ),
    'parent_item_colon' => __( 'Parent Type:' ),
    'edit_item' => __( 'Edit Type' ), 
    'update_item' => __( 'Update Type' ),
    'add_new_item' => __( 'Add New Type' ),
    'new_item_name' => __( 'New Type Name' ),
    'menu_name' => __( 'Types' ),
  ); 	
 
  register_taxonomy('types', array('services'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'type' ),
  ));
}
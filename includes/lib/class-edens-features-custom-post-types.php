<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Register Custom Post Type
function custom_post_type_retailer() {

	$labels = array(
		'name'                  => 'Retailer',
		'singular_name'         => 'Retailer',
		'menu_name'             => 'Retailers',
		'name_admin_bar'        => 'Retailers',
		'archives'              => 'Retailer Archives',
		'parent_item_colon'     => 'Parent Retailer:',
		'all_items'             => 'All Retailers',
		'add_new_item'          => 'Add New Retailer',
		'add_new'               => 'Add New Retailer',
		'new_item'              => 'New Retailer',
		'edit_item'             => 'Edit Retailer',
		'update_item'           => 'Update Retailer',
		'view_item'             => 'View Retailer',
		'search_items'          => 'Search Retailer',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into Retailer',
		'uploaded_to_this_item' => 'Uploaded to this Retailer',
		'items_list'            => 'Retailers list',
		'items_list_navigation' => 'Retailers list navigation',
		'filter_items_list'     => 'Filter Retailers list',
	);
	$args = array(
		'label'                 => 'Retailer',
		'description'           => 'All retailers currently leasing at the center.',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', ),
		'taxonomies'            => array( 'locations' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-store',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'retailer', $args );

}
add_action( 'init', 'custom_post_type_retailer', 0 );

// Register Custom Taxonomy - Retailer_Locations
function Retailer_Locations() {

	$labels = array(
		'name'                       => 'Locations',
		'singular_name'              => 'Location',
		'menu_name'                  => 'Locations',
		'all_items'                  => 'All Locations',
		'parent_item'                => 'Parent Location',
		'parent_item_colon'          => 'Parent Location:',
		'new_item_name'              => 'Locations',
		'add_new_item'               => 'Add New Location',
		'edit_item'                  => 'Edit Location',
		'update_item'                => 'Update Location',
		'view_item'                  => 'View Location',
		'separate_items_with_commas' => 'Separate locations with commas',
		'add_or_remove_items'        => 'Add or remove Locations',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Locations',
		'search_items'               => 'Search Locations',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No Locations',
		'items_list'                 => 'Locations list',
		'items_list_navigation'      => 'Locations list navigation',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'retailer_locations', array( 'retailer' ), $args );

}
add_action( 'init', 'Retailer_Locations', 0 );

// Register Custom Taxonomy - Retailer_Category
function Retailer_Category() {

	$labels = array(
		'name'                       => 'Category',
		'singular_name'              => 'Category',
		'menu_name'                  => 'Categories',
		'all_items'                  => 'All Categories',
		'parent_item'                => 'Parent Category',
		'parent_item_colon'          => 'Parent Category:',
		'new_item_name'              => 'Categories',
		'add_new_item'               => 'Add New Category',
		'edit_item'                  => 'Edit Category',
		'update_item'                => 'Update Category',
		'view_item'                  => 'View Category',
		'separate_items_with_commas' => 'Separate Categories with commas',
		'add_or_remove_items'        => 'Add or remove Categories',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Categories',
		'search_items'               => 'Search Categories',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No Categories',
		'items_list'                 => 'Categories list',
		'items_list_navigation'      => 'Categories list navigation',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'retailer_category', array( 'retailer' ), $args );

}
add_action( 'init', 'Retailer_Category', 0 );
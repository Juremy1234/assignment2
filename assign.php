<?php
/*
Plugin Name: juremyplugin
Plugin URI: 
Description: Assignment 2 cct460
Author: Juremy Seochand
Author URI: 
Version: 1.0
*/

/*
* This code was taken from "http://www.wpbeginner.com/wp-tutorials/how-to-create-custom-post-types-in-wordpress/""
*/

// Our custom post type function

function cptcreate() {
   register_post_type( 'movies',
        array(
            'labels' => array(
                'name' => __( 'Movies' ),
                'singular_name' => __( 'Movie' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'movies'),
        )
    );

// Hooking up our function to theme setup

add_action( 'init', 'cptcreate' );

function cpt() {

// Set UI labels for Custom Post Type

    $labels = array(

        'name'                => _x( 'Movies', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'Movie', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'Movies', 'twentythirteen' ),
        'parent_item_colon'   => __( 'Parent Movie', 'twentythirteen' ),
        'all_items'           => __( 'All Movies', 'twentythirteen' ),
        'view_item'           => __( 'View Movie', 'twentythirteen' ),
        'add_new_item'        => __( 'Add New Movie', 'twentythirteen' ),
        'add_new'             => __( 'Add New', 'twentythirteen' ),
        'edit_item'           => __( 'Edit Movie', 'twentythirteen' ),
        'update_item'         => __( 'Update Movie', 'twentythirteen' ),
        'search_items'        => __( 'Search Movie', 'twentythirteen' ),
        'not_found'           => __( 'Not Found', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
    );

// Set other options for Custom Post Type

    $args = array(
        'label'               => __( 'movies', 'twentythirteen' ),
        'description'         => __( 'Movie news and reviews', 'twentythirteen' ),
        'labels'              => $labels,

        // Features this CPT supports in Post Editor

        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),

        // You can associate this CPT with a taxonomy or custom taxonomy.

        'taxonomies'          => array( 'genres' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );
 
// Registering your Custom Post Type

    register_post_type( 'movies', $args ); 
}

add_action( 'init', 'cpt', 0 );
add_action( 'pre_get_posts', 'register_cpt' );

function register_cpt( $query ) {

    if ( is_home() && $query->is_main_query() )
        $query->set( 'post_type', array( 'post', 'movies' ) );

    return $query;

}
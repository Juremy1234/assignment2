<?php
/*
Plugin Name: Custom Post Type 
Plugin URI: 
Description: Assignment 2 CCT460
Author: Juremy Seochand
Author URI: http://phoenix.sheridanc.on.ca/~ccit3668/
*/

/*
* I used code from this link to create the custom post type: "http://www.wpbeginner.com/wp-tutorials/how-to-create-custom-post-types-in-wordpress/""
* I used code from this link to help me create the widget: "http://michaelsoriano.com/wordpress-widget-custom-post-types/""
* I used code from this link to create our short code: "https://premium.wpmudev.org/blog/10-awesome-shortcodes-for-your-wordpress-blog/?ench=b&utm_expid=3606929-78.ZpdulKKETQ6NTaUGxBaTgQ.1"
*/

//I enqueued my style sheet
function stylep(){
    wp_enqueue_style('plugin-style', plugins_url('/css/style.css', __FILE__));
    }
add_action( 'wp_enqueue_scripts', 'stylep' );

class JsWidget extends WP_Widget {
    public function __construct() {
    $widget_ops    = array(
    'classname'    => 'widget_postblock',
    'description'  => __( 'displays 3 posts') );
    parent::__construct('show_custompost', __('Portfolio Post', 'My Travels'), $widget_ops);
               }
 
               public function widget ( $args, $instance ) {
 
    ?>
<div id="widgetstyle" role="main">
    <?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$wp_query = new WP_Query();
$wp_query->query('post_type=mytravels&posts_per_page=3' . '&paged=' . $paged);
?>
 
<?php if ($wp_query->have_posts()) : ?>
 
               <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
 
                              <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                              <div id="gridlayout">
                                <?php the_title();?>
                                <?php the_post_thumbnail('medium'); ?></a>
                              </div>
                  </article>
 
               <?php endwhile; ?>
<?php endif; ?>
    </div>
    <?php
    
               }
 
}
 
add_action( 'widgets_init', function(){
     register_widget( 'JsWidget' );
});

//Registering my Custom Post Type
function js_cpt() {
    register_post_type( 'mytravels',
        array(
            'labels' => array(
                'name' => __( 'My Travels' ),
                'singular_name' => __( 'mytravels' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'mytravels'),
        )
    );
}

add_action( 'init', 'js_cpt' );
function js_post() {

    $labels = array(
        'name'                => _x( 'mytravels', 'Post Type General Name', 'portfolio' ),
        'singular_name'       => _x( 'mytravels', 'Post Type Singular Name', 'portfolio' ),
        'menu_name'           => __( 'My Travels', 'portfolio' ),
        'parent_item_colon'   => __( 'Parent Travels', 'portfolio' ),
        'all_items'           => __( 'All projects', 'portfolio' ),
        'view_item'           => __( 'View project', 'portfolio' ),
        'add_new_item'        => __( 'Add new project', 'portfolio' ),
        'add_new'             => __( 'Add New', 'portfolio' ),
        'edit_item'           => __( 'Edit Project', 'portfolio' ),
        'update_item'         => __( 'Update Project', 'portfolio' ),
        'search_items'        => __( 'Search Project', 'portfolio' ),
        'not_found'           => __( 'Not Found', 'portfolio' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'portfolio' ),
    );

    $args = array(
        'label'               => __( 'projects', 'portfolio' ),
        'description'         => __( 'mytravels', 'portfolio' ),
        'labels'              => $labels,

        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),

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
    register_post_type( 'mytravels', $args );
}

add_action( 'init', 'js_post', 0 );
add_action( 'pre_get_posts', 'add_my_post_types_to_query' );
function add_my_post_types_to_query( $query ) {
    if ( is_home() && $query->is_main_query() )
        $query->set( 'post_type', array( 'post', 'mytravels' ) );
    return $query;
}

//This is an iframe shortcode that I found from https://premium.wpmudev.org/blog/10-awesome-shortcodes-for-your-wordpress-blog/?ench=b&utm_expid=3606929-78.ZpdulKKETQ6NTaUGxBaTgQ.1
//The video was filmed by me and posted on my YouTube account.
function vidsc($attr, $url) {
  return '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZTdQUjctsbw" frameborder="0" allowfullscreen></iframe>';
}
add_shortcode('embedvid', 'vidsc');
?>
<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link
 * @since             1.0.0
 * @package           News Item
 *
 * @wordpress-plugin
 * Plugin Name:       News Item
 * Plugin URI:
 * Description:       This plugin creates a News Item custom post type, and also creates an arhive page to display all the news items.
 * Version:           1.0.0
 * Author:            Brian Blosser
 * Author URI:        http://brianblosser.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function activate_news_item_plugin() {
  // trigger our function that registers the custom post type
  news_item_setup_post_type();

  // clear the permalinks after the post type has been registered
  flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'activate_news_item_plugin' );

function deactivate_news_item_plugin() {
  news_item_deactivation();
}
register_deactivation_hook( __FILE__, 'deactivate_news_item_plugin' );

function news_item_setup_post_type()
{
    // register the "news-item" custom post type
    register_post_type('news-item',
                       array(
                           'labels'      => array(
                              'name'          => __('News Items'),
                              'singular_name' => __('News Item'),
                              'add_new' => 'Add New',
                              'add_new_item' => __('Add New News Item'),
                              'edit_item' => __('Edit News Item'),
                              'new_item' =>  __('New News Item'),
                              'all_items' => __( 'All News Items' ),
                           ),
                           'description' => 'A piece of news that talks about the Divided City project.',
                           'public'      => true,
                           'has_archive' => true,
                           'show_in_menu'=> true,
                           'menu_position'=> 10,
                           'menu-icon'=> 'dashicons-media-document',
                           'capability-type' => 'news-item',
                           'supports' => array('title', 'revisions', 'thumbnail'),
                           'rewrite'     => array('slug' => 'news'),
                       )
    );
}
add_action( 'init', 'news_item_setup_post_type' );

function news_item_deactivation()
{
    // our post type will be automatically removed, so no need to unregister it

    // clear the permalinks to remove our post type's rules
    flush_rewrite_rules();
}

add_filter('template_include', 'include_news_item_template');
function include_news_item_template( $template ) {
  if ( is_post_type_archive('news-item') ) {
    return plugin_dir_path( __FILE__ ) . 'archive-news-item.php';
  }
  return $template;
}

// Enqueue plugin custom styles and scripts
add_action( 'wp_enqueue_scripts', 'news_item_enqueue_scripts');
function news_item_enqueue_scripts() {
	wp_enqueue_style( 'news-item-styles', plugins_url( 'style.css', __FILE__ ) , array(), null, 'all' );
}

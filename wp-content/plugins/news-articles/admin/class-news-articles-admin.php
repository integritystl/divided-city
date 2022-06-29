<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://eriksaulnier.com/
 * @since      1.0.0
 *
 * @package    News_Articles
 * @subpackage News_Articles/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    News_Articles
 * @subpackage News_Articles/admin
 * @author     Erik Saulnier <info@eriksaulnier.com>
 */
class News_Articles_Admin {

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $plugin_name       The name of this plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct( $plugin_name, $version ) {
    $this->plugin_name = $plugin_name;
    $this->version = $version;
  }

  /**
   * Registers custom post types for the plugin.
   *
   * @since   1.0.0
   */
  public function register_post_types() {
    $labels = array(
      'name'                  => _x( 'Articles', 'Post Type General Name', 'news-articles' ),
      'singular_name'         => _x( 'Article', 'Post Type Singular Name', 'news-articles' ),
      'menu_name'             => __( 'Articles', 'news-articles' ),
      'name_admin_bar'        => __( 'Article', 'news-articles' ),
      'archives'              => __( 'Article Archives', 'news-articles' ),
      'attributes'            => __( 'Article Attributes', 'news-articles' ),
      'all_items'             => __( 'All Articles', 'news-articles' ),
      'add_new_item'          => __( 'Add New Article', 'news-articles' ),
      'add_new'               => __( 'Add New', 'news-articles' ),
      'new_item'              => __( 'New Article', 'news-articles' ),
      'edit_item'             => __( 'Edit Article', 'news-articles' ),
      'update_item'           => __( 'Update Article', 'news-articles' ),
      'view_item'             => __( 'View Article', 'news-articles' ),
      'view_items'            => __( 'View Articles', 'news-articles' ),
      'search_items'          => __( 'Search Article', 'news-articles' ),
      'not_found'             => __( 'Not found', 'news-articles' ),
      'not_found_in_trash'    => __( 'Not found in Trash', 'news-articles' ),
      'featured_image'        => __( 'Featured Image', 'news-articles' ),
      'set_featured_image'    => __( 'Set featured image', 'news-articles' ),
      'remove_featured_image' => __( 'Remove featured image', 'news-articles' ),
      'use_featured_image'    => __( 'Use as featured image', 'news-articles' ),
      'insert_into_item'      => __( 'Insert into article', 'news-articles' ),
      'uploaded_to_this_item' => __( 'Uploaded to this article', 'news-articles' ),
      'items_list'            => __( 'Articles list', 'news-articles' ),
      'items_list_navigation' => __( 'Articles list navigation', 'news-articles' ),
      'filter_items_list'     => __( 'Filter articles list', 'news-articles' ),
    );
    $args = array(
      'label'                 => __( 'Article', 'news-articles' ),
      'description'           => __( 'Post Type Description', 'news-articles' ),
      'labels'                => $labels,
      'supports'              => array( 'title', 'thumbnail', ),
      'taxonomies'            => array( 'category', 'post_tag' ),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 5,
      'menu_icon'             => 'dashicons-admin-links',
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => 'articles',
      'exclude_from_search'   => false,
      'publicly_queryable'    => true,
      'capability_type'       => 'post',
    );
    register_post_type( 'article', $args );
  }

  /**
   * Fetches article information from link when post is saved.
   *
   * @since   1.0.0
   * @param   string    $post_id   The ID of the post being saved.
   */
  public function save_article( $post_id ) {
    if ( get_post_type( $post_id ) != 'article' )
      return;

    remove_action( 'save_post', array( $this, 'save_article' ), 100 );

    // Fetch the article link
    $link = get_post_meta( $post_id, 'article_information_link', true );
    if ( ! $link )
        return;

    // Use the scraper API to fetch article info
    $response = wp_remote_get( 'http://scraper.dev.eriksaulnier.com/api/scrape/' . urlencode( $link ) );
    $info = json_decode( wp_remote_retrieve_body( $response ), true );

    // Fetch existing values for article fields
    $data = array(
      'source' => get_post_meta( $post_id, 'article_information_source', true ),
      'title' => get_post_meta( $post_id, 'article_information_title', true ),
      'excerpt' => get_post_meta( $post_id, 'article_information_excerpt', true ),
      'image' => get_the_post_thumbnail( $post_id ),
      'date' => get_the_date( null, $post_id )
    );

    if ( empty( $data['title'] ) && isset( $info['title'] ) ) {
      $data['title'] = $info['title'];
    }
    if ( empty( $data['source'] ) && isset( $info['source'] ) ) {
      $data['source'] = $info['source'];
    }
    if ( empty( $data['excerpt'] ) && isset( $info['excerpt'] ) ) {
      $data['excerpt'] = $info['excerpt'];
    }
    if ( isset( $info['published'] ) ) {
      $data['date'] = $info['published'];
    }

    // Update post title accordingly
    wp_update_post( array(
      'ID' => $post_id,
      'post_title' => "[" . $data['source'] . "] " . $data['title'],
      'post_date' => date( 'Y-m-d H:i:s', strtotime( $data['date'] ) ),
      'post_date_gmt' => gmdate( 'Y-m-d H:i:s', strtotime( $data['date'] ) )
    ) );

    // Update all of the meta
    update_post_meta( $post_id, 'article_information_title', sanitize_text_field( $data['title'] ) );
    update_post_meta( $post_id, 'article_information_source', sanitize_text_field( $data['source'] ) );
    update_post_meta( $post_id, 'article_information_excerpt', sanitize_text_field( $data['excerpt'] ) );

    // If the response included an image, upload and attach it to the article
    if ( empty( $data['image'] ) && isset( $info['image'] ) ) {
      // Attempt to fetch image from url
      $http = new WP_Http();
      $response = $http->request( $info['image'] );

      if ( array_key_exists( 'response', $response) && $response['response']['code'] == 200 ) {
        // Upload it to the server
        $upload = wp_upload_bits( basename( $info['image'] ), null, $response['body'] );
        if ( !empty($upload['error'] ) )
          return false;

        // Get important file information and construct array
        $file_path = $upload['file'];
        $file_name = basename( $file_path );
        $file_type = wp_check_filetype( $file_name, null );
        $attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
        $wp_upload_dir = wp_upload_dir();
        $post_info = array(
          'guid'				=> $wp_upload_dir['url'] . '/' . $file_name,
          'post_mime_type'	=> $file_type['type'],
          'post_title'		=> $attachment_title,
          'post_content'		=> '',
          'post_status'		=> 'inherit',
        );

        // Insert attachment
        $attach_id = wp_insert_attachment( $post_info, $file_path, $post_id );

        // Include image.php
        require_once( ABSPATH . 'wp-admin/includes/image.php' );

        // Define attachment metadata
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

        // Assign metadata to attachment
        wp_update_attachment_metadata( $attach_id,  $attach_data );

        // Update image field
        set_post_thumbnail( $post_id, $attach_id );
      }
    }

    add_action( 'save_post', array( $this, 'save_article' ), 100 );
  }

}

<?php

/**
 *
 *
 * @package    News_Articles
 * @subpackage News_Articles/admin
 * @author     Erik Saulnier <info@eriksaulnier.com>
 */
class News_Articles_Admin_Metaboxes {
  /**
   * The ID of this plugin.
   *
   * @since 		1.0.0
   * @access 		private
   * @var 		string 			$plugin_name 		The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since 		1.0.0
   * @access 		private
   * @var 		string 			$version 			The current version of this plugin.
   */
  private $version;

  private $screens = array(
    'article',
  );

  private $fields = array(
    array(
      'id' => 'link',
      'label' => 'Link',
      'type' => 'url',
    ),
    array(
      'id' => 'source',
      'label' => 'Source',
      'type' => 'text',
    ),
    array(
      'id' => 'title',
      'label' => 'Title',
      'type' => 'text',
    ),
    array(
      'id' => 'excerpt',
      'label' => 'Excerpt',
      'type' => 'textarea',
    ),
  );

  /**
   * Initialize the class and set its properties.
   *
   * @since 		1.0.0
   * @param 		string 			$plugin_name 		The name of this plugin.
   * @param 		string 			$version 			The version of this plugin.
   */
  public function __construct( $plugin_name, $version ) {
    $this->plugin_name = $plugin_name;
    $this->version = $version;
  }

  /**
   * Hooks into WordPress' add_meta_boxes function.
   * Goes through screens (post types) and adds the meta box.
   */
  public function add_meta_boxes() {
    foreach ( $this->screens as $screen ) {
      add_meta_box(
        'article-information',
        __( 'Article Information', $this->plugin_name ),
        array( $this, 'add_meta_box_callback' ),
        $screen,
        'normal',
        'high'
      );
    }
  }

  /**
   * Generates the HTML for the meta box
   *
   * @param object $post WordPress post object
   */
  public function add_meta_box_callback( $post ) {
    wp_nonce_field( 'article_information_data', 'article_information_nonce' );
    $this->generate_fields( $post );
  }

  /**
   * Generates the field's HTML for the meta box.
   */
  public function generate_fields( $post ) {
    $output = '';
    foreach ( $this->fields as $field ) {
      $label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
      $db_value = get_post_meta( $post->ID, 'article_information_' . $field['id'], true );
      switch ( $field['type'] ) {
        case 'textarea':
          $input = sprintf(
            '<textarea class="large-text" id="%s" name="%s" rows="5">%s</textarea>',
            $field['id'],
            $field['id'],
            $db_value
          );
          break;
        default:
          $input = sprintf(
            '<input %s id="%s" name="%s" type="%s" value="%s">',
            $field['type'] !== 'color' ? 'class="regular-text"' : '',
            $field['id'],
            $field['id'],
            $field['type'],
            $db_value
          );
      }
      $output .= $this->row_format( $label, $input );
    }
    echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
  }

  /**
   * Generates the HTML for table rows.
   */
  public function row_format( $label, $input ) {
    return sprintf(
      '<tr><th scope="row">%s</th><td>%s</td></tr>',
      $label,
      $input
    );
  }
  /**
   * Hooks into WordPress' save_post function
   */
  public function save_post( $post_id ) {
    if ( ! isset( $_POST['article_information_nonce'] ) )
      return $post_id;

    $nonce = $_POST['article_information_nonce'];
    if ( !wp_verify_nonce( $nonce, 'article_information_data' ) )
      return $post_id;

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return $post_id;

    foreach ( $this->fields as $field ) {
      if ( isset( $_POST[ $field['id'] ] ) ) {
        switch ( $field['type'] ) {
          case 'email':
            $_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
            break;
          case 'text':
            $_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
            break;
        }
        update_post_meta( $post_id, 'article_information_' . $field['id'], $_POST[ $field['id'] ] );
      } else if ( $field['type'] === 'checkbox' ) {
        update_post_meta( $post_id, 'article_information_' . $field['id'], '0' );
      }
    }
  }

}

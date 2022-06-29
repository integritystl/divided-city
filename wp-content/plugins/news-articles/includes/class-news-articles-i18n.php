<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://eriksaulnier.com/
 * @since      1.0.0
 *
 * @package    News_Articles
 * @subpackage News_Articles/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    News_Articles
 * @subpackage News_Articles/includes
 * @author     Erik Saulnier <info@eriksaulnier.com>
 */
class News_Articles_i18n {


  /**
   * Load the plugin text domain for translation.
   *
   * @since    1.0.0
   */
  public function load_plugin_textdomain() {
    load_plugin_textdomain(
      'news-articles',
      false,
      dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
    );
  }



}

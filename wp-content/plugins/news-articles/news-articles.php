<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://eriksaulnier.com/
 * @since             1.0.0
 * @package           News_Articles
 *
 * @wordpress-plugin
 * Plugin Name:       News Articles
 * Description:       Adds a custom post type which allows you to post news articles on your site.
 * Version:           1.0.0
 * Author:            Erik Saulnier
 * Author URI:        https://eriksaulnier.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       news-articles
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

define( 'NEWS_ARTICLES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-news-articles-activator.php
 */
function activate_news_articles() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-news-articles-activator.php';
  News_Articles_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-news-articles-deactivator.php
 */
function deactivate_news_articles() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-news-articles-deactivator.php';
  News_Articles_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_news_articles' );
register_deactivation_hook( __FILE__, 'deactivate_news_articles' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-news-articles.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_news_articles() {
  $plugin = new News_Articles();
  $plugin->run();
}
run_news_articles();

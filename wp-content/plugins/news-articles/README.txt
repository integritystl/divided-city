=== News Articles ===
Contributors: eriksaulnier
Donate link: https://eriksaulnier.com/
Tags: link, article, news, scraper
Requires at least: 3.0.1
Tested up to: 4.8
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a custom post type which allows you to post news articles on your site.


== Description ==

Simple plugin which adds a custom post type allowing you to post links to news articles and display them on your site. Development is still in progress but plugin is usable if you add the correct metabox calls to your theme's post loop.


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/news-articles` directory, or install the plugin through the WordPress plugins screen directly
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Add new news articles by creating a new 'Article' post and pasting the url into the 'Link' field. When you click publish the plugin will automatically attempt to fill in the missing fields by pinging the provided url.
4. You can display your posted news articles by modifying your site's theme to include an article post loop with the correct metaboxes.


== Frequently Asked Questions ==

= Does this plugin have widget capability? =

Not currently, this feature is planned for the future though.


== Screenshots ==

1. Once you install and active the plugin, a new Article content type will become available on the WordPress admin panel
2. Every time you publish a new article or update an old one, the plugin will automatically ping the provided link and attempt to fill in any blank fields. Occasionally this feature gets blocked by a site's ROBOTS.txt so information may have to be filled in manually


== Changelog ==

= 1.0 =
* Custom post type for posting Article links
* Articles automatically attempt to fill in blank fields on publish/update

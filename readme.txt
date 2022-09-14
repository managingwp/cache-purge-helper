# Cache Purge Helper 
Contributors: jordantrizz
Donate link: https://wpinfo.net/sponsor
Tags: cache,purge,litespeed,nginx
Requires at least: 5.8
Tested up to: 5.8
Stable tag: 0.1.4
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A helper plugin to purge cache via the LSCache and Nginx Helper plugins for popular WordPress plugins and themes.

## Description

This plugin will trigger a cache purge using the LSCache or Nginx Helper plugin when hooks are fired by popular plugins or themes.

* If using the LSCache plugin, Litespeed Enterprise or Openlightspeed is required to purge server cache.
* If using the Nginx Helper plugin, Nginx cache method FastCGI or Nginx Redi Cache is required to purge server cache.

The following themes and plugins hooks are used.

### WordPress Core Hooks
* upgrader_process_complete
* activated_plugin
* deactivated_plugin
* switch_theme

### Beaver Builder Plugin
* fl_builder_cache_cleared
* fl_builder_after_save_layout
* fl_builder_after_save_user_template
* upgrader_process_complete

### Elementor Plugin
* elementor/core/files/clear_cache
* update_option__elementor_global_css
* delete_option__elementor_global_css

### Autoptimizer Plugin
* delete_option__elementor_global_css

### Oxygen Theme
* wp_ajax_oxygen_vsb_cache_generated
* update_option__oxygen_vsb_universal_css_url
* update_option__oxygen_vsb_css_files_state

## Installation

Automatic Installation

1. Log in to your WordPress admin panel, navigate to the Plugins menu and click Add New.
2. In the search field type "Cache Purge Helper" and click Search Plugins. 
3. From the search results, pick "Cache Purge Helper" and click Install Now. Wordpress will ask you to confirm to complete the installation.

Manual Installation

1. Extract the zip file.
2. Upload them to `/wp-content/plugins/` directory on your WordPress installation.
3. Then activate the Plugin from Plugins page.

Enabling Debug Mode

Enable [WordPress debug](https://wordpress.org/support/article/debugging-in-wordpress/) and add `define('CPHP_DEBUG',true);` to your wp-config.php to see debug messages in your PHP error_log.

For any issues, open up a Github issue at https://github.com/managingwp/cache-purge-helper

## Frequently Asked Questions

### Why did you create this plugin?
There are a number of plugins and themes that change data in a WordPress instance which results in broken visuals and require a manual cache purge. This plugin makes sure that those instances will purge your sites cache.

### What other caching solutions do you support?
None. Submit a issue on Github https://github.com/jordantrizz/cache-purge-helper/issues

## Screenshots 

None

## Changelog

### 0.1.3
* Github actions to automate pushing to SVN

### 0.1.2
* Release to be sent to WordPress Plugin Directory

### 0.1.1
* Preparing to be added to the WordPress Plugin Directory

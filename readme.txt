# Cache Purge Helper 
Contributors: jordantrizz
Donate link: https://wpinfo.net/sponsor
Tags: cache,purge,litespeed,nginx
Requires at least: 5.8
Tested up to: 5.8
Stable tag: 0.1.1
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A helper plugin to purge cache via the LSCache and Nginx Helper plugins for popular WordPress plugin and themes.

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

## Frequently Asked Questions

### Why did you create this plugin?
There are a number of plugins and themes that change data in a WordPress instance which results in broken visuals and require a manual cache purge. This plugin makes sure that those instances will purge your sites cache.

### What other caching solutions do you support?
None. Submit a issue on Github https://github.com/jordantrizz/cache-purge-helper/issues

## Screenshots 

None

## Changelog

### 0.1.1
* Added to WordPress Plugin Directory

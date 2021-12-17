<?php

/**
 * Plugin Name:       Cache Purge Helper
 * Plugin URI:        https://wpinfo.net
 * Description:       Adding additional hooks to trigger nginx-helper or lscache plugin purges
 * Version:           0.1
 * Author:            Paul Stoute, Jordan Trask, Jeff Cleverly
 * Author URI:        https://wpinfo.net
 * Text Domain:       cache-purge-helper
 * Domain Path:       /languages
 * Requires at least: 3.0
 * Tested up to:      5.4
 *
 * @link              https://wpinfo.net
 * @since             0.1
 * @package           cache-purge-helper
 */

/* Purge Cache Function
*
* If both nginx-helper and litespeed-cache plugin exist, purges will happen for both.
* This is cover instances where nginx-helper is used for server cache but litespeed-cache
* is used for other functions, or there is a mis-configuration.
*
* A better idea would be to check what server is being used and warn that the wrong plugin
* is activated for purging server cache.
*/

function cache_purge_helper() {
  // Purge WordPress Cache
  wp_cache_flush();
  
  // If nginx-helper plugins is enabled, purge cache.
  if( is_plugin_active("nginx-helper") )
  {
    $nginx_purger->purge_all();
  }
  
  // If litespeed-cache plugins is enabled, purge cache.
  if( is_plugin_active("litespeed-cache") )
    do_action( 'litespeed_purge_all' );
  }

}

// Plugin Update Hooks
add_action( 'upgrader_process_complete', 'cache_purge_helper', 10, 0 ); // After plugins have been updated
add_action( 'activated_plugin', 'cache_purge_helper', 10, 0); // After a plugin has been activated
add_action( 'deactivated_plugin', 'cache_purge_helper', 10, 0); // After a plugin has been deactivated
add_action( 'switch_theme', 'cache_purge_helper', 10, 0); // After a theme has been changed

// Beaver Builder
if ( defined( 'FL_BUILDER_VERSION' ) ) {
  add_action( 'fl_builder_cache_cleared', 'cache_purge_helper', 10, 3 );
  add_action( 'fl_builder_after_save_layout', 'cache_purge_helper', 10, 3 );
  add_action( 'fl_builder_after_save_user_template', 'cache_purge_helper', 10, 3 );
  add_action( 'upgrader_process_complete', 'cache_purge_helper', 10, 3 );
}

// Elementor
if ( defined( 'ELEMENTOR_VERSION' ) ) {
  add_action( 'elementor/core/files/clear_cache', 'cache_purge_helper', 10, 3 ); 
  add_action( 'update_option__elementor_global_css', 'cache_purge_helper', 10, 3 );
  add_action( 'delete_option__elementor_global_css', 'cache_purge_helper', 10, 3 );
}

// AutoOptimizer
if ( defined( 'AUTOPTIMIZE_PLUGIN_DIR' ) ) {
  add_action( 'autoptimize_action_cachepurged','cache_purge_helper', 10, 3 ); // Need to document this.
}

// Oxygen
if ( defined( 'CT_VERSION' ) ) {
  add_action( 'wp_ajax_oxygen_vsb_cache_generated','cache_purge_helper', 99 );
  add_action( 'update_option__oxygen_vsb_universal_css_url','cache_purge_helper', 99 );
  add_action( 'update_option__oxygen_vsb_css_files_state','cache_purge_helper', 99 );
}

           

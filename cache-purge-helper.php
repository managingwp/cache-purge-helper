<?php

/**
 * Plugin Name:       Cache Purge Helper
 * Plugin URI:        https://wpinfo.net
 * Description:       Adding additional hooks to trigger nginx-helper or lscache plugin purges
 * Version:           0.1
 * Author:            Paul Stoute, Jordan Trask
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

//* Nginx Helper Enhancement
function nhpcau_upgrader_process_complete() {
  
  global $nginx_purger;

  if(isset($nginx_purger))
  {
    $nginx_purger->purge_all();
  }
  
}
// After plugins have been updated
add_action( 'upgrader_process_complete', 'nhpcau_upgrader_process_complete', 10, 0 );

// After a plugin has been activated
add_action( 'activated_plugin', 'nhpcau_upgrader_process_complete', 10, 0);

// After a plugin has been deactivated
add_action( 'deactivated_plugin', 'nhpcau_upgrader_process_complete', 10, 0);

// After a theme has been changed
add_action( 'switch_theme', 'nhpcau_upgrader_process_complete', 10, 0);

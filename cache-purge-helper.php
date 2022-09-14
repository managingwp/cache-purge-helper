<?php

/**
 * Plugin Name:       Cache Purge Helper
 * Plugin URI:        https://managingwp.io
 * Description:       Adding additional hooks to trigger nginx-helper or lscache plugin purges
 * Version:           0.1.4
 * Author:            Paul Stoute, Jordan Trask, Jeff Cleverley
 * Author URI:        https://github.com/jordantrizz/cache-purge-helper
 * Text Domain:       cache-purge-helper
 * Domain Path:       /languages
 * Requires at least: 3.0
 * Tested up to:      5.4
 *
 * @link              https://github.com/jordantrizz/cache-purge-helper
 * @since             0.1
 * @package           cache-purge-helper
 */

/** Purge Cache Function
 *
 * If both nginx-helper and litespeed-cache plugin exist, purges will happen for both.
 * This is cover instances where nginx-helper is used for server cache but litespeed-cache
 * is used for other functions, or there is a mis-configuration.
 *
 * A better idea would be to check what server is being used and warn that the wrong plugin
 * is activated for purging server cache.
 */

function cphp_purge() {
    // Purge WordPress Cache
    $called_action_hook = current_filter();
    cphp_write_log('cphp - initiated');
    cphp_write_log('cphp - running on'. $called_action_hook );
    cphp_write_log('cphp - flusing WordPress Cache first');
    wp_cache_flush();
  
    // If nginx-helper plugins is enabled, purge cache.
    cphp_write_log('cphp - checking for nginx-helper plugin');

    if ( is_plugin_active('nginx-helper/nginx-helper.php') ) {
        cphp_write_log('cphp - nginx-helper plugin installed, running $nginx_purger->purge_all();');
        global $nginx_purger;
        $nginx_purger->purge_all();
    } else {
      cphp_write_log('cphp - nginx-helper plugin not installed or detected');
    }
 
    // If litespeed-cache plugins is enabled, purge cache.
    cphp_write_log('cphp - checking for litespeed-cache plugin');

    if ( is_plugin_active('litespeed-cache/litespeed-cache.php') ) {
        cphp_write_log('cphp - litespeed-cache plugin installed, running do_action(\'litespeed_purge_all\');');
        do_action( 'litespeed_purge_all' );
    }  else {
        cphp_write_log('cphp - litespeed-cache plugin not installed or detected');
    }

    // End of cache_purge_helper()
    cphp_write_log('cphp - end of cache_purge_helper function');
}

/**
 * 
 * The rtCamp/nginx-helper plugin doesn't work with GridPane's FastCGI Cache.
 * This is suppose to help, but you should install https://github.com/JeffCleverley/NginxFastCGICachePurger
 * 
 */

function cphp_gridpane_purgeall() {

    $site = get_site_url();
    $find = [ 'http://', 'https://' ];
    $replace = '';
    $host = str_replace( $find, $replace, $site);

    if ( is_ssl() ) {
        
        $purgeurl = $site . '/purgeall' ;
        $curl = curl_init( $purgeurl );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PURGE" );
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_RESOLVE, array( $host . ":443:127.0.0.1" ));
        
        $response = curl_exec($curl);

        if ($response === false) {

            $response = curl_errno($curl) .': '. curl_error($curl);

        }
        
        curl_close($curl);

    } else {

        $curl = curl_init( "http://127.0.0.1/purgeall" );
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Host:' . $host ));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PURGE" );
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        
    }
    
    cphp_write_log("cph_gridpane_purge: response: $response");
}

/** 
 * Log to WordPress Debug Log Function
 *
 * Log to PHP error_log if WP_DEBUG and CPH_DEBUG are set!
 *
 */

function cphp_write_log ( $log )  {
    if ( WP_DEBUG === true && defined('CPHP_DEBUG')) {
        if ( is_array( $log ) || is_object( $log ) ) {
            error_log( print_r( $log, true ) );
        } else {
            error_log( $log );
        }
    }
}

/**************************************************/

/**
 * WordPress core hooks.
 */

cphp_write_log('cphp - Loading WordPress core hooks');
add_action( 'upgrader_process_complete', 'cphp_purge', 10, 0 ); // After a plugin, theme or core has been updated.
add_action( 'activated_plugin', 'cphp_purge', 10, 0); // After a plugin has been activated
add_action( 'deactivated_plugin', 'cphp_purge', 10, 0); // After a plugin has been deactivated
add_action( 'switch_theme', 'cphp_purge', 10, 0); // After a theme has been changed

/**
 * Page builder hooks.
 */

// Beaver Builder
if ( defined( 'FL_BUILDER_VERSION' ) ) {
    cphp_write_log('cphp - Beaver Builder Hooks enabled');
    add_action( 'fl_builder_cache_cleared', 'cphp_purge', 10, 3 );
    add_action( 'fl_builder_after_save_layout', 'cphp_purge', 10, 3 );
    add_action( 'fl_builder_after_save_user_template', 'cphp_purge', 10, 3 );
}

// Elementor
if ( defined( 'ELEMENTOR_VERSION' ) ) {
    cphp_write_log('cphp - Elementor hooks enabled');
    add_action( 'elementor/core/files/clear_cache', 'cphp_purge', 10, 3 ); 
    add_action( 'update_option__elementor_global_css', 'cphp_purge', 10, 3 );
    add_action( 'delete_option__elementor_global_css', 'cphp_purge', 10, 3 );
}

// Oxygen
if ( defined( 'CT_VERSION' ) ) {
    cphp_write_log('cphp - Oxygen hooks enabled');
    add_action( 'wp_ajax_oxygen_vsb_cache_generated','cphp_purge', 99 );
    add_action( 'update_option__oxygen_vsb_universal_css_url','cphp_purge', 99 );
    add_action( 'update_option__oxygen_vsb_css_files_state','cphp_purge', 99 );
}

/**
 * Optimization and caching plugin hooks.
 */

// Autoptimizer
if ( defined( 'AUTOPTIMIZE_PLUGIN_DIR' ) ) {
    cphp_write_log('cphp - Autoptimize hooks enabled');
    add_action( 'autoptimize_action_cachepurged','cphp_purge', 10, 3 ); // Need to document this.
}

// WP Optimize Hooks
if ( defined ('WPO_VERSION') ){
    cphp_write_log('cphp - WP Optimize hooks enabled');
    add_filter('wpo_purge_all_cache_on_update', '__return_true');
}
      

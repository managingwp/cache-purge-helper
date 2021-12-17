<?

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

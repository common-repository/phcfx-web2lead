<?php
/*
 * Plugin Name: Wordpress2Lead for PHC CRM FX
 * Description: Capture more leads and manage customer relationships more effectively with easy integration between WordPress and your PHC CRM FX installation.
 * Version: 1.1
 * Author: PHC Software, S.A.
 * Author URI: http://en.phc.pt
 */

// some generic definitions
define('PHCWEB2LEAD_PLUGIN', plugin_basename(__FILE__));
define('PHCWEB2LEAD_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('PHCWEB2LEAD_PLUGIN_NAME', basename(__FILE__, '.php'));

// load plugin main class
require_once(PHCWEB2LEAD_PLUGIN_DIR . 'class.PHCweb2lead.php' );

// make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

// start the plugin
PHCweb2lead::self();

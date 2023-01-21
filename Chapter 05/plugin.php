<?php
/**
 * Plugin Name: Plugin Bootstrap
 * Plugin URI:  http://example.com/
 * Description: An example of bootstrapping a plugin.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_action( 'plugins_loaded', 'pdev_plugin_bootstrap' );

function pdev_plugin_bootstrap() {

	require_once plugin_dir_path( __FILE__ ) . 'Setup.php';

	$setup = new \PDEV\Setup();

	$setup->boot();
}

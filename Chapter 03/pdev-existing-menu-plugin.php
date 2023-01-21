<?php
/*
Plugin Name: PDEV Existing Menu Example
Plugin URI: https://example.com/
Description: A complete and practical example of the WordPress Settings API
Version: 1.0
Author: WROX
Author URI: http://wrox.com
*/

add_action( 'admin_menu', 'pdev_create_submenu' );
             
function pdev_create_submenu() {

    //create a submenu under Settings
    add_options_page( 'PDEV Plugin Settings', 'PDEV Settings', 'manage_options',
        'pdev_plugin', 'pdev_plugin_option_page' );
             
}

//placerholder function for the options page
function pdev_plugin_option_page() {

}

?>
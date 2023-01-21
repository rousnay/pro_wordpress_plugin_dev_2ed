<?php
/*
Plugin Name: Multisite Switch Example Plugin
Plugin URI: https://example.com/wordpress-plugins/my-plugin
Description: A plugin to demonstrate Multisite site switching
Version: 1.0
Author: Brad Williams
Author URI: https://wrox.com
License: GPLv2
*/
             
add_action( 'admin_menu', 'pdev_multisite_switch_menu' );
             
function pdev_multisite_switch_menu() {
             
    //create custom top-level menu
    add_menu_page( 'Multisite Switch', 'Multisite Switch',
        'manage_options',
        'pdev-network-switch', 'pdev_multisite_switch_page' );
             
}
             
function pdev_multisite_switch_page() {
             
    if ( is_multisite() ) {
             
        //switch to blog ID 3
        switch_to_blog( 2 );
             
        //create a custom Loop
        $recent_posts = new WP_Query();
        $recent_posts->query( 'posts_per_page=5' );
             
        //start the custom Loop
        while ( $recent_posts->have_posts() ) :
            $recent_posts->the_post();
             
            //store the recent posts in a variable
            echo '<p><a href="' .get_permalink(). '">' .
                get_the_title() .'</a></p>';
             
        endwhile;
             
        //restore the current site
        restore_current_blog();
             
    }
             
}

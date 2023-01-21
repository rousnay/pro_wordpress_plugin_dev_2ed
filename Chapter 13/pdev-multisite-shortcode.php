<?php
/*
Plugin Name: Multisite Switch Shortcode Plugin
Plugin URI: https://example.com/wordpress-plugins/my-plugin
Description: A plugin for aggregating content using a shortcode
Version: 1.0
Author: Brad Williams
Author URI: https://wrox.com
License: GPLv2
*/
             
add_shortcode( 'network_posts', 'pdev_multisite_network_posts' );
             
function pdev_multisite_network_posts( $attr ) {
    extract( shortcode_atts( array(
            "site_id"    =>    '1',
            "num"        =>    '5'
            ), $attr ) );
             
    if ( is_multisite() ) {
             
        $return_posts = '';
             
        //switch to site set in the shortcode
        switch_to_blog( absint( $site_id ) );
             
        //create a custom Loop
        $recent_posts = new WP_Query();
        $recent_posts->query( 'posts_per_page=' .absint( $num ) );
             
        //start the custom Loop
        while ( $recent_posts->have_posts() ) :
            $recent_posts->the_post();
             
            //store the recent posts in a variable
            $return_posts .= '<p><a href="' .get_permalink().
                '">' .get_the_title() .'</a></p>';
             
        endwhile;
             
        //restore the current site
        restore_current_blog();
             
        //return the results to display
        return $return_posts;
             
    }
}

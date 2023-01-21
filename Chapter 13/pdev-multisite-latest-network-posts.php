<?php
/*
Plugin Name: Multisite Latest Network Posts Plugin
Plugin URI: https://example.com/wordpress-plugins/my-plugin
Description: Displays the latest posts from multiple sites
Version: 1.0
Author: Brad Williams
Author URI: https://wrox.com
License: GPLv2
*/
             
add_shortcode( 'latest_network_posts',
    'pdev_multisite_latest_network_posts' );
             
function pdev_multisite_latest_network_posts() {
             
    if ( is_multisite() ) {
             
        $return_posts = '';
             
        //get posts from current site
        $local_posts = get_posts( 'numberposts=5' );
             
        //switch to blog ID 3
        switch_to_blog( 3 );
             
        //get posts from another site
        $network_posts = get_posts( 'numberposts=5' );
             
        //restore the current site
        restore_current_blog();
             
        //merge the two arrays
        $posts = array_merge( $local_posts, $network_posts );
             
        //sort the post results by date
        usort( $posts, 'pdev_multisite_sort_posts_array' );
             
        foreach ( $posts as $post ) {
             
            //store latest posts in a variable
            $return_posts .= $post->post_title .' - posted on '
                .$post->post_date .'<br />';
             
        }
             
        //return the results to display
        return $return_posts;
             
    }
             
}
             
//sort the array by date
function pdev_multisite_sort_posts_array( $a, $b ) {
             
    //if dates are the same return 0
    if ($a->post_date == $b->post_date)
        return 0;
             
    //ternary operator to determine which date is newer
    return $a->post_date < $b->post_date ? 1 : -1;
             
}

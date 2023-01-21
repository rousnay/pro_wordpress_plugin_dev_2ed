<?php
/*
Plugin Name: Multisite Recent Posts Widget
Plugin URI:  https://example.com
Description: Retrieves the most recent posts in a Multisite network
Author: Brad Williams
Version: 1.0
Author URI: https://wrox.com
*/
             
//widgets_init action hook to execute custom function
add_action( 'widgets_init', 'pdev_multisite_register_widget' );
             
//register our widget
function pdev_multisite_register_widget() {
    register_widget( 'pdev_multisite_widget' );
}
             
//pdev_multisite_widget class
class PDEV_Multisite_Widget extends WP_Widget {

    //process our new widget
    function __construct() {
             
        $widget_ops = array( 'classname' => 'pdev_multisite_widget',
            'description' =>
                'Display recent posts from a network site.' );
        parent::__construct( 'pdev_multisite_widget_posts',
            'Multisite Recent Posts', $widget_ops );
             
    }
             
     //build our widget settings form
    function form( $instance ) {
        global $wpdb;
             
        $defaults = array( 'title' => 'Recent Posts',
            'disp_number' => '5' );
        $instance = wp_parse_args( (array) $instance, $defaults );
        $title = $instance['title'];
        $siteid = $instance['siteid'];
        $disp_number = $instance['disp_number'];
             
        //title textfield widget option
        echo '<p>Title: <input class="widefat" name="'
            .$this->get_field_name( 'title' )
            . '" type="text" value="' .esc_attr( $title )
            . '" /></p>';
             
        //get a list of all public site IDs
        $args = array (
            'public' => '1'
        );

        $sites = get_sites( $args );

        if ( is_array( $sites ) ) {

            echo '<p>';
            echo 'Site to display recent posts';
            echo '<select name="' .$this->get_field_name('siteid')
                .'" class="widefat" >';
             
            //loop through the blog IDs
            foreach ($sites as $site) {
             
                //display each site as an option
                echo '<option value="' .$site->blog_id. '" '
                    .selected( $site->blog_id, $siteid )
                    . '>' .get_blog_details( $site->blog_id )->blogname
                    . '</option>';
             
            }
             
            echo '</select>';
            echo '</p>';
        }
             
        //number to display textfield widget option
        echo '<p>Number to display: <input class="widefat" name="'
            .$this->get_field_name( 'disp_number' ). '" type="text"
            value="' .esc_attr( $disp_number ). '" /></p>';
             
    }
             
      //save the widget settings
    function update( $new_instance, $old_instance ) {
             
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['siteid'] = absint( $new_instance['siteid'] );
        $instance['disp_number'] =
            absint( $new_instance['disp_number'] );
             
        return $instance;
    }
             
     //display the widget
    function widget( $args, $instance ) {
        extract( $args );
             
        echo $before_widget;
             
        //load the widget options
        $title = apply_filters( 'widget_title', $instance['title'] );
        $siteid = empty( $instance['siteid'] ) ? 1 :
            $instance['siteid'];
         $disp_number = empty( $instance['disp_number'] ) ? 5 :
             $instance['disp_number'];
             
         //display the widget title
        if ( !empty( $title ) ) { echo $before_title . $title
            . $after_title; };
             
        echo '<ul>';
             
        //switch to site saved
        switch_to_blog( absint( $siteid ) );
             
        //create a custom loop
        $recent_posts = new WP_Query();
        $recent_posts->query( 'posts_per_page='
            .absint( $disp_number ) );
             
        //start the custom Loop
        while ( $recent_posts->have_posts() ) :
            $recent_posts->the_post();
             
            //display the recent post title with link
            echo '<li><a href="' .get_permalink(). '">'
                .get_the_title() .'</a></li>';
             
        endwhile;
             
        //restore the current site
        restore_current_blog();
             
        echo '</ul>';
        echo $after_widget;
             
    }
             
}

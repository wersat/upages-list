<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Favorites_Widget_Favorites
 *
 * @class Inventor_Widget_Favorites
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Favorites_Widget_Favorites extends WP_Widget {
    /**
     * Initialize widget
     *
     * @access public
     * @return void
     */
    function Inventor_Favorites_Widget_Favorites() {
        parent::__construct(
            'favorites_widget',
            __( 'Favorite listings', 'inventor-favorites' ),
            array(
                'description' => __( 'Favorite listings.', 'inventor-favorites' ),
            )
        );
    }

    /**
     * Frontend
     *
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    function widget( $args, $instance ) {
        Inventor_Favorites_Logic::loop_my_favorites();
        include Inventor_Template_Loader::locate( 'widgets/favorites', $plugin_dir = INVENTOR_FAVORITES_DIR );
        wp_reset_query();
    }

    /**
     * Update
     *
     * @access public
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    /**
     * Backend
     *
     * @access public
     * @param array $instance
     * @return void
     */
    function form( $instance ) {
        include Inventor_Template_Loader::locate( 'widgets/favorites-admin', $plugin_dir = INVENTOR_FAVORITES_DIR );
    }
}
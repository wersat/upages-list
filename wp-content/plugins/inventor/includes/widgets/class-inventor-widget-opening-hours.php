<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Widget_Opening_Hours
 *
 * @class Inventor_Widget_Opening_Hours
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Widget_Opening_Hours extends WP_Widget {
    /**
     * Initialize widget
     *
     * @access public
     * @return void
     */
    function Inventor_Widget_Opening_Hours() {
        parent::__construct(
            'opening_hours',
            __( 'Opening hours', 'inventor' ),
            array(
                'description' => __( 'Displays opening hours for current listing.', 'inventor' ),
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
        include Inventor_Template_Loader::locate( 'widgets/opening-hours' );

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
        include Inventor_Template_Loader::locate( 'widgets/opening-hours-admin' );
        include Inventor_Template_Loader::locate( 'widgets/advanced-options-admin' );
    }
}
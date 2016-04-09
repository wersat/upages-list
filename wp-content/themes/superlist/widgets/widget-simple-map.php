<?php
    /**
     * Widget definition file.
     */
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Superlist_Widget_Simple_Map.
     * @class  Superlist_Widget_Simple_Map
     * @author Pragmatic Mates
     */
    class Superlist_Widget_Simple_Map extends WP_Widget
    {
        /**
         * Initialize widget.
         */
        public function __construct()
        {
            parent::__construct('simple_map', __('Simple Map', 'superlist'), [
                'description' => __('Displays 1 place in the map.', 'superlist')
            ]);
        }

        /**
         * Backend.
         *
         * @param array $instance Current widget instance.
         */
        public function form($instance)
        {
            include THEME_WIDGETS_TPL_DIR . '/widget-simple-map-admin.php';
            if (class_exists('Inventor_Template_Loader')) {
                include Inventor_Template_Loader::locate('widgets/advanced-options-admin');
            }
        }

        /**
         * Update.
         *
         * @param array $new_instance New widget instance.
         * @param array $old_instance Old widget instance.
         *
         * @return array
         */
        public function update($new_instance, $old_instance)
        {
            return $new_instance;
        }

        /**
         * Frontend.
         *
         * @param array $args     Widget arguments.
         * @param array $instance Current widget instance.
         */
        public function widget($args, $instance)
        {
            include THEME_WIDGETS_TPL_DIR . '/widget-simple-map.php';
        }
    }

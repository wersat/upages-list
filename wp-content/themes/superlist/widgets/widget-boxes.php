<?php
    /**
     * Widget definition file.
     */
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Superlist_Widget_Boxes.
     * @class  Superlist_Widget_Boxes
     * @author Pragmatic Mates
     */
    class Superlist_Widget_Boxes extends WP_Widget
    {
        /**
         * Initialize widget.
         */
        public function __construct()
        {
            parent::__construct('boxes', __('Boxes', 'superlist'), [
                    'description' => __('Text boxes with icons.', 'superlist')
                ]);
        }

        /**
         * Backend.
         *
         * @param array $instance Current widget instance.
         */
        public function form($instance)
        {
            include WIDGETS_TPL_DIR . '/widget-boxes-admin.php';
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
            include WIDGETS_TPL_DIR . '/widget-boxes.php';
        }
    }

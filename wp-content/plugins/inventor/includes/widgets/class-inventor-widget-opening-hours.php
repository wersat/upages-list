<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Widget_Opening_Hours.
     * @class  Inventor_Widget_Opening_Hours
     * @author Pragmatic Mates
     */
    class Inventor_Widget_Opening_Hours extends WP_Widget
    {
        /**
         * Initialize widget.
         */
        public function __construct()
        {
            parent::__construct('opening_hours', __('Opening hours', 'inventor'), [
                'description' => __('Displays opening hours for current listing.', 'inventor'),
            ]);
        }

        /**
         * Backend.
         *
         * @param array $instance
         */
        public function form($instance)
        {
            include Inventor_Template_Loader::locate('widgets/opening-hours-admin');
            include Inventor_Template_Loader::locate('widgets/advanced-options-admin');
        }

        /**
         * Update.
         *
         * @param array $new_instance
         * @param array $old_instance
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
         * @param array $args
         * @param array $instance
         */
        public function widget($args, $instance)
        {
            include Inventor_Template_Loader::locate('widgets/opening-hours');
            wp_reset_query();
        }
    }

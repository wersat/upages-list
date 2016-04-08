<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Widget_Listing_Inquire.
     *
     * @class  Inventor_Widget_Listing_Inquire
     *
     * @author Pragmatic Mates
     */
    class Inventor_Widget_Listing_Inquire extends WP_Widget
    {
        /**
         * Initialize widget.
         */
        public function __construct()
        {
            parent::__construct('listing_inquire', __('Listing Inquire', 'inventor'), [
                    'description' => __('Listing inquire widget for sending inquire messages.', 'inventor'),
                ]);
        }

        /**
         * Backend.
         *
         * @param array $instance
         */
        public function form($instance)
        {
            include Inventor_Template_Loader::locate('widgets/listing-inquire-admin');
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
            include Inventor_Template_Loader::locate('widgets/listing-inquire');
        }
    }

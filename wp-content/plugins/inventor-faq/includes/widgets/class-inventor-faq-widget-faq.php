<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_FAQ_Widget_FAQ.
     * @class  Inventor_FAQ_Widget_FAQ
     * @author Pragmatic Mates
     */
    class Inventor_FAQ_Widget_FAQ extends WP_Widget
    {
        /**
         * Initialize widget.
         */
        public function __construct()
        {
            parent::__construct('faq', __('FAQ', 'inventor-faq'), [
                'description' => __('Displays FAQ.', 'inventor-faq'),
            ]);
        }

        /**
         * Backend.
         *
         * @param array $instance
         */
        public function form($instance)
        {
            include Inventor_Template_Loader::locate('widgets/faq-admin', INVENTOR_FAQ_DIR);
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
            query_posts([
                'post_type'      => 'faq',
                'posts_per_page' => -1,
            ]);
            include Inventor_Template_Loader::locate('widgets/faq', INVENTOR_FAQ_DIR);
            wp_reset_query();
        }
    }

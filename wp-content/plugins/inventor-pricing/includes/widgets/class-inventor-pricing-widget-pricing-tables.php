<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Pricing_Widget_Pricing_Tables.
     * @class  Inventor_Pricing_Widget_Pricing_Tables
     * @author Pragmatic Mates
     */
    class Inventor_Pricing_Widget_Pricing_Tables extends WP_Widget
    {
        /**
         * Initialize widget.
         */
        public function __construct()
        {
            parent::__construct('pricing', __('Pricing Tables', 'inventor-pricing'), [
                'description' => __('Displays pricing tables', 'inventor-pricing'),
            ]);
        }

        /**
         * Backend.
         *
         * @param array $instance
         */
        public function form($instance)
        {
            include Inventor_Template_Loader::locate('widgets/pricing-admin', INVENTOR_PRICING_DIR);
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
                'post_type'      => 'pricing_table',
                'posts_per_page' => -1,
            ]);
            include Inventor_Template_Loader::locate('widgets/pricing', INVENTOR_PRICING_DIR);
            wp_reset_query();
        }
    }

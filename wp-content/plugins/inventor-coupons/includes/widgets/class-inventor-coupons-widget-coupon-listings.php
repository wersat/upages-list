<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Coupons_Widget_Coupon_Listings.
     * @class  Inventor_Coupons_Widget_Coupon_Listings
     * @author Pragmatic Mates
     */
    class Inventor_Coupons_Widget_Coupon_Listings extends WP_Widget
    {
        /**
         * Initialize widget.
         */
        public function __construct()
        {
            parent::__construct('coupon_listings', __('Coupon Listing', 'inventor-coupons'), [
                'description' => __('Coupon listing.', 'inventor-coupons'),
            ]);
        }

        /**
         * Backend.
         *
         * @param array $instance
         */
        public function form($instance)
        {
            include Inventor_Template_Loader::locate('widgets/coupon-listings-admin', INVENTOR_COUPONS_DIR);
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
            $query = [
                'post_type'      => 'coupon',
                'posts_per_page' => ! empty($instance['count']) ? $instance['count'] : 3,
                'meta_query'     => Inventor_Coupons_Logic::get_condition(),
            ];
            query_posts($query);
            include Inventor_Template_Loader::locate('widgets/coupon-listings', INVENTOR_COUPONS_DIR);
            wp_reset_query();
        }
    }

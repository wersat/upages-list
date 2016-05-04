<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Coupons_Widget_Coupon_Detail.
     * @class  Inventor_Coupons_Widget_Coupon_Detail
     * @author Pragmatic Mates
     */
    class Inventor_Coupons_Widget_Coupon_Detail extends WP_Widget
    {
        /**
         * Initialize widget.
         */
        public function __construct()
        {
            parent::__construct('coupon_detail', __('Coupon Detail', 'inventor-coupons'), [
                'description' => __('Coupon Detail.', 'inventor-coupons'),
            ]);
        }

        /**
         * Backend.
         *
         * @param array $instance
         */
        public function form($instance)
        {
            include Inventor_Template_Loader::locate('widgets/coupon-detail-admin', INVENTOR_COUPONS_DIR);
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
            include Inventor_Template_Loader::locate('widgets/coupon-detail', INVENTOR_COUPONS_DIR);
        }
    }

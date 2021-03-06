<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Coupons_Logic.
     * @class  Inventor_Coupons_Logic
     * @author Pragmatic Mates
     */
    class Inventor_Coupons_Logic
    {
        /**
         * Initialize Coupons functionality.
         */
        public static function init()
        {
            add_action('pre_get_posts', [__CLASS__, 'archive']);
        }

        /**
         * Filter coupons on archive page.
         *
         * @param $query
         *
         * @return WP_Query|null
         */
        public static function archive($query)
        {
            if (is_post_type_archive(['coupon']) && $query->is_main_query() && ! is_admin()) {
                $coupon_query = self::get_condition();
                $meta_query   = $query->get('meta_query');
                $query->set('meta_query', array_merge($meta_query, $coupon_query));
            }
        }

        /**
         * Get coupons filter condition.
         * @return array
         */
        public static function get_condition()
        {
            return [
                'relation' => 'AND',
                [
                    'relation' => 'OR',
                    [
                        'key'     => INVENTOR_LISTING_PREFIX . 'datetime_from',
                        'value'   => time(),
                        'compare' => '<=',
                        'type'    => 'NUMERIC',
                    ],
                    [
                        'key'     => INVENTOR_LISTING_PREFIX . 'datetime_from',
                        'compare' => 'NOT EXISTS',
                    ],
                ],
                [
                    'relation' => 'OR',
                    [
                        'key'     => INVENTOR_LISTING_PREFIX . 'datetime_to',
                        'value'   => time(),
                        'compare' => '>=',
                        'type'    => 'NUMERIC',
                    ],
                    [
                        'key'     => INVENTOR_LISTING_PREFIX . 'datetime_to',
                        'compare' => 'NOT EXISTS',
                    ],
                ],
            ];
        }

        /**
         * Gets user code.
         *
         * @param $coupon_id
         * @param $user_id
         */
        public static function get_user_code($coupon_id, $user_id)
        {
            $codes = get_post_meta($coupon_id, INVENTOR_COUPON_PREFIX . 'codes', true);
            if (is_array($codes)) {
                foreach ($codes as $code) {
                    if ( ! empty($code[INVENTOR_COUPON_PREFIX . 'user_id']) && $code[INVENTOR_COUPON_PREFIX . 'user_id'] == $user_id) {
                        return $code[INVENTOR_COUPON_PREFIX . 'code_generated'];
                    }
                }
            }

            return;
        }
    }

    Inventor_Coupons_Logic::init();

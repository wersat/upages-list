<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Coupons_Post_Type_Coupon.
     * @class  Inventor_Coupons_Post_Type_Coupon
     * @author Pragmatic Mates
     */
    class Inventor_Coupons_Post_Type_Coupon
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition'], 11);
            add_action('cmb2_init', [__CLASS__, 'fields']);
        }

        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name'               => __('Coupons', 'inventor-coupons'),
                'singular_name'      => __('Coupon', 'inventor-coupons'),
                'add_new'            => __('Add New Coupon', 'inventor-coupons'),
                'add_new_item'       => __('Add New Coupon', 'inventor-coupons'),
                'edit_item'          => __('Edit Coupon', 'inventor-coupons'),
                'new_item'           => __('New Coupon', 'inventor-coupons'),
                'all_items'          => __('Coupons', 'inventor-coupons'),
                'view_item'          => __('View Coupon', 'inventor-coupons'),
                'search_items'       => __('Search Coupon', 'inventor-coupons'),
                'not_found'          => __('No Coupons found', 'inventor-coupons'),
                'not_found_in_trash' => __('No Coupons Found in Trash', 'inventor-coupons'),
                'parent_item_colon'  => '',
                'menu_name'          => __('Coupons', 'inventor-coupons'),
            ];
            register_post_type('coupon', [
                'labels'       => $labels,
                'show_in_menu' => 'listings',
                'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
                'public'       => true,
                'has_archive'  => true,
                'rewrite'      => ['slug' => _x('coupons', 'URL slug', 'inventor-coupons')],
                'show_ui'      => true,
                'categories'   => [],
            ]);
        }

        /**
         * Defines custom fields.
         * @return array
         */
        public static function fields()
        {
            if ( ! is_admin()) {
                Inventor_Post_Types::add_metabox('coupon', ['general']);
            }
            Inventor_Post_Types::add_metabox('coupon', [
                'datetime_interval',
                'Inventor_Coupons_Metaboxes::details',
                'Inventor_Coupons_Metaboxes::codes',
                'gallery',
                'banner',
                'contact',
                'faq',
                'flags',
                'location',
                'listing_category'
            ]);
        }
    }

    Inventor_Coupons_Post_Type_Coupon::init();

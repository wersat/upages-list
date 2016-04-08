<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Post_Type_Travel.
     *
     * @class  Inventor_Post_Type_Travel
     *
     * @author Pragmatic Mates
     */
    class Inventor_Post_Type_Travel
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            add_action('cmb2_init', [__CLASS__, 'fields']);
            add_filter('inventor_shop_allowed_listing_post_types', [__CLASS__, 'allowed_purchasing']);
            add_filter('inventor_claims_allowed_listing_post_types', [__CLASS__, 'allowed_claiming']);
        }

        /**
         * Defines if post type can be claimed.
         *
         * @param array $post_types
         *
         * @return array
         */
        public static function allowed_claiming($post_types)
        {
            $post_types[] = 'travel';

            return $post_types;
        }

        /**
         * Defines if post type can be purchased.
         *
         * @param array $post_types
         *
         * @return array
         */
        public static function allowed_purchasing($post_types)
        {
            $post_types[] = 'travel';

            return $post_types;
        }

        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name' => __('Travels', 'inventor'),
                'singular_name' => __('Travel', 'inventor'),
                'add_new' => __('Add New Travel', 'inventor'),
                'add_new_item' => __('Add New Travel', 'inventor'),
                'edit_item' => __('Edit Travel', 'inventor'),
                'new_item' => __('New Travel', 'inventor'),
                'all_items' => __('Travels', 'inventor'),
                'view_item' => __('View Travel', 'inventor'),
                'search_items' => __('Search Travel', 'inventor'),
                'not_found' => __('No Travels found', 'inventor'),
                'not_found_in_trash' => __('No Travels Found in Trash', 'inventor'),
                'parent_item_colon' => '',
                'menu_name' => __('Travels', 'inventor'),
            ];
            register_post_type('travel', [
                    'labels' => $labels,
                    'show_in_menu' => 'listings',
                    'supports' => ['title', 'editor', 'thumbnail', 'comments', 'author'],
                    'has_archive' => true,
                    'rewrite' => ['slug' => _x('travels', 'URL slug', 'inventor')],
                    'public' => true,
                    'show_ui' => true,
                    'categories' => [],
                ]);
        }

        /**
         * Defines custom fields.
         *
         * @return array
         */
        public static function fields()
        {
            Inventor_Post_Types::add_metabox('travel', ['general']);
            $cmb = new_cmb2_box([
                'id' => INVENTOR_LISTING_PREFIX.'travel_details',
                'title' => __('Details', 'inventor'),
                'object_types' => ['travel'],
                'context' => 'normal',
                'priority' => 'high',
            ]);
            $cmb->add_field([
                'name' => __('Travel activities', 'inventor'),
                'id' => INVENTOR_LISTING_PREFIX.'travel_activity',
                'type' => 'taxonomy_multicheck_hierarchy',
                'taxonomy' => 'travel_activities',
            ]);
            Inventor_Post_Types::add_metabox('travel', [
                'date_interval',
                'gallery',
                'banner',
                'video',
                'location',
                'date_interval',
                'price',
                'contact',
                'social',
                'flags',
                'listing_category',
            ]);
        }
    }

    Inventor_Post_Type_Travel::init();

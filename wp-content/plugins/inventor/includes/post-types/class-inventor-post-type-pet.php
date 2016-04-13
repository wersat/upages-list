<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Post_Type_Pet.
     * @class  Inventor_Post_Type_Pet
     * @author Pragmatic Mates
     */
    class Inventor_Post_Type_Pet
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
            $post_types[] = 'pet';

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
            $post_types[] = 'pet';

            return $post_types;
        }

        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name'               => __('Pets', 'inventor'),
                'singular_name'      => __('Pet', 'inventor'),
                'add_new'            => __('Add New Pet', 'inventor'),
                'add_new_item'       => __('Add New Pet', 'inventor'),
                'edit_item'          => __('Edit Pet', 'inventor'),
                'new_item'           => __('New Pet', 'inventor'),
                'all_items'          => __('Pets', 'inventor'),
                'view_item'          => __('View Pet', 'inventor'),
                'search_items'       => __('Search Pet', 'inventor'),
                'not_found'          => __('No Pets found', 'inventor'),
                'not_found_in_trash' => __('No Pets Found in Trash', 'inventor'),
                'parent_item_colon'  => '',
                'menu_name'          => __('Pets', 'inventor'),
            ];
            register_post_type('pet', [
                'labels'       => $labels,
                'show_in_menu' => 'listings',
                'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
                'has_archive'  => true,
                'rewrite'      => ['slug' => _x('pets', 'URL slug', 'inventor')],
                'public'       => true,
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
            Inventor_Post_Types::add_metabox('pet', ['general']);
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . 'pet_details',
                'title'        => __('Details', 'inventor'),
                'object_types' => ['pet'],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $cmb->add_field([
                'name'     => __('Animal', 'inventor'),
                'id'       => INVENTOR_LISTING_PREFIX . 'pet_animal',
                'type'     => 'taxonomy_select',
                'taxonomy' => 'pet_animals',
            ]);
            Inventor_Post_Types::add_metabox('pet',
                ['color', 'gallery', 'video', 'location', 'price', 'contact', 'social', 'flags', 'listing_category']);
        }
    }

    Inventor_Post_Type_Pet::init();

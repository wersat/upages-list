<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Post_Type_Dating.
     *
     * @class  Inventor_Post_Type_Dating
     *
     * @author Pragmatic Mates
     */
    class Inventor_Post_Type_Dating
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            add_action('cmb2_init', [__CLASS__, 'fields']);
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
            $post_types[] = 'dating';

            return $post_types;
        }

        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name' => __('Datings', 'inventor'),
                'singular_name' => __('Dating', 'inventor'),
                'add_new' => __('Add New Dating', 'inventor'),
                'add_new_item' => __('Add New Dating', 'inventor'),
                'edit_item' => __('Edit Dating', 'inventor'),
                'new_item' => __('New Dating', 'inventor'),
                'all_items' => __('Datings', 'inventor'),
                'view_item' => __('View Dating', 'inventor'),
                'search_items' => __('Search Dating', 'inventor'),
                'not_found' => __('No Datings found', 'inventor'),
                'not_found_in_trash' => __('No Datings Found in Trash', 'inventor'),
                'parent_item_colon' => '',
                'menu_name' => __('Datings', 'inventor'),
            ];
            register_post_type('dating', [
                    'labels' => $labels,
                    'show_in_menu' => 'listings',
                    'supports' => ['title', 'editor', 'thumbnail', 'comments', 'author'],
                    'has_archive' => true,
                    'rewrite' => ['slug' => _x('datings', 'URL slug', 'inventor')],
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
            Inventor_Post_Types::add_metabox('dating', ['general']);
            $cmb = new_cmb2_box([
                'id' => INVENTOR_LISTING_PREFIX.'dating_details',
                'title' => __('Details', 'inventor'),
                'object_types' => ['dating'],
                'context' => 'normal',
                'priority' => 'high',
            ]);
            $cmb->add_field([
                'name' => __('Dating groups', 'inventor'),
                'id' => INVENTOR_LISTING_PREFIX.'dating_group',
                'type' => 'taxonomy_multicheck_hierarchy',
                'taxonomy' => 'dating_groups',
            ]);
            $cmb->add_field([
                'name' => __('Gender', 'inventor'),
                'id' => INVENTOR_LISTING_PREFIX.'dating_gender',
                'type' => 'radio_inline',
                'options' => [
                    'MALE' => __('Male', 'inventor'),
                    'FEMALE' => __('Female', 'inventor'),
                ],
            ]);
            $cmb->add_field([
                'name' => __('Age', 'inventor'),
                'id' => INVENTOR_LISTING_PREFIX.'dating_age',
                'type' => 'text',
                'attributes' => [
                    'type' => 'number',
                    'pattern' => '\d*',
                ],
            ]);
            $cmb->add_field([
                'name' => __('Weight', 'inventor'),
                'id' => INVENTOR_LISTING_PREFIX.'weight',
                'type' => 'text',
                'attributes' => [
                    'type' => 'number',
                    'pattern' => '\d*',
                ],
            ]);
            $cmb->add_field([
                'name' => __('Status', 'inventor'),
                'id' => INVENTOR_LISTING_PREFIX.'dating_status',
                'type' => 'taxonomy_radio',
                'taxonomy' => 'dating_statuses',
            ]);
            $cmb->add_field([
                'name' => __('Eye color', 'inventor'),
                'id' => INVENTOR_LISTING_PREFIX.'dating_eye_color',
                'type' => 'taxonomy_radio',
                'taxonomy' => 'colors',
            ]);
            $cmb->add_field([
                'name' => __('Interests', 'inventor'),
                'id' => INVENTOR_LISTING_PREFIX.'dating_interest',
                'type' => 'taxonomy_multicheck_hierarchy',
                'taxonomy' => 'dating_interests',
            ]);
            Inventor_Post_Types::add_metabox('dating',
                ['gallery', 'banner', 'video', 'contact', 'social', 'flags', 'location', 'listing_category']);
        }
    }

    Inventor_Post_Type_Dating::init();

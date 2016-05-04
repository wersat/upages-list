<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Post_Type_Business.
     *
     * @class  Inventor_Post_Type_Business
     * @author Pragmatic Mates
     */
class Inventor_Post_Type_Business
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
        $post_types[] = 'business';

        return $post_types;
    }

    /**
         * Custom post type definition.
         */
    public static function definition()
    {
        $labels = [
            'name'               => __('Businesses', 'inventor'),
            'singular_name'      => __('Business', 'inventor'),
            'add_new'            => __('Add New Business', 'inventor'),
            'add_new_item'       => __('Add New Business', 'inventor'),
            'edit_item'          => __('Edit Business', 'inventor'),
            'new_item'           => __('New Business', 'inventor'),
            'all_items'          => __('Businesses', 'inventor'),
            'view_item'          => __('View Business', 'inventor'),
            'search_items'       => __('Search Business', 'inventor'),
            'not_found'          => __('No Businesses found', 'inventor'),
            'not_found_in_trash' => __('No Businesses Found in Trash', 'inventor'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Businesses', 'inventor'),
        ];
        register_post_type(
            'business', [
            'labels'       => $labels,
            'show_in_menu' => 'listings',
            'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
            'has_archive'  => true,
            'rewrite'      => ['slug' => _x('businesses', 'URL slug', 'inventor')],
            'public'       => true,
            'show_ui'      => true,
            'categories'   => [],
            ]
        );
    }

    /**
         * Defines custom fields.
     *
         * @return array
         */
    public static function fields()
    {
        Inventor_Post_Types::add_metabox(
            'business', [
            'general',
            'banner',
            'gallery',
            'video',
            'opening_hours',
            'contact',
            'social',
            'flags',
            'location',
            'faq',
            'branding',
            'listing_category',
            ]
        );
    }
}

    Inventor_Post_Type_Business::init();

<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Post_Type_Education.
     *
     * @class  Inventor_Post_Type_Education
     * @author Pragmatic Mates
     */
class Inventor_Post_Type_Education
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
        $post_types[] = 'education';

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
        $post_types[] = 'education';

        return $post_types;
    }

    /**
         * Custom post type definition.
         */
    public static function definition()
    {
        $labels = [
            'name'               => __('Educations', 'inventor'),
            'singular_name'      => __('Education', 'inventor'),
            'add_new'            => __('Add New Education', 'inventor'),
            'add_new_item'       => __('Add New Education', 'inventor'),
            'edit_item'          => __('Edit Education', 'inventor'),
            'new_item'           => __('New Education', 'inventor'),
            'all_items'          => __('Educations', 'inventor'),
            'view_item'          => __('View Education', 'inventor'),
            'search_items'       => __('Search Education', 'inventor'),
            'not_found'          => __('No Educations found', 'inventor'),
            'not_found_in_trash' => __('No Educations Found in Trash', 'inventor'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Educations', 'inventor'),
        ];
        register_post_type(
            'education', [
            'labels'       => $labels,
            'show_in_menu' => 'listings',
            'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
            'has_archive'  => true,
            'rewrite'      => ['slug' => _x('educations', 'URL slug', 'inventor')],
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
        Inventor_Post_Types::add_metabox('education', ['general']);
        $cmb = new_cmb2_box(
            [
            'id'           => INVENTOR_LISTING_PREFIX . 'education_details',
            'title'        => __('Details', 'inventor'),
            'object_types' => ['education'],
            'context'      => 'normal',
            'priority'     => 'high',
            ]
        );
        $cmb->add_field(
            [
            'name'     => __('Education subject', 'inventor'),
            'id'       => INVENTOR_LISTING_PREFIX . 'education_subject',
            'type'     => 'taxonomy_select',
            'taxonomy' => 'education_subjects',
            ]
        );
        $cmb->add_field(
            [
            'name'     => __('Education level', 'inventor'),
            'id'       => INVENTOR_LISTING_PREFIX . 'education_level',
            'type'     => 'taxonomy_radio_inline',
            'taxonomy' => 'education_levels',
            ]
        );
        $cmb->add_field(
            [
            'name' => __('Lector', 'inventor'),
            'id'   => INVENTOR_LISTING_PREFIX . 'education_lector',
            'type' => 'text',
            ]
        );
        Inventor_Post_Types::add_metabox(
            'education', [
            'date_and_time_interval',
            'gallery',
            'banner',
            'video',
            'contact',
            'social',
            'price',
            'flags',
            'location',
            'listing_category',
            ]
        );
    }
}

    Inventor_Post_Type_Education::init();

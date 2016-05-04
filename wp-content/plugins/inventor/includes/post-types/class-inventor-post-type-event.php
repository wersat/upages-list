<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Post_Type_Event.
     *
     * @class  Inventor_Post_Type_Event
     * @author Pragmatic Mates
     */
class Inventor_Post_Type_Event
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
        $post_types[] = 'event';

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
        $post_types[] = 'event';

        return $post_types;
    }

    /**
         * Custom post type definition.
         */
    public static function definition()
    {
        $labels = [
            'name'               => __('Events', 'inventor'),
            'singular_name'      => __('Event', 'inventor'),
            'add_new'            => __('Add New Event', 'inventor'),
            'add_new_item'       => __('Add New Event', 'inventor'),
            'edit_item'          => __('Edit Event', 'inventor'),
            'new_item'           => __('New Event', 'inventor'),
            'all_items'          => __('Events', 'inventor'),
            'view_item'          => __('View Event', 'inventor'),
            'search_items'       => __('Search Events', 'inventor'),
            'not_found'          => __('No Events found', 'inventor'),
            'not_found_in_trash' => __('No Events Found in Trash', 'inventor'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Cars', 'inventor'),
        ];
        register_post_type(
            'event', [
            'labels'       => $labels,
            'show_in_menu' => 'listings',
            'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
            'has_archive'  => true,
            'rewrite'      => ['slug' => _x('events', 'URL slug', 'inventor')],
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
        Inventor_Post_Types::add_metabox('event', ['general']);
        $cmb = new_cmb2_box(
            [
            'id'           => INVENTOR_LISTING_PREFIX . 'event_details',
            'title'        => __('Details', 'inventor'),
            'object_types' => ['event'],
            'context'      => 'normal',
            'priority'     => 'high',
            ]
        );
        $cmb->add_field(
            [
            'name'     => __('Event type', 'inventor'),
            'id'       => INVENTOR_LISTING_PREFIX . 'event_type',
            'type'     => 'taxonomy_select',
            'taxonomy' => 'event_types',
            ]
        );
        Inventor_Post_Types::add_metabox(
            'event', [
            'date_and_time_interval',
            'gallery',
            'banner',
            'contact',
            'social',
            'video',
            'price',
            'flags',
            'location',
            'listing_category',
            ]
        );
    }
}

    Inventor_Post_Type_Event::init();

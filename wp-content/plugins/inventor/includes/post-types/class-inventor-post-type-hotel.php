<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Post_Type_Hotel.
     *
     * @class  Inventor_Post_Type_Hotel
     * @author Pragmatic Mates
     */
class Inventor_Post_Type_Hotel
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
        $post_types[] = 'hotel';

        return $post_types;
    }

    /**
         * Custom post type definition.
         */
    public static function definition()
    {
        $labels = [
            'name'               => __('Hotels', 'inventor'),
            'singular_name'      => __('Hotel', 'inventor'),
            'add_new'            => __('Add New Hotel', 'inventor'),
            'add_new_item'       => __('Add New Hotel', 'inventor'),
            'edit_item'          => __('Edit Hotel', 'inventor'),
            'new_item'           => __('New Hotel', 'inventor'),
            'all_items'          => __('Hotels', 'inventor'),
            'view_item'          => __('View Hotel', 'inventor'),
            'search_items'       => __('Search Hotel', 'inventor'),
            'not_found'          => __('No Hotels found', 'inventor'),
            'not_found_in_trash' => __('No Hotels Found in Trash', 'inventor'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Hotels', 'inventor'),
        ];
        register_post_type(
            'hotel', [
            'labels'       => $labels,
            'show_in_menu' => 'listings',
            'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
            'has_archive'  => true,
            'rewrite'      => ['slug' => _x('hotels', 'URL slug', 'inventor')],
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
        Inventor_Post_Types::add_metabox('hotel', ['general']);
        $cmb = new_cmb2_box(
            [
            'id'           => INVENTOR_LISTING_PREFIX . 'hotel_details',
            'title'        => __('Details', 'inventor'),
            'object_types' => ['hotel'],
            'context'      => 'normal',
            'priority'     => 'high',
            ]
        );
        $cmb->add_field(
            [
            'name'     => __('Hotel class', 'inventor'),
            'id'       => INVENTOR_LISTING_PREFIX . 'hotel_class',
            'type'     => 'taxonomy_radio',
            'taxonomy' => 'hotel_classes',
            ]
        );
        $cmb->add_field(
            [
            'name'       => __('Rooms', 'inventor'),
            'id'         => INVENTOR_LISTING_PREFIX . 'hotel_rooms',
            'type'       => 'text_small',
            'attributes' => [
                'type'    => 'number',
                'pattern' => '\d*',
            ],
            ]
        );
        Inventor_Post_Types::add_metabox(
            'hotel',
            ['gallery', 'banner', 'video', 'price', 'flags', 'location', 'contact', 'social', 'listing_category']
        );
    }
}

    Inventor_Post_Type_Hotel::init();

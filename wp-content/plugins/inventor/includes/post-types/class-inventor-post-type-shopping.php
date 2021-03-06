<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Post_Type_Shopping.
     *
     * @class  Inventor_Post_Type_Shopping
     * @author Pragmatic Mates
     */
class Inventor_Post_Type_Shopping
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
        $post_types[] = 'shopping';

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
        $post_types[] = 'shopping';

        return $post_types;
    }

    /**
         * Custom post type definition.
         */
    public static function definition()
    {
        $labels = [
            'name'               => __('Shoppings', 'inventor'),
            'singular_name'      => __('Shopping', 'inventor'),
            'add_new'            => __('Add New Shopping', 'inventor'),
            'add_new_item'       => __('Add New Shopping', 'inventor'),
            'edit_item'          => __('Edit Shopping', 'inventor'),
            'new_item'           => __('New Shopping', 'inventor'),
            'all_items'          => __('Shoppings', 'inventor'),
            'view_item'          => __('View Shopping', 'inventor'),
            'search_items'       => __('Search Shopping', 'inventor'),
            'not_found'          => __('No Shoppings found', 'inventor'),
            'not_found_in_trash' => __('No Shoppings Found in Trash', 'inventor'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Shoppings', 'inventor'),
        ];
        register_post_type(
            'shopping', [
            'labels'       => $labels,
            'show_in_menu' => 'listings',
            'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
            'has_archive'  => true,
            'rewrite'      => ['slug' => _x('shoppings', 'URL slug', 'inventor')],
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
        Inventor_Post_Types::add_metabox('shopping', ['general']);
        $cmb = new_cmb2_box(
            [
            'id'           => INVENTOR_LISTING_PREFIX . 'shopping_details',
            'title'        => __('Details', 'inventor'),
            'object_types' => ['shopping'],
            'context'      => 'normal',
            'priority'     => 'high',
            ]
        );
        $cmb->add_field(
            [
            'name'     => __('Shopping category', 'inventor'),
            'id'       => INVENTOR_LISTING_PREFIX . 'shopping_category',
            'type'     => 'taxonomy_select',
            'taxonomy' => 'shopping_categories',
            ]
        );
        $cmb->add_field(
            [
            'name'     => __('Color', 'inventor'),
            'id'       => INVENTOR_LISTING_PREFIX . 'color',
            'type'     => 'taxonomy_multicheck_hierarchy',
            'taxonomy' => 'colors',
            ]
        );
        $cmb->add_field(
            [
            'name'        => __('Size', 'inventor'),
            'id'          => INVENTOR_LISTING_PREFIX . 'size',
            'type'        => 'text_small',
            'description' => __('For example M, 10cm, 47 ...'),
            ]
        );
        $cmb->add_field(
            [
            'name'       => __('Weight', 'inventor'),
            'id'         => INVENTOR_LISTING_PREFIX . 'weight',
            'type'       => 'text_small',
            'attributes' => [
                'type'    => 'number',
                'pattern' => '\d*',
            ],
            ]
        );
        Inventor_Post_Types::add_metabox(
            'shopping',
            ['gallery', 'video', 'price', 'location', 'flags', 'contact', 'social', 'listing_category']
        );
    }
}

    Inventor_Post_Type_Shopping::init();

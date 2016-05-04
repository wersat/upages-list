<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Taxonomy_Car_Transmissions.
     *
     * @class  Inventor_Taxonomy_Car_Transmissions
     * @author Pragmatic Mates
     */
class Inventor_Taxonomy_Car_Transmissions
{
    /**
         * Initialize taxonomy.
         */
    public static function init()
    {
        add_action('init', [__CLASS__, 'definition']);
        add_action('parent_file', [__CLASS__, 'menu']);
    }

    /**
         * Widget definition.
         */
    public static function definition()
    {
        $labels = [
            'name'              => __('Car Transmissions', 'inventor'),
            'singular_name'     => __('Car Transmission', 'inventor'),
            'search_items'      => __('Search Car Transmission', 'inventor'),
            'all_items'         => __('All Car Transmissions', 'inventor'),
            'parent_item'       => __('Parent Car Transmission', 'inventor'),
            'parent_item_colon' => __('Parent Car Transmission:', 'inventor'),
            'edit_item'         => __('Edit Car Transmission', 'inventor'),
            'update_item'       => __('Update Car Transmission', 'inventor'),
            'add_new_item'      => __('Add New Car Transmission', 'inventor'),
            'new_item_name'     => __('New Car Transmission', 'inventor'),
            'menu_name'         => __('Car Transmissions', 'inventor'),
            'not_found'         => __('No car transmissions found.', 'inventor'),
        ];
        register_taxonomy(
            'car_transmissions', ['car'], [
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'car-transmission',
            'rewrite'           => [
                'slug'         => _x('car-transmission', 'URL slug', 'inventor'),
                'hierarchical' => true,
            ],
            'public'            => true,
            'show_ui'           => true,
            'show_in_menu'      => 'lexicon',
            'show_in_nav_menus' => true,
            'meta_box_cb'       => false,
            'show_admin_column' => true,
            ]
        );
    }

    /**
         * Set active menu for taxonomy car transmission.
     *
         * @return string
         */
    public static function menu($parent_file)
    {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;
        if ('car_transmissions' === $taxonomy) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

    Inventor_Taxonomy_Car_Transmissions::init();

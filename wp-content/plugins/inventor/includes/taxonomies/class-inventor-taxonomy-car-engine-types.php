<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Taxonomy_Car_Engine_Types.
     *
     * @class  Inventor_Taxonomy_Car_Engine_Types
     * @author Pragmatic Mates
     */
class Inventor_Taxonomy_Car_Engine_Types
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
            'name'              => __('Car Engine Types', 'inventor'),
            'singular_name'     => __('Car Engine Type', 'inventor'),
            'search_items'      => __('Search Car Engine Type', 'inventor'),
            'all_items'         => __('All Car Engine Types', 'inventor'),
            'parent_item'       => __('Parent Car Engine Type', 'inventor'),
            'parent_item_colon' => __('Parent Car Engine Type:', 'inventor'),
            'edit_item'         => __('Edit Car Engine Type', 'inventor'),
            'update_item'       => __('Update Car Engine Type', 'inventor'),
            'add_new_item'      => __('Add New Car Engine Type', 'inventor'),
            'new_item_name'     => __('New Car Engine Type', 'inventor'),
            'menu_name'         => __('Car Engine Types', 'inventor'),
            'not_found'         => __('No car engine types found.', 'inventor'),
        ];
        register_taxonomy(
            'car_engine_types', ['car'], [
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'car-engine-type',
            'rewrite'           => [
                'slug'         => _x('car-engine-type', 'URL slug', 'inventor'),
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
         * Set active menu for taxonomy car engine types.
     *
         * @return string
         */
    public static function menu($parent_file)
    {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;
        if ('car_engine_types' === $taxonomy) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

    Inventor_Taxonomy_Car_Engine_Types::init();

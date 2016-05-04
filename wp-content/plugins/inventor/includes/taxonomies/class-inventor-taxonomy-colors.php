<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Taxonomy_Colors.
     *
     * @class  Inventor_Taxonomy_Colors
     * @author Pragmatic Mates
     */
class Inventor_Taxonomy_Colors
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
            'name'              => __('Colors', 'inventor'),
            'singular_name'     => __('Color', 'inventor'),
            'search_items'      => __('Search Color', 'inventor'),
            'all_items'         => __('All Colors', 'inventor'),
            'parent_item'       => __('Parent Color', 'inventor'),
            'parent_item_colon' => __('Parent Color:', 'inventor'),
            'edit_item'         => __('Edit Color', 'inventor'),
            'update_item'       => __('Update Color', 'inventor'),
            'add_new_item'      => __('Add New Color', 'inventor'),
            'new_item_name'     => __('New Color', 'inventor'),
            'menu_name'         => __('Colors', 'inventor'),
            'not_found'         => __('No colors found.', 'inventor'),
        ];
        register_taxonomy(
            'colors', Inventor_Post_Types::get_listing_post_types(), [
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'color',
            'rewrite'           => ['slug' => _x('color', 'URL slug', 'inventor'), 'hierarchical' => true],
            'public'            => true,
            'show_ui'           => true,
            'show_in_menu'      => false,
            'show_in_nav_menus' => true,
            'meta_box_cb'       => false,
            'show_admin_column' => false,
            ]
        );
    }

    /**
         * Set active menu for taxonomy color.
     *
         * @return string
         */
    public static function menu($parent_file)
    {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;
        if ('colors' === $taxonomy) {
            return 'inventor';
        }

        return $parent_file;
    }
}

    Inventor_Taxonomy_Colors::init();

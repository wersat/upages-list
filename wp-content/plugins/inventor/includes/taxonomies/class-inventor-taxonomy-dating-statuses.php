<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Taxonomy_Dating_Statuses.
     *
     * @class  Inventor_Taxonomy_Dating_Statuses
     * @author Pragmatic Mates
     */
class Inventor_Taxonomy_Dating_Statuses
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
            'name'              => __('Dating Statuses', 'inventor'),
            'singular_name'     => __('Dating Status', 'inventor'),
            'search_items'      => __('Search Dating Status', 'inventor'),
            'all_items'         => __('All Dating Statuses', 'inventor'),
            'parent_item'       => __('Parent Dating Status', 'inventor'),
            'parent_item_colon' => __('Parent Dating Status:', 'inventor'),
            'edit_item'         => __('Edit Dating Status', 'inventor'),
            'update_item'       => __('Update Dating Status', 'inventor'),
            'add_new_item'      => __('Add New Dating Status', 'inventor'),
            'new_item_name'     => __('New Dating Status', 'inventor'),
            'menu_name'         => __('Dating Statuses', 'inventor'),
            'not_found'         => __('No dating statuses found.', 'inventor'),
        ];
        register_taxonomy(
            'dating_statuses', ['dating'], [
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'dating-status',
            'rewrite'           => ['slug' => _x('dating-status', 'URL slug', 'inventor'), 'hierarchical' => true],
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
         * Set active menu for taxonomy dating status.
     *
         * @return string
         */
    public static function menu($parent_file)
    {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;
        if ('dating_statuses' === $taxonomy) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

    Inventor_Taxonomy_Dating_Statuses::init();

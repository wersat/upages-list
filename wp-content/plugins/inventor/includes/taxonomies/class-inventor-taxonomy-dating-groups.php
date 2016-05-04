<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Taxonomy_Dating_Groups.
     *
     * @class  Inventor_Taxonomy_Dating_Groups
     * @author Pragmatic Mates
     */
class Inventor_Taxonomy_Dating_Groups
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
            'name'              => __('Dating Groups', 'inventor'),
            'singular_name'     => __('Dating Group', 'inventor'),
            'search_items'      => __('Search Dating Group', 'inventor'),
            'all_items'         => __('All Dating Groups', 'inventor'),
            'parent_item'       => __('Parent Dating Group', 'inventor'),
            'parent_item_colon' => __('Parent Dating Group:', 'inventor'),
            'edit_item'         => __('Edit Dating Group', 'inventor'),
            'update_item'       => __('Update Dating Group', 'inventor'),
            'add_new_item'      => __('Add New Dating Group', 'inventor'),
            'new_item_name'     => __('New Dating Group', 'inventor'),
            'menu_name'         => __('Dating Groups', 'inventor'),
            'not_found'         => __('No dating groups found.', 'inventor'),
        ];
        register_taxonomy(
            'dating_groups', ['dating'], [
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'dating-group',
            'rewrite'           => ['slug' => _x('dating-group', 'URL slug', 'inventor'), 'hierarchical' => true],
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
         * Set active menu for taxonomy dating group.
     *
         * @return string
         */
    public static function menu($parent_file)
    {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;
        if ('dating_groups' === $taxonomy) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

    Inventor_Taxonomy_Dating_Groups::init();

<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Taxonomy_Food_Kinds.
     * @class  Inventor_Taxonomy_Food_Kinds
     * @author Pragmatic Mates
     */
    class Inventor_Taxonomy_Food_Kinds
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
                'name'              => __('Food Kinds', 'inventor'),
                'singular_name'     => __('Food Kind', 'inventor'),
                'search_items'      => __('Search Food Kind', 'inventor'),
                'all_items'         => __('All Food Kinds', 'inventor'),
                'parent_item'       => __('Parent Food Kind', 'inventor'),
                'parent_item_colon' => __('Parent Food Kind:', 'inventor'),
                'edit_item'         => __('Edit Food Kind', 'inventor'),
                'update_item'       => __('Update Food Kind', 'inventor'),
                'add_new_item'      => __('Add New Food Kind', 'inventor'),
                'new_item_name'     => __('New Food Kind', 'inventor'),
                'menu_name'         => __('Food Kinds', 'inventor'),
                'not_found'         => __('No food kinds found.', 'inventor'),
            ];
            register_taxonomy('food_kinds', ['food'], [
                'labels'            => $labels,
                'hierarchical'      => true,
                'query_var'         => 'food-kind',
                'rewrite'           => ['slug' => _x('food-kind', 'URL slug', 'inventor'), 'hierarchical' => true],
                'public'            => true,
                'show_ui'           => true,
                'show_in_menu'      => 'lexicon',
                'show_in_nav_menus' => true,
                'meta_box_cb'       => false,
                'show_admin_column' => true,
            ]);
        }

        /**
         * Set active menu for taxonomy food kind.
         * @return string
         */
        public static function menu($parent_file)
        {
            global $current_screen;
            $taxonomy = $current_screen->taxonomy;
            if ('food_kinds' === $taxonomy) {
                return 'lexicon';
            }

            return $parent_file;
        }
    }

    Inventor_Taxonomy_Food_Kinds::init();

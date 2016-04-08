<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Taxonomy_Dating_Interests.
     *
     * @class  Inventor_Taxonomy_Dating_Interests
     *
     * @author Pragmatic Mates
     */
    class Inventor_Taxonomy_Dating_Interests
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
                'name' => __('Dating Interests', 'inventor'),
                'singular_name' => __('Dating Status', 'inventor'),
                'search_items' => __('Search Dating Status', 'inventor'),
                'all_items' => __('All Dating Interests', 'inventor'),
                'parent_item' => __('Parent Dating Status', 'inventor'),
                'parent_item_colon' => __('Parent Dating Status:', 'inventor'),
                'edit_item' => __('Edit Dating Status', 'inventor'),
                'update_item' => __('Update Dating Status', 'inventor'),
                'add_new_item' => __('Add New Dating Status', 'inventor'),
                'new_item_name' => __('New Dating Status', 'inventor'),
                'menu_name' => __('Dating Interests', 'inventor'),
                'not_found' => __('No dating interests found.', 'inventor'),
            ];
            register_taxonomy('dating_interests', ['dating'], [
                'labels' => $labels,
                'hierarchical' => true,
                'query_var' => 'dating-interest',
                'rewrite' => ['slug' => _x('dating-interest', 'URL slug', 'inventor'),
                                        'hierarchical' => true,
                ],
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => 'lexicon',
                'show_in_nav_menus' => true,
                'meta_box_cb' => false,
                'show_admin_column' => true,
            ]);
        }

        /**
         * Set active menu for taxonomy dating interest.
         *
         * @return string
         */
        public static function menu($parent_file)
        {
            global $current_screen;
            $taxonomy = $current_screen->taxonomy;
            if ('dating_interests' == $taxonomy) {
                return 'lexicon';
            }

            return $parent_file;
        }
    }

    Inventor_Taxonomy_Dating_Interests::init();

<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Taxonomy_Travel_Activities.
     *
     * @class  Inventor_Taxonomy_Travel_Activities
     *
     * @author Pragmatic Mates
     */
    class Inventor_Taxonomy_Travel_Activities
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
                'name' => __('Travel Activities', 'inventor'),
                'singular_name' => __('Travel Activity', 'inventor'),
                'search_items' => __('Search Travel Activity', 'inventor'),
                'all_items' => __('All Travel Activities', 'inventor'),
                'parent_item' => __('Parent Travel Activity', 'inventor'),
                'parent_item_colon' => __('Parent Travel Activity:', 'inventor'),
                'edit_item' => __('Edit Travel Activity', 'inventor'),
                'update_item' => __('Update Travel Activity', 'inventor'),
                'add_new_item' => __('Add New Travel Activity', 'inventor'),
                'new_item_name' => __('New Travel Activity', 'inventor'),
                'menu_name' => __('Travel Activities', 'inventor'),
                'not_found' => __('No travel activities found.', 'inventor'),
            ];
            register_taxonomy('travel_activities', ['travel'], [
                'labels' => $labels,
                'hierarchical' => true,
                'query_var' => 'travel-activity',
                'rewrite' => ['slug' => _x('travel-activity', 'URL slug', 'inventor'),
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
         * Set active menu for taxonomy travel activity.
         *
         * @return string
         */
        public static function menu($parent_file)
        {
            global $current_screen;
            $taxonomy = $current_screen->taxonomy;
            if ('travel_activities' === $taxonomy) {
                return 'lexicon';
            }

            return $parent_file;
        }
    }

    Inventor_Taxonomy_Travel_Activities::init();

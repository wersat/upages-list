<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Taxonomy_Car_Models.
     * @class  Inventor_Taxonomy_Car_Models
     * @author Pragmatic Mates
     */
    class Inventor_Taxonomy_Car_Models
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
                'name'              => __('Car Models', 'inventor'),
                'singular_name'     => __('Car Model', 'inventor'),
                'search_items'      => __('Search Car Model', 'inventor'),
                'all_items'         => __('All Car Models', 'inventor'),
                'parent_item'       => __('Parent Car Model', 'inventor'),
                'parent_item_colon' => __('Parent Car Model:', 'inventor'),
                'edit_item'         => __('Edit Car Model', 'inventor'),
                'update_item'       => __('Update Car Model', 'inventor'),
                'add_new_item'      => __('Add New Car Model', 'inventor'),
                'new_item_name'     => __('New Car Model', 'inventor'),
                'menu_name'         => __('Car Models', 'inventor'),
                'not_found'         => __('No car models found.', 'inventor'),
            ];
            register_taxonomy('car_models', ['car'], [
                'labels'            => $labels,
                'hierarchical'      => true,
                'query_var'         => 'car-model',
                'rewrite'           => ['slug' => _x('car-model', 'URL slug', 'inventor'), 'hierarchical' => true],
                'public'            => true,
                'show_ui'           => true,
                'show_in_menu'      => 'lexicon',
                'show_in_nav_menus' => true,
                'meta_box_cb'       => false,
                'show_admin_column' => true,
            ]);
        }

        /**
         * Set active menu for taxonomy car model.
         * @return string
         */
        public static function menu($parent_file)
        {
            global $current_screen;
            $taxonomy = $current_screen->taxonomy;
            if ('car_models' === $taxonomy) {
                return 'lexicon';
            }

            return $parent_file;
        }
    }

    Inventor_Taxonomy_Car_Models::init();

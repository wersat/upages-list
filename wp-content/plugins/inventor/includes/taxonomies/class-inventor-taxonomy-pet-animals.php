<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Taxonomy_Pet_Animals.
     * @class  Inventor_Taxonomy_Pet_Animals
     * @author Pragmatic Mates
     */
    class Inventor_Taxonomy_Pet_Animals
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
                'name'              => __('Pet Animals', 'inventor'),
                'singular_name'     => __('Pet Animal', 'inventor'),
                'search_items'      => __('Search Pet Animal', 'inventor'),
                'all_items'         => __('All Pet Animals', 'inventor'),
                'parent_item'       => __('Parent Pet Animal', 'inventor'),
                'parent_item_colon' => __('Parent Pet Animal:', 'inventor'),
                'edit_item'         => __('Edit Pet Animal', 'inventor'),
                'update_item'       => __('Update Pet Animal', 'inventor'),
                'add_new_item'      => __('Add New Pet Animal', 'inventor'),
                'new_item_name'     => __('New Pet Animal', 'inventor'),
                'menu_name'         => __('Pet Animals', 'inventor'),
                'not_found'         => __('No pet animals found.', 'inventor'),
            ];
            register_taxonomy('pet_animals', ['pet'], [
                'labels'            => $labels,
                'hierarchical'      => true,
                'query_var'         => 'pet-animal',
                'rewrite'           => ['slug' => _x('pet-animal', 'URL slug', 'inventor'), 'hierarchical' => true],
                'public'            => true,
                'show_ui'           => true,
                'show_in_menu'      => 'lexicon',
                'show_in_nav_menus' => true,
                'meta_box_cb'       => false,
                'show_admin_column' => true,
            ]);
        }

        /**
         * Set active menu for taxonomy pet animal.
         * @return string
         */
        public static function menu($parent_file)
        {
            global $current_screen;
            $taxonomy = $current_screen->taxonomy;
            if ('pet_animals' === $taxonomy) {
                return 'lexicon';
            }

            return $parent_file;
        }
    }

    Inventor_Taxonomy_Pet_Animals::init();

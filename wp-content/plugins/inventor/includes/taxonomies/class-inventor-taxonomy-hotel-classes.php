<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Taxonomy_Hotel_Classes.
     *
     * @class  Inventor_Taxonomy_Hotel_Classes
     *
     * @author Pragmatic Mates
     */
    class Inventor_Taxonomy_Hotel_Classes
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
                'name' => __('Hotel Classes', 'inventor'),
                'singular_name' => __('Hotel Class', 'inventor'),
                'search_items' => __('Search Hotel Class', 'inventor'),
                'all_items' => __('All Hotel Classes', 'inventor'),
                'parent_item' => __('Parent Hotel Class', 'inventor'),
                'parent_item_colon' => __('Parent Hotel Class:', 'inventor'),
                'edit_item' => __('Edit Hotel Class', 'inventor'),
                'update_item' => __('Update Hotel Class', 'inventor'),
                'add_new_item' => __('Add New Hotel Class', 'inventor'),
                'new_item_name' => __('New Hotel Class', 'inventor'),
                'menu_name' => __('Hotel Classes', 'inventor'),
                'not_found' => __('No hotel classes found.', 'inventor'),
            ];
            register_taxonomy('hotel_classes', ['hotel'], [
                'labels' => $labels,
                'hierarchical' => true,
                'query_var' => 'hotel-class',
                'rewrite' => ['slug' => _x('hotel-class', 'URL slug', 'inventor'), 'hierarchical' => true],
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => 'lexicon',
                'show_in_nav_menus' => true,
                'meta_box_cb' => false,
                'show_admin_column' => true,
            ]);
        }

        /**
         * Set active menu for taxonomy hotel class.
         *
         * @return string
         */
        public static function menu($parent_file)
        {
            global $current_screen;
            $taxonomy = $current_screen->taxonomy;
            if ('hotel_classes' === $taxonomy) {
                return 'lexicon';
            }

            return $parent_file;
        }
    }

    Inventor_Taxonomy_Hotel_Classes::init();

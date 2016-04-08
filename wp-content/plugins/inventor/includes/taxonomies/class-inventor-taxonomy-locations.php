<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Taxonomy_Locations.
     *
     * @class  Inventor_Taxonomy_Locations
     *
     * @author Pragmatic Mates
     */
    class Inventor_Taxonomy_Locations
    {
        /**
         * Initialize taxonomy.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition'], 12);
            add_action('parent_file', [__CLASS__, 'menu']);
        }

        /**
         * Widget definition.
         */
        public static function definition()
        {
            $labels = [
                'name' => __('Locations', 'inventor'),
                'singular_name' => __('Location', 'inventor'),
                'search_items' => __('Search Location', 'inventor'),
                'all_items' => __('All Locations', 'inventor'),
                'parent_item' => __('Parent Location', 'inventor'),
                'parent_item_colon' => __('Parent Location:', 'inventor'),
                'edit_item' => __('Edit Location', 'inventor'),
                'update_itm' => __('Update Location', 'inventor'),
                'add_new_item' => __('Add New Location', 'inventor'),
                'new_item_name' => __('New Location', 'inventor'),
                'menu_name' => __('Locations', 'inventor'),
                'not_found' => __('No locations found.', 'inventor'),
            ];
            register_taxonomy('locations', Inventor_Post_Types::get_listing_post_types(), [
                'labels' => $labels,
                'hierarchical' => true,
                'query_var' => 'location',
                'rewrite' => ['slug' => _x('location', 'URL slug', 'inventor'), 'hierarchical' => true],
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => false,
                'show_in_nav_menus' => true,
                'meta_box_cb' => false,
                'show_admin_column' => true,
            ]);
        }

        /**
         * Set active menu for taxonomy location.
         *
         * @return string
         */
        public static function menu($parent_file)
        {
            global $current_screen;
            $taxonomy = $current_screen->taxonomy;
            if ('locations' == $taxonomy) {
                return 'inventor';
            }

            return $parent_file;
        }
    }

    Inventor_Taxonomy_Locations::init();

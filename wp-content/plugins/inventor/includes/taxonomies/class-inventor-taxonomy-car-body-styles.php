<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Taxonomy_Car_Body_Styles.
     * @class  Inventor_Taxonomy_Car_Body_Styles
     * @author Pragmatic Mates
     */
    class Inventor_Taxonomy_Car_Body_Styles
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
                'name'              => __('Car Body Styles', 'inventor'),
                'singular_name'     => __('Car Body Style', 'inventor'),
                'search_items'      => __('Search Car Body Style', 'inventor'),
                'all_items'         => __('All Car Body Styles', 'inventor'),
                'parent_item'       => __('Parent Car Body Style', 'inventor'),
                'parent_item_colon' => __('Parent Car Body Style:', 'inventor'),
                'edit_item'         => __('Edit Car Body Style', 'inventor'),
                'update_item'       => __('Update Car Body Style', 'inventor'),
                'add_new_item'      => __('Add New Car Body Style', 'inventor'),
                'new_item_name'     => __('New Car Body Style', 'inventor'),
                'menu_name'         => __('Car Body Styles', 'inventor'),
                'not_found'         => __('No car body styles found.', 'inventor'),
            ];
            register_taxonomy('car_body_styles', ['car'], [
                'labels'            => $labels,
                'hierarchical'      => true,
                'query_var'         => 'car-body-style',
                'rewrite'           => ['slug' => _x('car-body-style', 'URL slug', 'inventor'), 'hierarchical' => true],
                'public'            => true,
                'show_ui'           => true,
                'show_in_menu'      => 'lexicon',
                'show_in_nav_menus' => true,
                'meta_box_cb'       => false,
                'show_admin_column' => true,
            ]);
        }

        /**
         * Set active menu for taxonomy car body style.
         * @return string
         */
        public static function menu($parent_file)
        {
            global $current_screen;
            $taxonomy = $current_screen->taxonomy;
            if ('car_body_styles' === $taxonomy) {
                return 'lexicon';
            }

            return $parent_file;
        }
    }

    Inventor_Taxonomy_Car_Body_Styles::init();

<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Properties_Taxonomy_Property_Amenities.
     * @class   Inventor_Properties_Taxonomy_Property_Amenities
     * @author  Pragmatic Mates
     */
    class Inventor_Properties_Taxonomy_Property_Amenities
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
                'name'              => __('Property Amenities', 'inventor-properties'),
                'singular_name'     => __('Property Amenity', 'inventor-properties'),
                'search_items'      => __('Search Property Amenity', 'inventor-properties'),
                'all_items'         => __('All Property Amenities', 'inventor-properties'),
                'parent_item'       => __('Parent Property Amenity', 'inventor-properties'),
                'parent_item_colon' => __('Parent Property Amenity:', 'inventor-properties'),
                'edit_item'         => __('Edit Property Amenity', 'inventor-properties'),
                'update_item'       => __('Update Property Amenity', 'inventor-properties'),
                'add_new_item'      => __('Add New Property Amenity', 'inventor-properties'),
                'new_item_name'     => __('New Property Amenity', 'inventor-properties'),
                'menu_name'         => __('Property Amenities', 'inventor-properties'),
                'not_found'         => __('No property amenities found.', 'inventor-properties'),
            ];
            register_taxonomy('property_amenities', ['property'], [
                'labels'            => $labels,
                'hierarchical'      => true,
                'query_var'         => 'property-amenity',
                'rewrite'           => [
                    'slug'         => _x('property-amenity', 'URL slug', 'inventor-properties'),
                    'hierarchical' => true,
                ],
                'public'            => true,
                'show_ui'           => true,
                'show_in_menu'      => 'lexicon',
                'show_in_nav_menus' => true,
                'meta_box_cb'       => false,
                'show_admin_column' => false,
            ]);
        }

        /**
         * Set active menu for taxonomy amenity.
         * @return string
         */
        public static function menu($parent_file)
        {
            global $current_screen;
            $taxonomy = $current_screen->taxonomy;
            if ('property_amenities' == $taxonomy) {
                return 'lexicon';
            }

            return $parent_file;
        }
    }

    Inventor_Properties_Taxonomy_Property_Amenities::init();

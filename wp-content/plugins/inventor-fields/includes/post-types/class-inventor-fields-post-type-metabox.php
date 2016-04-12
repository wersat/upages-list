<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Fields_Post_Type_Metabox.
     * @class  Inventor_Fields_Post_Type_Metabox
     * @author Pragmatic Mates
     */
    class Inventor_Fields_Post_Type_Metabox
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            add_action('cmb2_init', [__CLASS__, 'fields'], 13);
            add_action('cmb2_init', [__CLASS__, 'add_metaboxes_to_listing_types'], 14);
        }

        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name'               => __('Metaboxes', 'inventor-fields'),
                'singular_name'      => __('Metabox', 'inventor-fields'),
                'add_new_item'       => __('Add New Metabox', 'inventor-fields'),
                'add_new'            => __('Add New Metabox', 'inventor-fields'),
                'edit_item'          => __('Edit Metabox', 'inventor-fields'),
                'new_item'           => __('New Metabox', 'inventor-fields'),
                'all_items'          => __('Metaboxes', 'inventor-fields'),
                'view_item'          => __('View Metabox', 'inventor-fields'),
                'search_items'       => __('Search Metabox', 'inventor-fields'),
                'not_found'          => __('No Metaboxes found', 'inventor-fields'),
                'not_found_in_trash' => __('No Metaboxes found in Trash', 'inventor-fields'),
                'parent_item_colon'  => '',
                'menu_name'          => __('Metaboxes', 'inventor-fields'),
            ];
            register_post_type('metabox', [
                'labels'              => $labels,
                'supports'            => ['title'],
                'public'              => false,
                'exclude_from_search' => true,
                'publicly_queryable'  => false,
                'show_in_nav_menus'   => false,
                'show_ui'             => true,
                'show_in_menu'        => class_exists('Inventor_Admin_Menu') ? 'inventor' : true,
            ]);
        }

        /**
         * Defines custom fields.
         */
        public static function fields()
        {
            // Settings
            $settings = new_cmb2_box([
                'id'           => INVENTOR_FIELDS_METABOX_PREFIX . 'settings',
                'title'        => __('Settings', 'inventor-fields'),
                'object_types' => ['metabox'],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            // Identifier
            $settings->add_field([
                'name'        => __('Identifier', 'inventor-fields'),
                'description' => __('Unique identifier', 'inventor-fields'),
                'id'          => INVENTOR_FIELDS_METABOX_PREFIX . 'identifier',
                'type'        => 'text',
                'attributes'  => [
                    'required' => 'required',
                ],
            ]);
            // Post Types
            $listings_types = [];
            foreach (Inventor_Post_Types::get_all_listing_post_types() as $post_type) {
                if ($post_type->show_in_menu === 'listings') {
                    $listings_types[$post_type->name] = $post_type->labels->name;
                }
            }
            // Sort alphabetically
            ksort($listings_types);
            $settings->add_field([
                'name'    => __('Listing type', 'inventor-fields'),
                'id'      => INVENTOR_FIELDS_METABOX_PREFIX . 'listing_type',
                'type'    => 'multicheck',
                'options' => $listings_types,
            ]);
        }

        /**
         * Adds defined metaboxes into post types.
         */
        public static function add_metaboxes_to_listing_types()
        {
            $query = new WP_Query([
                'post_type'      => 'metabox',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            ]);
            foreach ($query->posts as $metabox) {
                $listing_types = get_post_meta($metabox->ID, INVENTOR_FIELDS_METABOX_PREFIX . 'listing_type', true);
                if ( ! is_array($listing_types)) {
                    continue;
                }
                $identifier = get_post_meta($metabox->ID, INVENTOR_FIELDS_METABOX_PREFIX . 'identifier', true);
                $title      = get_the_title($metabox->ID);
                foreach ($listing_types as $listing_type) {
                    new_cmb2_box([
                        'id'           => INVENTOR_LISTING_PREFIX . $listing_type . '_' . $identifier,
                        'title'        => $title,
                        'object_types' => [$listing_type],
                        'context'      => 'normal',
                        'priority'     => 'high',
                    ]);
                }
            }
        }
    }

    Inventor_Fields_Post_Type_Metabox::init();

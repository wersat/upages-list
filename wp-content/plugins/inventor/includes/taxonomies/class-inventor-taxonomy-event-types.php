<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Taxonomy_Event_Types.
     * @class  Inventor_Taxonomy_Event_Types
     * @author Pragmatic Mates
     */
    class Inventor_Taxonomy_Event_Types
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
                'name'              => __('Event Types', 'inventor'),
                'singular_name'     => __('Event Type', 'inventor'),
                'search_items'      => __('Search Event Type', 'inventor'),
                'all_items'         => __('All Event Types', 'inventor'),
                'parent_item'       => __('Parent Event Type', 'inventor'),
                'parent_item_colon' => __('Parent Event Type:', 'inventor'),
                'edit_item'         => __('Edit Event Type', 'inventor'),
                'update_item'       => __('Update Event Type', 'inventor'),
                'add_new_item'      => __('Add New Event Type', 'inventor'),
                'new_item_name'     => __('New Event Type', 'inventor'),
                'menu_name'         => __('Event Types', 'inventor'),
                'not_found'         => __('No event types found.', 'inventor'),
            ];
            register_taxonomy('event_types', ['event'], [
                'labels'            => $labels,
                'hierarchical'      => true,
                'query_var'         => 'event-type',
                'rewrite'           => ['slug' => _x('event-type', 'URL slug', 'inventor'), 'hierarchical' => true],
                'public'            => true,
                'show_ui'           => true,
                'show_in_menu'      => 'lexicon',
                'show_in_nav_menus' => true,
                'meta_box_cb'       => false,
                'show_admin_column' => true,
            ]);
        }

        /**
         * Set active menu for taxonomy event type.
         * @return string
         */
        public static function menu($parent_file)
        {
            global $current_screen;
            $taxonomy = $current_screen->taxonomy;
            if ('event_types' === $taxonomy) {
                return 'lexicon';
            }

            return $parent_file;
        }
    }

    Inventor_Taxonomy_Event_Types::init();

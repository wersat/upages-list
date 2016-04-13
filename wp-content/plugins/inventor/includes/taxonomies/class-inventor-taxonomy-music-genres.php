<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Taxonomy_Music_Genres.
     * @class  Inventor_Taxonomy_Music_Genres
     * @author Pragmatic Mates
     */
    class Inventor_Taxonomy_Music_Genres
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
                'name'              => __('Music Genres', 'inventor'),
                'singular_name'     => __('Music Genre', 'inventor'),
                'search_items'      => __('Search Music Genre', 'inventor'),
                'all_items'         => __('All Music Genres', 'inventor'),
                'parent_item'       => __('Parent Music Genre', 'inventor'),
                'parent_item_colon' => __('Parent Music Genre:', 'inventor'),
                'edit_item'         => __('Edit Music Genre', 'inventor'),
                'update_item'       => __('Update Music Genre', 'inventor'),
                'add_new_item'      => __('Add New Music Genre', 'inventor'),
                'new_item_name'     => __('New Music Genre', 'inventor'),
                'menu_name'         => __('Music Genres', 'inventor'),
                'not_found'         => __('No music genres found.', 'inventor'),
            ];
            register_taxonomy('music_genres', ['music'], [
                'labels'            => $labels,
                'hierarchical'      => true,
                'query_var'         => 'music-genre',
                'rewrite'           => ['slug' => _x('music-genre', 'URL slug', 'inventor'), 'hierarchical' => true],
                'public'            => true,
                'show_ui'           => true,
                'show_in_menu'      => 'lexicon',
                'show_in_nav_menus' => true,
                'meta_box_cb'       => false,
                'show_admin_column' => true,
            ]);
        }

        /**
         * Set active menu for taxonomy music genre.
         * @return string
         */
        public static function menu($parent_file)
        {
            global $current_screen;
            $taxonomy = $current_screen->taxonomy;
            if ('music_genres' === $taxonomy) {
                return 'lexicon';
            }

            return $parent_file;
        }
    }

    Inventor_Taxonomy_Music_Genres::init();

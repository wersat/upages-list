<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Jobs_Taxonomy_Job_Positions.
     * @class  Inventor_Jobs_Taxonomy_Job_Positions
     * @author Pragmatic Mates
     */
    class Inventor_Jobs_Taxonomy_Job_Positions
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
                'name'              => __('Job Positions', 'inventor-jobs'),
                'singular_name'     => __('Job Position', 'inventor-jobs'),
                'search_items'      => __('Search Job Position', 'inventor-jobs'),
                'all_items'         => __('All Job Positions', 'inventor-jobs'),
                'parent_item'       => __('Parent Job Position', 'inventor-jobs'),
                'parent_item_colon' => __('Parent Job Position:', 'inventor-jobs'),
                'edit_item'         => __('Edit Job Position', 'inventor-jobs'),
                'update_item'       => __('Update Job Position', 'inventor-jobs'),
                'add_new_item'      => __('Add New Job Position', 'inventor-jobs'),
                'new_item_name'     => __('New Job Position', 'inventor-jobs'),
                'menu_name'         => __('Job Positions', 'inventor-jobs'),
                'not_found'         => __('No job positions found.', 'inventor-jobs'),
            ];
            register_taxonomy('job_positions', ['job'], [
                'labels'            => $labels,
                'hierarchical'      => true,
                'query_var'         => 'job-position',
                'rewrite'           => [
                    'slug'         => _x('job-position', 'URL slug', 'inventor-jobs'),
                    'hierarchical' => true,
                ],
                'public'            => true,
                'show_ui'           => true,
                'show_in_menu'      => 'lexicon',
                'show_in_nav_menus' => true,
                'meta_box_cb'       => false,
                'show_admin_column' => true,
            ]);
        }

        /**
         * Set active menu for taxonomy job position.
         * @return string
         */
        public static function menu($parent_file)
        {
            global $current_screen;
            $taxonomy = $current_screen->taxonomy;
            if ('job_positions' == $taxonomy) {
                return 'lexicon';
            }

            return $parent_file;
        }
    }

    Inventor_Jobs_Taxonomy_Job_Positions::init();

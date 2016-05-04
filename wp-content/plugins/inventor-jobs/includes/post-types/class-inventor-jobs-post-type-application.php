<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Jobs_Post_Type_Application.
     * @class  Inventor_Jobs_Post_Type_Application
     * @author Pragmatic Mates
     */
    class Inventor_Jobs_Post_Type_Application
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            add_filter('cmb2_init', [__CLASS__, 'fields']);
            add_filter('manage_edit-application_columns', [__CLASS__, 'custom_columns']);
            add_action('manage_application_posts_custom_column', [__CLASS__, 'custom_columns_manage']);
        }

        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name'               => __('Applications', 'inventor-jobs'),
                'singular_name'      => __('Application', 'inventor-jobs'),
                'add_new'            => __('Add New Application', 'inventor-jobs'),
                'add_new_item'       => __('Add New Application', 'inventor-jobs'),
                'edit_item'          => __('Edit Application', 'inventor-jobs'),
                'new_item'           => __('New Application', 'inventor-jobs'),
                'all_items'          => __('Applications', 'inventor-jobs'),
                'view_item'          => __('View Application', 'inventor-jobs'),
                'search_items'       => __('Search Application', 'inventor-jobs'),
                'not_found'          => __('No Applications found', 'inventor-jobs'),
                'not_found_in_trash' => __('No Applications Found in Trash', 'inventor-jobs'),
                'parent_item_colon'  => '',
                'menu_name'          => __('Applications', 'inventor-jobs'),
            ];
            register_post_type('application', [
                'labels'       => $labels,
                'show_in_menu' => class_exists('Inventor_Admin_Menu') ? 'inventor' : true,
                'supports'     => ['title', 'editor', 'author'],
                'public'       => false,
                'has_archive'  => false,
                'show_ui'      => true,
                'categories'   => [],
            ]);
        }

        /**
         * Defines custom fields.
         * @return array
         */
        public static function fields()
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_APPLICATION_PREFIX . 'general',
                'title'        => __('General', 'inventor-jobs'),
                'object_types' => ['application'],
                'context'      => 'normal',
                'priority'     => 'high',
                'show_names'   => true,
            ]);
            $cmb->add_field([
                'id'         => INVENTOR_APPLICATION_PREFIX . 'job_id',
                'name'       => __('Job ID', 'inventor-jobs'),
                'type'       => 'text_small',
                'attributes' => [
                    'type'    => 'number',
                    'pattern' => '\d*',
                ],
            ]);
            $cmb->add_field([
                'id'         => INVENTOR_APPLICATION_PREFIX . 'resume_id',
                'name'       => __('Resume ID', 'inventor-jobs'),
                'type'       => 'text_small',
                'attributes' => [
                    'type'    => 'number',
                    'pattern' => '\d*',
                ],
            ]);
        }

        /**
         * Custom admin columns.
         * @return array
         */
        public static function custom_columns()
        {
            $fields = [
                'cb'     => '<input type="checkbox" />',
                'title'  => __('Name', 'inventor-jobs'),
                'job'    => __('Job', 'inventor-jobs'),
                'resume' => __('Resume', 'inventor-jobs'),
                'author' => __('Author', 'inventor-jobs'),
                'date'   => __('Date', 'inventor-jobs'),
            ];

            return $fields;
        }

        /**
         * Custom admin columns implementation.
         *
         * @param string $column
         *
         * @return array
         */
        public static function custom_columns_manage($column)
        {
            switch ($column) {
                case 'job':
                    $job_id = get_post_meta(get_the_ID(), INVENTOR_APPLICATION_PREFIX . 'job_id', true);
                    echo get_the_title($job_id);
                    break;
                case 'resume':
                    $resume_id = get_post_meta(get_the_ID(), INVENTOR_APPLICATION_PREFIX . 'resume_id', true);
                    echo get_the_title($resume_id);
                    break;
            }
        }
    }

    Inventor_Jobs_Post_Type_Application::init();

<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_FAQ_Post_Type_FAQ.
     * @class  Inventor_FAQ_Post_Type_FAQ
     * @author Pragmatic Mates
     */
    class Inventor_FAQ_Post_Type_FAQ
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            add_filter('enter_title_here', [__CLASS__, 'title']);
        }

        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name'               => __('FAQs', 'inventor-faq'),
                'singular_name'      => __('FAQ', 'inventor-faq'),
                'add_new'            => __('Add New FAQ', 'inventor-faq'),
                'add_new_item'       => __('Add New FAQ', 'inventor-faq'),
                'edit_item'          => __('Edit FAQ', 'inventor-faq'),
                'new_item'           => __('New FAQ', 'inventor-faq'),
                'all_items'          => __('FAQ', 'inventor-faq'),
                'view_item'          => __('View FAQ', 'inventor-faq'),
                'search_items'       => __('Search FAQ', 'inventor-faq'),
                'not_found'          => __('No FAQ found', 'inventor-faq'),
                'not_found_in_trash' => __('No FAQ found in Trash', 'inventor-faq'),
                'parent_item_colon'  => '',
                'menu_name'          => __('FAQ', 'inventor-faq'),
            ];
            register_post_type('faq', [
                'labels'        => $labels,
                'supports'      => ['title', 'editor'],
                'public'        => true,
                'show_ui'       => true,
                'rewrite'       => ['slug' => _x('faq', 'URL slug', 'inventor-faq')],
                'has_archive'   => true,
                'show_in_menu'  => class_exists('Inventor_Admin_Menu') ? 'inventor' : true,
                'menu_icon'     => 'dashicons-editor-help',
                'menu_position' => 55,
            ]);
        }

        /**
         * Replaces placeholder in "title" field.
         *
         * @param $input
         *
         * @return string|void
         */
        public static function title($input)
        {
            global $post_type;
            if (is_admin() && 'faq' == $post_type) {
                return __('Frequently Asked Question', 'inventor-faq');
            }

            return $input;
        }
    }

    Inventor_FAQ_Post_Type_FAQ::init();

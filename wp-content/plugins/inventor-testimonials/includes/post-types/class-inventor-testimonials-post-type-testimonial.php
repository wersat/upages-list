<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Testimonials_Post_Type_Testimonial.
     * @class  Inventor_Testimonials_Post_Type_Testimonial
     * @author Pragmatic Mates
     */
    class Inventor_Testimonials_Post_Type_Testimonial
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            add_filter('cmb2_init', [__CLASS__, 'fields']);
        }

        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name'               => __('Testimonials', 'inventor-testimonials'),
                'singular_name'      => __('Testimonial', 'inventor-testimonials'),
                'add_new'            => __('Add New Testimonial', 'inventor-testimonials'),
                'add_new_item'       => __('Add New Testimonial', 'inventor-testimonials'),
                'edit_item'          => __('Edit Testimonial', 'inventor-testimonials'),
                'new_item'           => __('New Testimonial', 'inventor-testimonials'),
                'all_items'          => __('Testimonials', 'inventor-testimonials'),
                'view_item'          => __('View Testimonial', 'inventor-testimonials'),
                'search_items'       => __('Search Testimonials', 'inventor-testimonials'),
                'not_found'          => __('No Testimonials found', 'inventor-testimonials'),
                'not_found_in_trash' => __('No Testimonials found in Trash', 'inventor-testimonials'),
                'parent_item_colon'  => '',
                'menu_name'          => __('Testimonials', 'inventor-testimonials'),
            ];
            register_post_type('testimonial', [
                'labels'        => $labels,
                'supports'      => ['title', 'editor', 'thumbnail'],
                'public'        => false,
                'show_ui'       => true,
                'rewrite'       => ['slug' => _x('testimonials', 'URL slug', 'inventor-testimonials')],
                'show_in_menu'  => class_exists('Inventor_Admin_Menu') ? 'inventor' : true,
                'menu_icon'     => 'dashicons-testimonial',
                'menu_position' => 55,
            ]);
        }

        /**
         * Defines custom fields.
         * @return array
         */
        public static function fields()
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_TESTIMONIALS_PREFIX . 'details',
                'title'        => __('Details', 'inventor-testimonials'),
                'object_types' => ['testimonial'],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $cmb->add_field([
                'name' => __('Author', 'inventor-testimonials'),
                'id'   => INVENTOR_TESTIMONIALS_PREFIX . 'author',
                'type' => 'text',
            ]);
        }
    }

    Inventor_Testimonials_Post_Type_Testimonial::init();

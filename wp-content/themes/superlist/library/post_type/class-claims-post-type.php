<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }
    /**
     * Class Inventor_Claims_Post_Type_Claim.
     * @class  Inventor_Claims_Post_Type_Claim
     * @author Pragmatic Mates
     */
    class Inventor_Claims_Post_Type_Claim
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            add_filter('cmb2_init', [__CLASS__, 'fields']);
            add_filter('manage_edit-claim_columns', [__CLASS__, 'custom_columns']);
            add_action('manage_claim_posts_custom_column', [__CLASS__, 'custom_columns_manage']);
        }
        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name'               => __('Claims', 'inventor-claims'),
                'singular_name'      => __('Claim', 'inventor-claims'),
                'add_new'            => __('Add New Claim', 'inventor-claims'),
                'add_new_item'       => __('Add New Claim', 'inventor-claims'),
                'edit_item'          => __('Edit Claim', 'inventor-claims'),
                'new_item'           => __('New Claim', 'inventor-claims'),
                'all_items'          => __('Claims', 'inventor-claims'),
                'view_item'          => __('View Claim', 'inventor-claims'),
                'search_items'       => __('Search Claim', 'inventor-claims'),
                'not_found'          => __('No Claims found', 'inventor-claims'),
                'not_found_in_trash' => __('No Claims Found in Trash', 'inventor-claims'),
                'parent_item_colon'  => '',
                'menu_name'          => __('Claims', 'inventor-claims'),
            ];
            register_post_type('claim', [
                'labels'       => $labels,
                'show_in_menu' => class_exists('Inventor_Admin_Menu') ? 'inventor' : true,
                'supports'     => ['author'],
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
                'id'           => INVENTOR_CLAIM_PREFIX . 'general',
                'title'        => __('General', 'inventor-claims'),
                'object_types' => ['claim'],
                'context'      => 'normal',
                'priority'     => 'high',
                'show_names'   => true,
            ]);
            $cmb->add_field([
                'id'         => INVENTOR_CLAIM_PREFIX . 'listing_id',
                'name'       => __('Listing ID', 'inventor-claims'),
                'type'       => 'text_small',
                'attributes' => [
                    'type'    => 'number',
                    'pattern' => '\d*',
                ],
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_CLAIM_PREFIX . 'name',
                'name' => __('Name', 'inventor-claims'),
                'type' => 'text_medium',
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_CLAIM_PREFIX . 'email',
                'name' => __('Email', 'inventor-claims'),
                'type' => 'text_medium',
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_CLAIM_PREFIX . 'phone',
                'name' => __('Phone', 'inventor-claims'),
                'type' => 'text_medium',
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_CLAIM_PREFIX . 'message',
                'name' => __('Message', 'inventor-claims'),
                'type' => 'textarea_code',
            ]);
        }
        /**
         * Custom admin columns.
         * @return array
         */
        public static function custom_columns()
        {
            $fields = [
                'cb'      => '<input type="checkbox" />',
                'title'   => __('Title', 'inventor-claims'),
                'listing' => __('Listing', 'inventor-claims'),
                'author'  => __('Author', 'inventor-claims'),
                'date'    => __('Date', 'inventor-claims'),
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
                case 'listing':
                    $listing_id = get_post_meta(get_the_ID(), INVENTOR_CLAIM_PREFIX . 'listing_id', true);
                    echo get_the_title($listing_id);
                    break;
            }
        }
    }
    Inventor_Claims_Post_Type_Claim::init();

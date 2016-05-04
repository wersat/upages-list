<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Post_Type_Report.
     *
     * @class  Inventor_Post_Type_Report
     * @author Pragmatic Mates
     */
class Inventor_Post_Type_Report
{
    /**
         * Initialize custom post type.
         */
    public static function init()
    {
        add_action('init', [__CLASS__, 'definition']);
        add_filter('cmb2_init', [__CLASS__, 'fields']);
        add_filter('manage_edit-report_columns', [__CLASS__, 'custom_columns']);
        add_action('manage_report_posts_custom_column', [__CLASS__, 'custom_columns_manage']);
    }

    /**
         * Custom post type definition.
         */
    public static function definition()
    {
        $labels = [
            'name'               => __('Reports', 'inventor'),
            'singular_name'      => __('Report', 'inventor'),
            'add_new'            => __('Add New Report', 'inventor'),
            'add_new_item'       => __('Add New Report', 'inventor'),
            'edit_item'          => __('Edit Report', 'inventor'),
            'new_item'           => __('New Report', 'inventor'),
            'all_items'          => __('Reports', 'inventor'),
            'view_item'          => __('View Report', 'inventor'),
            'search_items'       => __('Search Report', 'inventor'),
            'not_found'          => __('No Reports found', 'inventor'),
            'not_found_in_trash' => __('No Reports Found in Trash', 'inventor'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Reports', 'inventor'),
        ];
        register_post_type(
            'report', [
            'labels'       => $labels,
            'show_in_menu' => 'inventor',
            'supports'     => ['author'],
            'public'       => false,
            'has_archive'  => false,
            'show_ui'      => true,
            'categories'   => [],
            ]
        );
    }

    /**
         * Defines custom fields.
     *
         * @return array
         */
    public static function fields()
    {
        $cmb = new_cmb2_box(
            [
            'id'           => INVENTOR_REPORT_PREFIX . 'general',
            'title'        => __('General', 'inventor'),
            'object_types' => ['report'],
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true,
            ]
        );
        $cmb->add_field(
            [
            'id'         => INVENTOR_REPORT_PREFIX . 'listing_id',
            'name'       => __('Listing ID', 'inventor'),
            'type'       => 'text_small',
            'attributes' => [
                'type'    => 'number',
                'pattern' => '\d*',
            ],
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_REPORT_PREFIX . 'name',
            'name' => __('Name', 'inventor'),
            'type' => 'text_medium',
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_REPORT_PREFIX . 'email',
            'name' => __('Email', 'inventor'),
            'type' => 'text_medium',
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_REPORT_PREFIX . 'reason',
            'name' => __('Reason', 'inventor'),
            'type' => 'text',
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_REPORT_PREFIX . 'message',
            'name' => __('Message', 'inventor'),
            'type' => 'textarea_code',
            ]
        );
    }

    /**
         * Custom admin columns.
     *
         * @return array
         */
    public static function custom_columns()
    {
        $fields = [
            'cb'      => '<input type="checkbox" />',
            'title'   => __('Title', 'inventor'),
            'listing' => __('Listing', 'inventor'),
            'reason'  => __('Reason', 'inventor'),
            'author'  => __('Author', 'inventor'),
            'date'    => __('Date', 'inventor'),
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
            $listing_id = get_post_meta(get_the_ID(), INVENTOR_REPORT_PREFIX . 'listing_id', true);
            echo get_the_title($listing_id);
            break;
        case 'reason':
            $reason = get_post_meta(get_the_ID(), INVENTOR_REPORT_PREFIX . 'reason', true);
            echo $reason;
            break;
        }
    }
}

    Inventor_Post_Type_Report::init();

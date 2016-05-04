<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Post_Type_Car.
     *
     * @class  Inventor_Post_Type_Car
     * @author Pragmatic Mates
     */
class Inventor_Post_Type_Car
{
    /**
         * Initialize custom post type.
         */
    public static function init()
    {
        add_action('init', [__CLASS__, 'definition']);
        add_action('cmb2_init', [__CLASS__, 'fields']);
        add_filter('inventor_shop_allowed_listing_post_types', [__CLASS__, 'allowed_purchasing']);
        add_filter('inventor_claims_allowed_listing_post_types', [__CLASS__, 'allowed_claiming']);
    }

    /**
         * Defines if post type can be claimed.
         *
         * @param array $post_types
         *
         * @return array
         */
    public static function allowed_claiming($post_types)
    {
        $post_types[] = 'car';

        return $post_types;
    }

    /**
         * Defines if post type can be purchased.
         *
         * @param array $post_types
         *
         * @return array
         */
    public static function allowed_purchasing($post_types)
    {
        $post_types[] = 'car';

        return $post_types;
    }

    /**
         * Custom post type definition.
         */
    public static function definition()
    {
        $labels = [
            'name'               => __('Cars', 'inventor'),
            'singular_name'      => __('Car', 'inventor'),
            'add_new'            => __('Add New Car', 'inventor'),
            'add_new_item'       => __('Add New Car', 'inventor'),
            'edit_item'          => __('Edit Car', 'inventor'),
            'new_item'           => __('New Car', 'inventor'),
            'all_items'          => __('Cars', 'inventor'),
            'view_item'          => __('View Car', 'inventor'),
            'search_items'       => __('Search Car', 'inventor'),
            'not_found'          => __('No Cars found', 'inventor'),
            'not_found_in_trash' => __('No Cars Found in Trash', 'inventor'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Cars', 'inventor'),
        ];
        register_post_type(
            'car', [
            'labels'       => $labels,
            'show_in_menu' => 'listings',
            'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
            'has_archive'  => true,
            'rewrite'      => ['slug' => _x('cars', 'URL slug', 'inventor')],
            'public'       => true,
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
        Inventor_Post_Types::add_metabox('car', ['general']);
        $cmb = new_cmb2_box(
            [
            'id'           => INVENTOR_LISTING_PREFIX . 'car_details',
            'title'        => __('Details', 'inventor'),
            'object_types' => ['car'],
            'context'      => 'normal',
            'priority'     => 'high',
            ]
        );
        $cmb->add_field(
            [
            'name'     => __('Engine type', 'inventor'),
            'id'       => INVENTOR_LISTING_PREFIX . 'car_engine_type',
            'type'     => 'taxonomy_radio',
            'taxonomy' => 'car_engine_types',
            'default'  => Inventor_Submission::get_submission_field_value(
                INVENTOR_LISTING_PREFIX . 'car_details',
                INVENTOR_LISTING_PREFIX . 'car_engine_type'
            ),
            ]
        );
        $cmb->add_field(
            [
            'name'     => __('Body style', 'inventor'),
            'id'       => INVENTOR_LISTING_PREFIX . 'car_body_style',
            'type'     => 'taxonomy_multicheck_hierarchy',
            'taxonomy' => 'car_body_styles',
            'default'  => Inventor_Submission::get_submission_field_value(
                INVENTOR_LISTING_PREFIX . 'car_details',
                INVENTOR_LISTING_PREFIX . 'car_body_style'
            ),
            ]
        );
        $cmb->add_field(
            [
            'name'     => __('Transmission', 'inventor'),
            'id'       => INVENTOR_LISTING_PREFIX . 'car_transmission',
            'type'     => 'taxonomy_radio',
            'taxonomy' => 'car_transmissions',
            'default'  => Inventor_Submission::get_submission_field_value(
                INVENTOR_LISTING_PREFIX . 'car_details',
                INVENTOR_LISTING_PREFIX . 'car_transmission'
            ),
            ]
        );
        $cmb->add_field(
            [
            'name'     => __('Model', 'inventor'),
            'id'       => INVENTOR_LISTING_PREFIX . 'car_model',
            'type'     => 'taxonomy_multicheck_hierarchy',
            'taxonomy' => 'car_models',
            'default'  => Inventor_Submission::get_submission_field_value(
                INVENTOR_LISTING_PREFIX . 'car_details',
                INVENTOR_LISTING_PREFIX . 'car_model'
            ),
            ]
        );
        $cmb->add_field(
            [
            'name'       => __('Year manufactured', 'inventor'),
            'id'         => INVENTOR_LISTING_PREFIX . 'car_year_manufactured',
            'type'       => 'text',
            'attributes' => [
                'type'    => 'number',
                'pattern' => '\d*',
            ],
            'default'    => Inventor_Submission::get_submission_field_value(
                INVENTOR_LISTING_PREFIX . 'car_details',
                INVENTOR_LISTING_PREFIX . 'car_year_manufactured'
            ),
            ]
        );
        $cmb->add_field(
            [
            'name'       => __('Mileage', 'inventor'),
            'id'         => INVENTOR_LISTING_PREFIX . 'car_mileage',
            'type'       => 'text',
            'attributes' => [
                'type'    => 'number',
                'pattern' => '\d*',
            ],
            'default'    => Inventor_Submission::get_submission_field_value(
                INVENTOR_LISTING_PREFIX . 'car_details',
                INVENTOR_LISTING_PREFIX . 'car_mileage'
            ),
            ]
        );
        $cmb->add_field(
            [
            'name'    => __('Condition', 'inventor'),
            'id'      => INVENTOR_LISTING_PREFIX . 'car_condition',
            'type'    => 'select',
            'options' => [
                'NEW'  => __('new', 'inventor'),
                'USED' => __('used', 'inventor'),
            ],
            'default' => Inventor_Submission::get_submission_field_value(
                INVENTOR_LISTING_PREFIX . 'car_details',
                INVENTOR_LISTING_PREFIX . 'car_condition'
            ),
            ]
        );
        $cmb->add_field(
            [
            'name'    => __('Leasing available', 'inventor'),
            'id'      => INVENTOR_LISTING_PREFIX . 'car_leasing',
            'type'    => 'checkbox',
            'default' => Inventor_Submission::get_submission_field_value(
                INVENTOR_LISTING_PREFIX . 'car_details',
                INVENTOR_LISTING_PREFIX . 'car_leasing'
            ),
            ]
        );
        // Color
        $cmb = new_cmb2_box(
            [
            'id'           => INVENTOR_LISTING_PREFIX . 'car_color',
            'title'        => __('Color', 'inventor'),
            'object_types' => ['car'],
            'context'      => 'normal',
            'priority'     => 'high',
            ]
        );
        $cmb->add_field(
            [
            'name'     => __('Interior color', 'inventor'),
            'id'       => INVENTOR_LISTING_PREFIX . 'car_color_interior',
            'type'     => 'taxonomy_multicheck_hierarchy',
            'taxonomy' => 'colors',
            'default'  => Inventor_Submission::get_submission_field_value(
                INVENTOR_LISTING_PREFIX . 'car_color',
                INVENTOR_LISTING_PREFIX . 'car_color_interior'
            ),
            ]
        );
        $cmb->add_field(
            [
            'name'     => __('Exterior color', 'inventor'),
            'id'       => INVENTOR_LISTING_PREFIX . 'car_color_exterior',
            'type'     => 'taxonomy_multicheck_hierarchy',
            'taxonomy' => 'colors',
            'default'  => Inventor_Submission::get_submission_field_value(
                INVENTOR_LISTING_PREFIX . 'car_color',
                INVENTOR_LISTING_PREFIX . 'car_color_exterior'
            ),
            ]
        );
        Inventor_Post_Types::add_metabox(
            'car',
            ['banner', 'gallery', 'video', 'price', 'contact', 'social', 'flags', 'location', 'listing_category']
        );
    }
}

    Inventor_Post_Type_Car::init();

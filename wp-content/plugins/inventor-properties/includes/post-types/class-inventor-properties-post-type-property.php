<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Properties_Post_Type_Property.
     * @class  Inventor_Properties_Post_Type_Property
     * @author Pragmatic Mates
     */
    class Inventor_Properties_Post_Type_Property
    {
        /**
         * Set default data for field.
         *
         * @param $data
         * @param $object_id
         * @param $a
         * @param $field
         *
         * @return mixed
         */
        public static function set_default_value($data, $object_id, $a, $field)
        {
            if ( ! empty($field->args['custom_value'])) {
                return $field->args['custom_value'];
            }

            return $data;
        }

        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition'], 11);
            add_action('cmb2_init', [__CLASS__, 'fields']);
            add_filter('inventor_shop_allowed_listing_post_types', [__CLASS__, 'allowed_purchasing']);
            add_filter('inventor_claims_allowed_listing_post_types', [__CLASS__, 'allowed_claiming']);
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
            $post_types[] = 'property';

            return $post_types;
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
            $post_types[] = 'property';

            return $post_types;
        }

        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name'               => __('Properties', 'inventor-properties'),
                'singular_name'      => __('Property', 'inventor-properties'),
                'add_new'            => __('Add New Property', 'inventor-properties'),
                'add_new_item'       => __('Add New Property', 'inventor-properties'),
                'edit_item'          => __('Edit Property', 'inventor-properties'),
                'new_item'           => __('New Property', 'inventor-properties'),
                'all_items'          => __('Properties', 'inventor-properties'),
                'view_item'          => __('View Property', 'inventor-properties'),
                'search_items'       => __('Search Property', 'inventor-properties'),
                'not_found'          => __('No Properties found', 'inventor-properties'),
                'not_found_in_trash' => __('No Properties Found in Trash', 'inventor-properties'),
                'parent_item_colon'  => '',
                'menu_name'          => __('Properties', 'inventor-properties'),
            ];
            register_post_type('property', [
                'labels'       => $labels,
                'show_in_menu' => 'listings',
                'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
                'has_archive'  => true,
                'rewrite'      => ['slug' => _x('properties', 'URL slug', 'inventor-properties')],
                'public'       => true,
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
            if ( ! is_admin()) {
                Inventor_Post_Types::add_metabox('property', ['general']);
            }
            // Details
            $details = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'details',
                'title'        => __('Details', 'inventor-properties'),
                'object_types' => ['property'],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $details->add_field([
                'name'     => __('Property type', 'inventor-properties'),
                'id'       => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'type',
                'type'     => 'taxonomy_select',
                'taxonomy' => 'property_types',
            ]);
            $details->add_field([
                'name' => __('Reference', 'inventor-properties'),
                'id'   => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'reference',
                'type' => 'text_small',
            ]);
            $details->add_field([
                'name'       => __('Year built', 'inventor-properties'),
                'id'         => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'year_built',
                'type'       => 'text_small',
                'attributes' => [
                    'type'    => 'number',
                    'pattern' => '\d*',
                    'min'     => 0,
                ],
            ]);
            $details->add_field([
                'name'    => __('Contract type', 'inventor-properties'),
                'id'      => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'contract_type',
                'type'    => 'select',
                'options' => [
                    ''     => '',
                    'RENT' => __('Rent', 'inventor-properties'),
                    'SALE' => __('Sale', 'inventor-properties'),
                ],
            ]);
            // Attributes
            $attributes = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'attributes',
                'title'        => __('Attributes', 'inventor-properties'),
                'object_types' => ['property'],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $attributes->add_field([
                'name'       => __('Rooms', 'inventor-properties'),
                'id'         => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'rooms',
                'type'       => 'text_small',
                'attributes' => [
                    'type'    => 'number',
                    'pattern' => '\d*',
                    'min'     => 0,
                ],
            ]);
            $attributes->add_field([
                'name'       => __('Beds', 'inventor-properties'),
                'id'         => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'beds',
                'type'       => 'text_small',
                'attributes' => [
                    'type'    => 'number',
                    'pattern' => '\d*',
                    'min'     => 0,
                ],
            ]);
            $attributes->add_field([
                'name'       => __('Baths', 'inventor-properties'),
                'id'         => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'baths',
                'type'       => 'text_small',
                'attributes' => [
                    'type'    => 'number',
                    'pattern' => '\d*',
                    'min'     => 0,
                ],
            ]);
            $attributes->add_field([
                'name'       => __('Garages', 'inventor-properties'),
                'id'         => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'garages',
                'type'       => 'text_small',
                'attributes' => [
                    'type'    => 'number',
                    'pattern' => '\d*',
                    'min'     => 0,
                ],
            ]);
            $attributes->add_field([
                'name'       => __('Parking lots', 'inventor-properties'),
                'id'         => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'parking_lots',
                'type'       => 'text_small',
                'attributes' => [
                    'type'    => 'number',
                    'pattern' => '\d*',
                    'min'     => 0,
                ],
            ]);
            $attributes->add_field([
                'name'        => __('Home area', 'inventor-properties'),
                'id'          => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'home_area',
                'description' => sprintf(__('In %s. (Enter value without unit)', 'inventor-properties'),
                    get_theme_mod('inventor_measurement_area_unit', 'sqft')),
                'type'        => 'text_small',
                'attributes'  => [
                    'type'    => 'number',
                    'step'    => 'any',
                    'min'     => 0,
                    'pattern' => '\d*(\.\d*)?',
                ],
            ]);
            $attributes->add_field([
                'name'        => __('Lot area', 'inventor-properties'),
                'id'          => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'lot_area',
                'description' => sprintf(__('In %s. (Enter value without unit)', 'inventor-properties'),
                    get_theme_mod('inventor_measurement_area_unit', 'sqft')),
                'type'        => 'text_small',
                'attributes'  => [
                    'type'    => 'number',
                    'step'    => 'any',
                    'min'     => 0,
                    'pattern' => '\d*(\.\d*)?',
                ],
            ]);
            $attributes->add_field([
                'name'        => __('Lot dimensions', 'inventor-properties'),
                'id'          => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'lot_dimensions',
                'type'        => 'text',
                'description' => __('e.g. 20x30, 20x30x40, 20x30x40x50', 'inventor-properties'),
            ]);
            $attributes->add_field([
                'name'     => __('Amenities', 'inventor-properties'),
                'id'       => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'amenities',
                'type'     => 'taxonomy_multicheck_hierarchy',
                'taxonomy' => 'property_amenities',
                'skip'     => true,
            ]);
            Inventor_Post_Types::add_metabox('property',
                ['banner', 'gallery', 'video', 'location', 'price', 'contact', 'flags', 'listing_category']);
            // Valuation
            $valuation_box_id   = INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'valuation_box';
            $valuation_group_id = INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'valuation';
            if ( ! is_admin()) {
                add_filter('cmb2_override_' . $valuation_group_id . '_group_meta_value',
                    [__CLASS__, 'set_default_value'], 0, 4);
            }
            $valuation_default = Inventor_Submission::get_submission_field_value($valuation_box_id,
                $valuation_group_id);
            $valuation_box     = new_cmb2_box([
                'id'           => $valuation_box_id,
                'title'        => __('Valuation', 'inventor-properties'),
                'object_types' => ['property'],
                'context'      => 'normal',
                'priority'     => 'high',
                'show_names'   => true,
                'skip'         => true,
                'fields'       => [
                    // group
                    [
                        'id'           => $valuation_group_id,
                        'type'         => 'group',
                        'custom_value' => $valuation_default,
                        'post_type'    => 'property',
                        'options'      => [
                            'group_title'   => __('Valuation', 'inventor-properties'),
                            'add_button'    => __('Add Another Valuation', 'inventor-properties'),
                            'remove_button' => __('Remove Valuation', 'inventor-properties'),
                        ],
                        'fields'       => [
                            // group fields
                            [
                                'id'           => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'valuation_key',
                                'name'         => __('Key', 'inventor-properties'),
                                'type'         => 'text',
                                'custom_value' => $valuation_default,
                            ],
                            [
                                'id'           => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'valuation_value',
                                'name'         => __('Value', 'inventor-properties'),
                                'type'         => 'text',
                                'custom_value' => $valuation_default,
                            ],
                        ],
                    ],
                ],
            ]);
            // Public facilities
            $public_facilities_box_id   = INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'public_facilities_box';
            $public_facilities_group_id = INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'public_facilities';
            if ( ! is_admin()) {
                add_filter('cmb2_override_' . $public_facilities_group_id . '_group_meta_value',
                    [__CLASS__, 'set_default_value'], 0, 4);
            }
            $facilities_default = Inventor_Submission::get_submission_field_value($public_facilities_box_id,
                $public_facilities_group_id);
            $cmb                = new_cmb2_box([
                'id'           => $public_facilities_box_id,
                'title'        => __('Public facilities', 'inventor-properties'),
                'object_types' => ['property'],
                'context'      => 'normal',
                'priority'     => 'high',
                'show_names'   => true,
                'skip'         => true,
                'fields'       => [
                    // group
                    [
                        'id'           => $public_facilities_group_id,
                        'type'         => 'group',
                        'post_type'    => 'property',
                        'custom_value' => $facilities_default,
                        'options'      => [
                            'group_title'   => __('Public Facility', 'inventor-properties'),
                            'add_button'    => __('Add Another Public Facility', 'inventor-properties'),
                            'remove_button' => __('Remove Public Facility', 'inventor-properties'),
                        ],
                        'fields'       => [
                            // group fields
                            [
                                'id'           => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'public_facilities_key',
                                'name'         => __('Key', 'inventor-properties'),
                                'type'         => 'text',
                                'custom_value' => $facilities_default,
                            ],
                            [
                                'id'           => INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'public_facilities_value',
                                'name'         => __('Value', 'inventor-properties'),
                                'type'         => 'text',
                                'custom_value' => $facilities_default,
                            ],
                        ],
                    ],
                ],
            ]);
        }
    }

    Inventor_Properties_Post_Type_Property::init();

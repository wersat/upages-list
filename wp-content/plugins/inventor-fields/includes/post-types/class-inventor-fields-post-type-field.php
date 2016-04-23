<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Fields_Post_Type_Field.
     * @class  Inventor_Fields_Post_Type_Field
     * @author Pragmatic Mates
     */
    class Inventor_Fields_Post_Type_Field
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            # has to be executed later than Inventor_Fields_Post_Type_Metabox::add_metaboxes_to_post_types()
            add_action('cmb2_init', [__CLASS__, 'fields'], 14);
            add_action('cmb2_init', [__CLASS__, 'add_fields_to_metaboxes'], 15);
        }

        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name'               => __('Fields', 'inventor-fields'),
                'singular_name'      => __('Field', 'inventor-fields'),
                'add_new'            => __('Add New Field', 'inventor-fields'),
                'add_new_item'       => __('Add New Field', 'inventor-fields'),
                'edit_item'          => __('Edit Field', 'inventor-fields'),
                'new_item'           => __('New Field', 'inventor-fields'),
                'all_items'          => __('Fields', 'inventor-fields'),
                'view_item'          => __('View Field', 'inventor-fields'),
                'search_items'       => __('Search Field', 'inventor-fields'),
                'not_found'          => __('No Fields found', 'inventor-fields'),
                'not_found_in_trash' => __('No Fields found in Trash', 'inventor-fields'),
                'parent_item_colon'  => '',
                'menu_name'          => __('Fields', 'inventor-fields')
            ];
            register_post_type('field', [
                'labels'              => $labels,
                'supports'            => ['title'],
                'public'              => false,
                'exclude_from_search' => true,
                'publicly_queryable'  => false,
                'show_in_nav_menus'   => false,
                'show_ui'             => true,
                'show_in_menu'        => 'inventor'
            ]);
        }

        /**
         * Defines custom fields.
         */
        public static function fields()
        {
            // Settings
            $settings = new_cmb2_box([
                'id'           => INVENTOR_FIELDS_FIELD_PREFIX . 'settings',
                'title'        => __('Settings', 'inventor-fields'),
                'object_types' => ['field'],
                'context'      => 'normal',
                'priority'     => 'high'
            ]);
            // Identifier
            $settings->add_field([
                'name'        => __('Identifier', 'inventor-fields'),
                'description' => __('Unique identifier', 'inventor-fields'),
                'id'          => INVENTOR_FIELDS_FIELD_PREFIX . 'identifier',
                'type'        => 'text',
                'attributes'  => [
                    'required' => 'required'
                ]
            ]);
            // Required
            $settings->add_field([
                'name' => __('Required', 'inventor-fields'),
                'id'   => INVENTOR_FIELDS_FIELD_PREFIX . 'required',
                'type' => 'checkbox'
            ]);
            // Skip
            $settings->add_field([
                'name'        => __('Skip', 'inventor-fields'),
                'description' => __('From attributes section on listing detail', 'inventor-fields'),
                'id'          => INVENTOR_FIELDS_FIELD_PREFIX . 'skip',
                'type'        => 'checkbox'
            ]);
            // Description
            $settings->add_field([
                'name' => __('Description', 'inventor-fields'),
                'id'   => INVENTOR_FIELDS_FIELD_PREFIX . 'description',
                'type' => 'text'
            ]);
            // Type
            $settings->add_field([
                'name'    => __('Type', 'inventor-fields'),
                'id'      => INVENTOR_FIELDS_FIELD_PREFIX . 'type',
                'type'    => 'select',
                'options' => [
                    //                'title'                             => __( 'Title (A large title (useful for breaking up sections of fields in metabox).', 'inventor-fields' ),
                    'text'                             => __('Text', 'inventor-fields'),
                    'text_small'                       => __('Small text', 'inventor-fields'),
                    'text_medium'                      => __('Medium text', 'inventor-fields'),
                    'text_email'                       => __('Email address', 'inventor-fields'),
                    'text_url'                         => __('URL', 'inventor-fields'),
                    'text_money'                       => __('Money', 'inventor-fields'),
                    'textarea'                         => __('Textarea', 'inventor-fields'),
                    'textarea_small'                   => __('Smaller textarea', 'inventor-fields'),
                    'textarea_code'                    => __('Code textarea', 'inventor-fields'),
                    'wysiwyg'                          => __('TinyMCE wysiwyg editor', 'inventor-fields'),
                    'text_time'                        => __('Time picker', 'inventor-fields'),
                    'select_timezone'                  => __('Timezone', 'inventor-fields'),
                    'text_date_timestamp'              => __('Date', 'inventor-fields'),
                    'text_datetime_timestamp'          => __('Date and time', 'inventor-fields'),
                    'text_datetime_timestamp_timezone' => __('Date, time and timezone', 'inventor-fields'),
                    //                'hidden'                            => __( 'Hidden input type', 'inventor-fields' ),
                    'colorpicker'                      => __('Colorpicker', 'inventor-fields'),
                    'checkbox'                         => __('Checkbox', 'inventor-fields'),
                    'multicheck'                       => __('Multicheck', 'inventor-fields'),
                    'multicheck_inline'                => __('Multicheck inline', 'inventor-fields'),
                    'radio'                            => __('Radio', 'inventor-fields'),
                    'radio_inline'                     => __('Radio inline', 'inventor-fields'),
                    'select'                           => __('Select', 'inventor-fields'),
                    'file'                             => __('File uploader', 'inventor-fields'),
                    'file_list'                        => __('Files uploader', 'inventor-fields'),
                    'oembed'                           => __('Embed media', 'inventor-fields')
                ]
            ]);
            // Value Type
            $settings->add_field([
                'name'    => __('Value Type', 'inventor-fields'),
                'id'      => INVENTOR_FIELDS_FIELD_PREFIX . 'value_type',
                'type'    => 'select',
                'options' => [
                    'characters'       => __('Characters', 'inventor-fields'),
                    'integer'          => __('Integer', 'inventor-fields'),
                    'positive_integer' => __('Positive integer', 'inventor-fields'),
                    'decimal'          => __('Decimal', 'inventor-fields'),
                    'positive_decimal' => __('Positive decimal', 'inventor-fields')
                ]
            ]);
            // Options
            $settings->add_field([
                'name'        => __('Options', 'inventor-fields'),
                'id'          => INVENTOR_FIELDS_FIELD_PREFIX . 'options',
                'type'        => 'textarea',
                'description' => __('Comma separated options if type support choices')
            ]);
            // Metaboxes
            $meta_boxes = CMB2_Boxes::get_all();
            $boxes      = [];
            foreach ($meta_boxes as $meta_box) {
                $types = $meta_box->meta_box['object_types'];
                if (is_array($types) && ! empty($types[0])
                    && in_array($types[0], Inventor_Post_Types::get_listing_post_types())
                ) {
                    $post_type                        = get_post_type_object($types[0]);
                    $boxes[$meta_box->meta_box['id']] = sprintf('<strong>%s</strong>: %s',
                        $post_type->labels->singular_name, $meta_box->meta_box['title']);
                }
            }
            ksort($boxes);
            $settings->add_field([
                'name'    => __('Metabox', 'inventor-fields'),
                'id'      => INVENTOR_FIELDS_FIELD_PREFIX . 'metabox',
                'type'    => 'multicheck',
                'options' => $boxes
            ]);
        }

        /**
         * Adds defined fields into metaboxes.
         */
        public static function add_fields_to_metaboxes()
        {
            $query = new WP_Query([
                'post_type'      => 'field',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            ]);
            foreach ($query->posts as $field) {
                $metaboxes = get_post_meta($field->ID, INVENTOR_FIELDS_FIELD_PREFIX . 'metabox', true);
                if ( ! is_array($metaboxes)) {
                    continue;
                }
                $identifier     = get_post_meta($field->ID, INVENTOR_FIELDS_FIELD_PREFIX . 'identifier', true);
                $type           = get_post_meta($field->ID, INVENTOR_FIELDS_FIELD_PREFIX . 'type', true);
                $value_type     = get_post_meta($field->ID, INVENTOR_FIELDS_FIELD_PREFIX . 'value_type', true);
                $description    = get_post_meta($field->ID, INVENTOR_FIELDS_FIELD_PREFIX . 'description', true);
                $required       = get_post_meta($field->ID, INVENTOR_FIELDS_FIELD_PREFIX . 'required', true);
                $skip           = get_post_meta($field->ID, INVENTOR_FIELDS_FIELD_PREFIX . 'skip', true);
                $options        = get_post_meta($field->ID, INVENTOR_FIELDS_FIELD_PREFIX . 'options', true);
                $options        = explode(',', $options);
                $options        = array_combine($options, $options);
                $title          = get_the_title($field->ID);
                $field_settings = [
                    'name'        => $title,
                    'type'        => $type,
                    'description' => $description,
                    'options'     => $options,
                    'skip'        => $skip
                ];
                $attributes     = [];
                $before_field   = null;
                if ( ! empty($required)) {
                    $attributes['required'] = 'required';
                }
                if (in_array($type, ['text', 'text_small', 'text_medium'])) {
                    if ($value_type == 'integer') {
                        $attributes['type']    = 'number';
                        $attributes['pattern'] = '\d*';
                    }
                    if ($value_type == 'decimal') {
                        $attributes['type']    = 'number';
                        $attributes['step']    = 'any';
                        $attributes['pattern'] = '\d*(\.\d*)?';
                    }
                    if ($value_type == 'positive_integer') {
                        $attributes['type']    = 'number';
                        $attributes['min']     = 0;
                        $attributes['pattern'] = '\d*';
                    }
                    if ($value_type == 'positive_decimal') {
                        $attributes['type']    = 'number';
                        $attributes['step']    = 'any';
                        $attributes['min']     = 0;
                        $attributes['pattern'] = '\d*(\.\d*)?';
                    }
                }
                if ('text_money' == $type) {
                    $attributes['type']                = 'number';
                    $attributes['step']                = 'any';
                    $attributes['min']                 = 0;
                    $attributes['pattern']             = '\d*(\.\d*)?';
                    $field_settings['before_field']    = Inventor_Price::default_currency_symbol();
                    $field_settings['sanitization_cb'] = false;
                }
                if ('opening_hours' == $type) {
                    $field_settings['escape_cb'] = 'cmb2_escape_opening_hours_value';
                }
                $field_settings['attributes'] = $attributes;
                foreach ($metaboxes as $metabox_id) {
                    $metabox = CMB2_Boxes::get($metabox_id);
                    if (empty($metabox)) {
                        continue;
                    }
                    $object_types              = $metabox->meta_box['object_types'];
                    $listing_type_prefix       = count($object_types) == 1 ? $object_types[0] . '_' : '';
                    $field_id                  = INVENTOR_LISTING_PREFIX . $listing_type_prefix . $identifier;
                    $field_settings['id']      = $field_id;
                    $field_settings['default'] = Inventor_Submission::get_submission_field_value($metabox_id,
                        $field_id);
                    $metabox->add_field($field_settings);
                }
            }
        }
    }

    Inventor_Fields_Post_Type_Field::init();

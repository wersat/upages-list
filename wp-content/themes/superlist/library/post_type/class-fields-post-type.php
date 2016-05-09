<?php
    namespace Upages_Post_Type;
    
    use Upages_Objects\Custom_Post_Type;

    /**
     * Class Faq_Post_Type
     *
     * @package Upages_Post_Type
     */
	 
class Fields_Post_Type
{
			/**
				* @type
				*/
			public $post_type;
			/**
				* @type string
				*/
			public $post_type_name = 'Fields';


            public function __construct()
            {
                $this->constants();
                $this->includes();
                $this->load_plugin_textdomain();
            }
			
			public $post_type_option
		            =[
                    'supports'            => ['title'],
                    'exclude_from_search' => true,
                    'publicly_queryable'  => false,
                    'show_in_nav_menus'   => false,
                    'show_ui'             => true,
                    'show_in_menu'        => class_exists('Inventor_Admin_Menu') ? 'inventor' : true
	                 ]

       

        /**
		посттайп
		*/
        /**
         * Initialize custom post type.
         */
        public function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            add_action('init', [__CLASS__, 'register_listing_types'], 11);
            add_action('transition_post_status', [__CLASS__, 'listing_type_transition'], 10, 3);
            add_action('cmb2_init', [__CLASS__, 'fields'], 11);
            add_action('cmb2_init', [__CLASS__, 'add_metaboxes_to_listing_type'], 12);
            add_filter('inventor_shop_allowed_listing_post_types', [__CLASS__, 'allowed_purchasing']);
            add_filter('inventor_claims_allowed_listing_post_types', [__CLASS__, 'allowed_claiming']);
            add_filter('inventor_listing_type_supported', [__CLASS__, 'listing_type_supported'], 11, 2);
        }

        /**
         * Checks if listing post type is supported.
         *
         * @param bool   $supported
         * @param string $post_type
         *
         * @return bool
         */
        public function listing_type_supported($supported, $post_type)
        {
            // Leave supported post types untouched
            if ($supported) {
                return $supported;
            }
            // Check if post type is custom defined
            $query = new WP_Query([
                'post_type'      => 'listing_type',
                'posts_per_page' => -1,
                'post_status'    => 'any',
                'meta_query'     => [
                    [
                        'key'   => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'identifier',
                        'value' => $post_type
                    ]
                ]
            ]);
            // All custom listing types defined via manager are supported by default
            $supported = count($query->posts) > 0;

            return $supported;
        }

        /**
         * Allow post type when listing type is created.
         *
         * @param $new_status
         * @param $old_status
         * @param $post
         */
        public function listing_type_transition($new_status, $old_status, $post)
        {
            $post_type = get_post_type($post);
            if ($post_type != 'listing_type') {
                return;
            }
            if ($new_status != 'publish'
                || ! in_array($old_status, ['new', 'auto-draft', 'draft', 'pending', 'future'])
            ) {
                return;
            }
            $post_types_all       = Inventor_Post_Types::get_listing_post_types();
            $post_types_supported = get_theme_mod('inventor_general_post_types', $post_types_all);
            $identifier = get_post_meta($post->ID, INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'identifier', true);
            if (empty($identifier) && ! empty($_POST['listing_type_identifier'])) {
                $identifier = $_POST['listing_type_identifier'];
            }
            if ( ! empty($identifier)) {
                if ( ! in_array($identifier, $post_types_supported)) {
                    $post_types_supported[] = $identifier;
                }
            }
            set_theme_mod('inventor_general_post_types', $post_types_supported);
        }

        /**
         * Defines if post type can be claimed.
         *
         * @param array $post_types
         *
         * @return array
         */
        public function allowed_claiming($post_types)
        {
            $query = new WP_Query([
                'post_type'      => 'listing_type',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'meta_query'     => [
                    [
                        'key'   => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'allowed_claiming',
                        'value' => 'on'
                    ]
                ]
            ]);
            foreach ($query->posts as $listing_type) {
                $identifier   = get_post_meta($listing_type->ID, INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'identifier',
                    true);
                $post_types[] = $identifier;
            }

            return $post_types;
        }

        /**
         * Defines if post type can be purchased.
         *
         * @param array $post_types
         *
         * @return array
         */
        public function allowed_purchasing($post_types)
        {
            $query = new WP_Query([
                'post_type'      => 'listing_type',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'meta_query'     => [
                    [
                        'key'   => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'allowed_purchasing',
                        'value' => 'on'
                    ]
                ]
            ]);
            foreach ($query->posts as $listing_type) {
                $identifier   = get_post_meta($listing_type->ID, INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'identifier',
                    true);
                $post_types[] = $identifier;
            }

            return $post_types;
        }

        /**
         * Custom post type definition.
         */
        public function definition()
        {
            $labels = [
                'name'               => __('Listing Types', 'inventor-fields'),
                'singular_name'      => __('Listing Type', 'inventor-fields'),
                'add_new_item'       => __('Add New Listing Type', 'inventor-fields'),
                'add_new'            => __('Add New Listing Type', 'inventor-fields'),
                'edit_item'          => __('Edit Listing Type', 'inventor-fields'),
                'new_item'           => __('New Listing Type', 'inventor-fields'),
                'all_items'          => __('Listing Types', 'inventor-fields'),
                'view_item'          => __('View Listing Type', 'inventor-fields'),
                'search_items'       => __('Search Listing Type', 'inventor-fields'),
                'not_found'          => __('No Listing Types found', 'inventor-fields'),
                'not_found_in_trash' => __('No Listing Types found in Trash', 'inventor-fields'),
                'parent_item_colon'  => '',
                'menu_name'          => __('Listing Types', 'inventor-fields')
            ];
            register_post_type('listing_type', [
                    'labels'              => $labels,
                    'supports'            => ['title'],
                    'public'              => false,
                    'exclude_from_search' => true,
                    'publicly_queryable'  => false,
                    'show_in_nav_menus'   => false,
                    'show_ui'             => true,
                    'show_in_menu'        => class_exists('Inventor_Admin_Menu') ? 'inventor' : true
                ]);
        }

        /**
         * Defines custom fields.
         */
        public function fields()
        {
            // Settings
            $settings = new_cmb2_box([
                'id'           => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'settings',
                'title'        => __('Settings', 'inventor-fields'),
                'object_types' => ['listing_type'],
                'context'      => 'normal',
                'priority'     => 'high'
            ]);
            // Singular name
            $settings->add_field([
                'name'        => __('Singular name', 'inventor-fields'),
                'description' => __('Name for one object of this post type (Set title to plural name).',
                    'inventor-fields'),
                'id'          => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'singular_name',
                'type'        => 'text',
                'attributes'  => [
                    'required' => 'required'
                ]
            ]);
            // Identifier
            $settings->add_field([
                'name'        => __('Identifier', 'inventor-fields'),
                'description' => __('Unique identifier (Slug with lowercase characters).', 'inventor-fields'),
                'id'          => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'identifier',
                'type'        => 'text',
                'attributes'  => [
                    'required' => 'required',
                    'pattern'  => '[a-z0-9]+(?:-[a-z0-9]+)*'
                ]
            ]);
            // URL Slug
            $settings->add_field([
                'name'        => __('URL Slug', 'inventor-fields'),
                'description' => __("Don't forget to resave permalinks in Settings > Permalinks.", 'inventor-fields'),
                'id'          => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'slug',
                'type'        => 'text',
                'attributes'  => [
                    'required' => 'required'
                ]
            ]);
            // Allowed purchasing
            $settings->add_field([
                'name' => __('Allowed purchasing', 'inventor-fields'),
                'id'   => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'allowed_purchasing',
                'type' => 'checkbox'
            ]);
            // Allowed claiming
            $settings->add_field([
                'name' => __('Allowed claiming', 'inventor-fields'),
                'id'   => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'allowed_claiming',
                'type' => 'checkbox'
            ]);
            // Predefined metaboxes
            $settings->add_field([
                'name'        => __('Predefined metaboxes', 'inventor-fields'),
                'description' => __('For custom metaboxes and fields, go to Inventor > Metaboxes or Inventor > Fields',
                    'inventor-fields'),
                'id'          => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'metabox',
                'type'        => 'multicheck',
                'options'     => [  # TODO: use filter
                    //                'general'                   => __( 'General: title, description, featured image', 'inventor-fields'),
                    'branding'               => __('Branding: slogan, brand color, logo', 'inventor-fields'),
                    'banner'                 => __('Banner', 'inventor-fields'),
                    'gallery'                => __('Gallery', 'inventor-fields'),
                    'video'                  => __('Video', 'inventor-fields'),
                    'price'                  => __('Price', 'inventor-fields'),
                    'color'                  => __('Color', 'inventor-fields'),
                    'listing_category'       => __('Listing category', 'inventor-fields'),
                    'location'               => __('Location', 'inventor-fields'),
                    'contact'                => __('Contact: email, phone, website, address', 'inventor-fields'),
                    'social'                 => __('Social connection', 'inventor-fields'),
                    'opening_hours'          => __('Opening hours', 'inventor-fields'),
                    'flags'                  => __('Flags: featured, reduced, verified', 'inventor-fields'),
                    'date'                   => __('Date', 'inventor-fields'),
                    'time'                   => __('Time', 'inventor-fields'),
                    'date_interval'          => __('Date interval: date from, date to', 'inventor-fields'),
                    'datetime_interval'      => __('Datetime interval: date and time from, date and time to',
                        'inventor-fields'),
                    'time_interval'          => __('Time interval: time from, time to', 'inventor-fields'),
                    'date_and_time_interval' => __('Date and time interval: date, time from, time to',
                        'inventor-fields')
                ]
            ]);
        }

        /**
         * Registers custom listing post types.
         */
        public function register_listing_types()
        {
            $query = new WP_Query([
                'post_type'      => 'listing_type',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            ]);
            foreach ($query->posts as $listing_type) {
                $plural_name   = get_the_title($listing_type->ID);
                $identifier    = get_post_meta($listing_type->ID, INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'identifier',
                    true);
                $slug          = get_post_meta($listing_type->ID, INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'slug', true);
                $singular_name = get_post_meta($listing_type->ID, INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'singular_name',
                    true);
                $labels = [
                    'name'               => $plural_name,
                    'singular_name'      => $singular_name,
                    'add_new_item'       => sprintf(__('Add New %s', 'inventor-fields'), $singular_name),
                    'add_new'            => sprintf(__('Add New %s', 'inventor-fields'), $singular_name),
                    'edit_item'          => sprintf(__('Edit %s', 'inventor-fields'), $singular_name),
                    'new_item'           => sprintf(__('New %s', 'inventor-fields'), $singular_name),
                    'all_items'          => $plural_name,
                    'view_item'          => sprintf(__('View %s', 'inventor-fields'), $singular_name),
                    'search_items'       => sprintf(__('Search %s', 'inventor-fields'), $plural_name),
                    'not_found'          => sprintf(__('No %s found', 'inventor-fields'), $plural_name),
                    'not_found_in_trash' => sprintf(__('No %s found in Trash', 'inventor-fields'), $plural_name),
                    'parent_item_colon'  => '',
                    'menu_name'          => $plural_name
                ];
                register_post_type($identifier, [
                        'labels'       => $labels,
                        'show_in_menu' => 'listings',
                        'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
                        'has_archive'  => true,
                        'rewrite'      => ['slug' => $slug],
                        'public'       => true,
                        'show_ui'      => true,
                        'categories'   => []
                    ]);
            }
        }

        /**
         * Adds predefined metaboxes into custom listing post types.
         */
        public function add_metaboxes_to_listing_type()
        {
            $query = new WP_Query([
                'post_type'      => 'listing_type',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            ]);
            foreach ($query->posts as $listing_type) {
                $identifier = get_post_meta($listing_type->ID, INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'identifier',
                    true);
                $metaboxes  = get_post_meta($listing_type->ID, INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'metabox', true);
                if ($metaboxes == '') {
                    $metaboxes = [];
                }
                if ( ! is_array($metaboxes) || empty($identifier)) {
                    continue;
                }
                $metaboxes = array_merge(['general'], $metaboxes);
                Inventor_Post_Types::add_metabox($identifier, $metaboxes);
            }
        }
		/**
		метабокс
		*/
		
		 public function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            add_action('cmb2_init', [__CLASS__, 'fields'], 13);
            add_action('cmb2_init', [__CLASS__, 'add_metaboxes_to_listing_types'], 14);
        }

        /**
         * Custom post type definition.
         */
        public function definition()
        {
            $labels = [
                'name'               => __('Metaboxes', 'inventor-fields'),
                'singular_name'      => __('Metabox', 'inventor-fields'),
                'add_new_item'       => __('Add New Metabox', 'inventor-fields'),
                'add_new'            => __('Add New Metabox', 'inventor-fields'),
                'edit_item'          => __('Edit Metabox', 'inventor-fields'),
                'new_item'           => __('New Metabox', 'inventor-fields'),
                'all_items'          => __('Metaboxes', 'inventor-fields'),
                'view_item'          => __('View Metabox', 'inventor-fields'),
                'search_items'       => __('Search Metabox', 'inventor-fields'),
                'not_found'          => __('No Metaboxes found', 'inventor-fields'),
                'not_found_in_trash' => __('No Metaboxes found in Trash', 'inventor-fields'),
                'parent_item_colon'  => '',
                'menu_name'          => __('Metaboxes', 'inventor-fields'),
            ];
            register_post_type('metabox', [
                'labels'              => $labels,
                'supports'            => ['title'],
                'public'              => false,
                'exclude_from_search' => true,
                'publicly_queryable'  => false,
                'show_in_nav_menus'   => false,
                'show_ui'             => true,
                'show_in_menu'        => class_exists('Inventor_Admin_Menu') ? 'inventor' : true,
            ]);
        }

        /**
         * Defines custom fields.
         */
        public function fields()
        {
            // Settings
            $settings = new_cmb2_box([
                'id'           => INVENTOR_FIELDS_METABOX_PREFIX . 'settings',
                'title'        => __('Settings', 'inventor-fields'),
                'object_types' => ['metabox'],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            // Identifier
            $settings->add_field([
                'name'        => __('Identifier', 'inventor-fields'),
                'description' => __('Unique identifier', 'inventor-fields'),
                'id'          => INVENTOR_FIELDS_METABOX_PREFIX . 'identifier',
                'type'        => 'text',
                'attributes'  => [
                    'required' => 'required',
                ],
            ]);
            // Post Types
            $listings_types = [];
            foreach (Inventor_Post_Types::get_all_listing_post_types() as $post_type) {
                if ($post_type->show_in_menu === 'listings') {
                    $listings_types[$post_type->name] = $post_type->labels->name;
                }
            }
            // Sort alphabetically
            ksort($listings_types);
            $settings->add_field([
                'name'    => __('Listing type', 'inventor-fields'),
                'id'      => INVENTOR_FIELDS_METABOX_PREFIX . 'listing_type',
                'type'    => 'multicheck',
                'options' => $listings_types,
            ]);
        }

        /**
         * Adds defined metaboxes into post types.
         */
        public function add_metaboxes_to_listing_types()
        {
            $query = new WP_Query([
                'post_type'      => 'metabox',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            ]);
            foreach ($query->posts as $metabox) {
                $listing_types = get_post_meta($metabox->ID, INVENTOR_FIELDS_METABOX_PREFIX . 'listing_type', true);
                if ( ! is_array($listing_types)) {
                    continue;
                }
                $identifier = get_post_meta($metabox->ID, INVENTOR_FIELDS_METABOX_PREFIX . 'identifier', true);
                $title      = get_the_title($metabox->ID);
                foreach ($listing_types as $listing_type) {
                    new_cmb2_box([
                        'id'           => INVENTOR_LISTING_PREFIX . $listing_type . '_' . $identifier,
                        'title'        => $title,
                        'object_types' => [$listing_type],
                        'context'      => 'normal',
                        'priority'     => 'high',
                    ]);
                }
            }
        }
		
		/**
		файлед
		*/
		
		public function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            # has to be executed later than Inventor_Fields_Post_Type_Metabox::add_metaboxes_to_post_types()
            add_action('cmb2_init', [__CLASS__, 'fields'], 14);
            add_action('cmb2_init', [__CLASS__, 'add_fields_to_metaboxes'], 15);
        }

        /**
         * Custom post type definition.
         */
        public function definition()
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
        public function fields()
        {
            // Settings
            $settings = new_cmb2_box([
                'id'           => INVENTOR_FIELDS_FIELD_PREFIX . 'settings',
                'title'        => __('Settings', 'inventor-fields-test'),
                'object_types' => ['field'],
                'context'      => 'normal',
                'priority'     => 'high'
            ]);
            // Identifier
            $settings->add_field([
                'name'        => __('Identifier', 'inventor-fields-test'),
                'description' => __('Unique identifier', 'inventor-fields-test'),
                'id'          => INVENTOR_FIELDS_FIELD_PREFIX . 'identifier',
                'type'        => 'text',
                'attributes'  => [
                    'required' => 'required'
                ]
            ]);
            // Required
            $settings->add_field([
                'name' => __('Required', 'inventor-fields-test'),
                'id'   => INVENTOR_FIELDS_FIELD_PREFIX . 'required',
                'type' => 'checkbox'
            ]);
            // Skip
            $settings->add_field([
                'name'        => __('Skip', 'inventor-fields-test'),
                'description' => __('From attributes section on listing detail', 'inventor-fields-test'),
                'id'          => INVENTOR_FIELDS_FIELD_PREFIX . 'skip',
                'type'        => 'checkbox'
            ]);
            // Description
            $settings->add_field([
                'name' => __('Description', 'inventor-fields-test'),
                'id'   => INVENTOR_FIELDS_FIELD_PREFIX . 'description',
                'type' => 'text'
            ]);
            // Type
            $settings->add_field([
                'name'    => __('Type', 'inventor-fields-test'),
                'id'      => INVENTOR_FIELDS_FIELD_PREFIX . 'type',
                'type'    => 'select',
                'options' => [
                    'title'                            => __('Title (A large title (useful for breaking up sections of fields in metabox).', 'inventor-fields-test'),
                    'text'                             => __('Text', 'inventor-fields-test'),
                    'text_small'                       => __('Small text', 'inventor-fields-test'),
                    'text_medium'                      => __('Medium text', 'inventor-fields-test'),
                    'text_email'                       => __('Email address', 'inventor-fields-test'),
                    'text_url'                         => __('URL', 'inventor-fields-test'),
                    'text_money'                       => __('Money', 'inventor-fields-test'),
                    'textarea'                         => __('Textarea', 'inventor-fields-test'),
                    'textarea_small'                   => __('Smaller textarea', 'inventor-fields-test'),
                    'textarea_code'                    => __('Code textarea', 'inventor-fields-test'),
                    'wysiwyg'                          => __('TinyMCE wysiwyg editor', 'inventor-fields-test'),
                    'text_time'                        => __('Time picker', 'inventor-fields-test'),
                    'select_timezone'                  => __('Timezone', 'inventor-fields-test'),
                    'text_date_timestamp'              => __('Date', 'inventor-fields-test'),
                    'text_datetime_timestamp'          => __('Date and time', 'inventor-fields-test'),
                    'text_datetime_timestamp_timezone' => __('Date, time and timezone', 'inventor-fields-test'),
                    'hidden'                            => __( 'Hidden input type', 'inventor-fields' ),
                    'colorpicker'                      => __('Colorpicker', 'inventor-fields-test'),
                    'checkbox'                         => __('Checkbox', 'inventor-fields-test'),
                    'multicheck'                       => __('Multicheck', 'inventor-fields-test'),
                    'multicheck_inline'                => __('Multicheck inline', 'inventor-fields-test'),
                    'radio'                            => __('Radio', 'inventor-fields-test'),
                    'radio_inline'                     => __('Radio inline', 'inventor-fields-test'),
                    'select'                           => __('Select', 'inventor-fields-test'),
                    'file'                             => __('File uploader', 'inventor-fields-test'),
                    'file_list'                        => __('Files uploader', 'inventor-fields-test'),
                    'oembed'                           => __('Embed media', 'inventor-fields-test')
                ]
            ]);
            // Value Type
            $settings->add_field([
                'name'    => __('Value Type', 'inventor-fields-test'),
                'id'      => INVENTOR_FIELDS_FIELD_PREFIX . 'value_type',
                'type'    => 'select',
                'options' => [
                    'characters'       => __('Characters', 'inventor-fields-test'),
                    'integer'          => __('Integer', 'inventor-fields-test'),
                    'positive_integer' => __('Positive integer', 'inventor-fields-test'),
                    'decimal'          => __('Decimal', 'inventor-fields-test'),
                    'positive_decimal' => __('Positive decimal', 'inventor-fields-test')
                ]
            ]);
            // Options
            $settings->add_field([
                'name'        => __('Options', 'inventor-fields-test'),
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
                'name'    => __('Metabox', 'inventor-fields-test'),
                'id'      => INVENTOR_FIELDS_FIELD_PREFIX . 'metabox',
                'type'    => 'multicheck',
                'options' => $boxes
            ]);
        }

        /**
         * Adds defined fields into metaboxes.
         */
        public function add_fields_to_metaboxes()
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
		
		 /**
         кін посттайп
         */
        public function init()
        {
            add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_backend']);
        }

        /**
         * Loads backend files.
         */
        public function enqueue_backend()
        {
            wp_register_script('inventor-fields', plugins_url('/inventor-fields/assets/js/inventor-fields.min.js'),
                ['jquery'], false, true);
            wp_enqueue_script('inventor-fields');
        }

            /**
             * Loads localization files.
             */
         public function load_plugin_textdomain()
         {
             load_plugin_textdomain('inventor-fields', false, plugin_basename(__FILE__) . '/languages');
         }	
}
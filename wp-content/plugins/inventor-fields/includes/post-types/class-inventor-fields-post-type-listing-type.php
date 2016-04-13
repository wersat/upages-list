<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Fields_Post_Type_Listing_Type.
     * @class  Inventor_Fields_Post_Type_Listing_Type
     * @author Pragmatic Mates
     */
    class Inventor_Fields_Post_Type_Listing_Type
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
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
        public static function listing_type_supported($supported, $post_type)
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
                        'value' => $post_type,
                    ],
                ],
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
        public static function listing_type_transition($new_status, $old_status, $post)
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
        public static function allowed_claiming($post_types)
        {
            $query = new WP_Query([
                'post_type'      => 'listing_type',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'meta_query'     => [
                    [
                        'key'   => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'allowed_claiming',
                        'value' => 'on',
                    ],
                ],
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
        public static function allowed_purchasing($post_types)
        {
            $query = new WP_Query([
                'post_type'      => 'listing_type',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'meta_query'     => [
                    [
                        'key'   => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'allowed_purchasing',
                        'value' => 'on',
                    ],
                ],
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
        public static function definition()
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
                'menu_name'          => __('Listing Types', 'inventor-fields'),
            ];
            register_post_type('listing_type', [
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
        public static function fields()
        {
            // Settings
            $settings = new_cmb2_box([
                'id'           => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'settings',
                'title'        => __('Settings', 'inventor-fields'),
                'object_types' => ['listing_type'],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            // Singular name
            $settings->add_field([
                'name'        => __('Singular name', 'inventor-fields'),
                'description' => __('Name for one object of this post type (Set title to plural name).',
                    'inventor-fields'),
                'id'          => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'singular_name',
                'type'        => 'text',
                'attributes'  => [
                    'required' => 'required',
                ],
            ]);
            // Identifier
            $settings->add_field([
                'name'        => __('Identifier', 'inventor-fields'),
                'description' => __('Unique identifier (Slug with lowercase characters).', 'inventor-fields'),
                'id'          => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'identifier',
                'type'        => 'text',
                'attributes'  => [
                    'required' => 'required',
                    'pattern'  => '[a-z0-9]+(?:-[a-z0-9]+)*',
                ],
            ]);
            // URL Slug
            $settings->add_field([
                'name'        => __('URL Slug', 'inventor-fields'),
                'description' => __("Don't forget to resave permalinks in Settings > Permalinks.", 'inventor-fields'),
                'id'          => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'slug',
                'type'        => 'text',
                'attributes'  => [
                    'required' => 'required',
                ],
            ]);
            // Allowed purchasing
            $settings->add_field([
                'name' => __('Allowed purchasing', 'inventor-fields'),
                'id'   => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'allowed_purchasing',
                'type' => 'checkbox',
            ]);
            // Allowed claiming
            $settings->add_field([
                'name' => __('Allowed claiming', 'inventor-fields'),
                'id'   => INVENTOR_FIELDS_LISTING_TYPE_PREFIX . 'allowed_claiming',
                'type' => 'checkbox',
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
                        'inventor-fields'),
                ],
            ]);
        }

        /**
         * Registers custom listing post types.
         */
        public static function register_listing_types()
        {
            $query = new WP_Query([
                'post_type'      => 'listing_type',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
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
                    'menu_name'          => $plural_name,
                ];
                register_post_type($identifier, [
                        'labels'       => $labels,
                        'show_in_menu' => 'listings',
                        'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
                        'has_archive'  => true,
                        'rewrite'      => ['slug' => $slug],
                        'public'       => true,
                        'show_ui'      => true,
                        'show_in_rest'       => true,
                        'categories'   => [],
                    ]);
            }
        }

        /**
         * Adds predefined metaboxes into custom listing post types.
         */
        public static function add_metaboxes_to_listing_type()
        {
            $query = new WP_Query([
                'post_type'      => 'listing_type',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
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
    }

    Inventor_Fields_Post_Type_Listing_Type::init();

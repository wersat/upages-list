<?php
    use Upages_Post_Type\Faq_Post_Type;
    use Upages_Post_Type\Invoice_Post_Type;
    use Upages_Post_Type\Partner_Post_Type;

    spl_autoload_register(function ($widgets) {
        $widgets = ltrim($widgets, '\\');
        if (0 !== stripos($widgets, 'Upages_Post_Type\\')) {
            return;
        }
        $parts_class = explode('\\', $widgets);
        array_shift($parts_class);
        $last_class    = array_pop($parts_class);
        $last_class    = 'class-' . $last_class . '.php';
        $parts_class[] = $last_class;
        $class         = POST_TYPE_DIR . '/' . str_replace('_', '-', strtolower(implode($parts_class, '/')));
        if (file_exists($class)) {
            require_once $class;
        }
    });
    //new Claim_Post_Type();
    new Faq_Post_Type();
    //new Job_Post_Type();
    new Invoice_Post_Type();
    new Partner_Post_Type();

    class Admin_Menu
    {

        public static $listings_types = [];

        /**
         * Admin_Menu constructor.
         */
        public function __construct()
        {
            add_action('init', [__CLASS__, 'set_all_listing_post_types'], 12);
            add_action('admin_menu', [$this, 'title_add_plugin_page']);
        }

        public static function set_all_listing_post_types()
        {
            $post_types = get_post_types([], 'objects');
            if ( ! empty($post_types)) {
                foreach ($post_types as $post_type) {
                    if ($post_type->show_in_menu === 'title') {
                        self::$listings_types[] = get_post_type_object($post_type->name);
                    }
                }
            }

            return self::$listings_types;
        }

        public static function get_listing_post_types($include_abstract = false)
        {
//            $listings_types = [];
//            $post_types     = get_post_types([], 'objects');
//            if ( ! empty($post_types)) {
//                foreach ($post_types as $post_type) {
//                    if ($post_type->show_in_menu === 'title') {
//                        $listings_types[] = $post_type->name;
//                    }
//                }
//            }
//            // Sort alphabetically
//            sort($listings_types);
//            if ($include_abstract) {
//                array_unshift($listings_types, 'listing');
//            }

            return self::$listings_types;
        }

        public function title_add_plugin_page()
        {
            add_menu_page('Title', 'Title', 'edit_posts', 'title', null, 'dashicons-layout', 6);
        }
    }

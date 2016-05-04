<?php
    use Upages_Objects\Custom_Admin_Menu;
    use Upages_Post_Type\Faq_Post_Type;
    use Upages_Post_Type\Invoice_Post_Type;
    use Upages_Post_Type\Listings_Post_Type;
    use Upages_Post_Type\Mail_Templates_Post_Type;
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
    //new Custom_Admin_Menu();
    new Listings_Post_Type();
    new Faq_Post_Type();
    new Invoice_Post_Type();
    new Partner_Post_Type();
    new Mail_Templates_Post_Type();


    class Admin_Menu
    {

        public $listings_types = [];

        /**
         * Admin_Menu constructor.
         */
        public function __construct()
        {
            add_action('custom_menu_order', '__return_true');
            add_filter('menu_order', [$this, 'menu_reorder']);
            add_action('admin_menu', [$this, 'admin_menu']);
            add_action('admin_menu', [$this, 'admin_separator']);
            add_action('admin_menu', [$this, 'counter'], 1);
            add_action('init', [$this, 'set_all_listing_post_types'], 12);
            add_action('admin_menu', [$this, 'title_add_plugin_page']);
        }

        public function set_all_listing_post_types($include_abstract = false)
        {
            $listings_types = [];
            $post_types     = get_post_types([], 'objects');
            if ( ! empty($post_types)) {
                foreach ($post_types as $post_type) {
                    if ($post_type->show_in_menu === 'listings') {
                        $listings_types[] = $post_type->name;
                    }
                }
            }
            // Sort alphabetically
            sort($listings_types);
            if ($include_abstract) {
                array_unshift($listings_types, 'listing');
            }

            return $listings_types;
        }

        public function get_listing_post_types($include_abstract = false)
        {
            $listings_types = [];
            $post_types     = get_post_types([], 'objects');
            if ( ! empty($post_types)) {
                foreach ($post_types as $post_type) {
                    if ($post_type->show_in_menu === 'title') {
                        $listings_types[] = $post_type->name;
                    }
                }
            }
            // Sort alphabetically
            sort($listings_types);
            if ($include_abstract) {
                array_unshift($listings_types, 'listing');
            }
            return $this->listings_types;
        }
        public function menu_reorder($menu_order)
        {
            global $submenu;
            $menu_slugs = ['inventor', 'lexicon', 'listings'];
            if ( ! empty($submenu) && ! empty($menu_slugs) && is_array($menu_slugs)) {
                foreach ($menu_slugs as $slug) {
                    if ( ! empty($submenu[$slug])) {
                        usort($submenu[$slug], [$this, 'sort_alphabet']);
                    }
                }
            }

            return $menu_order;
        }
        public function sort_alphabet($a, $b)
        {
            return strnatcmp($a[0], $b[0]);
        }

        public function counter()
        {
            global $wp_post_types;
            foreach ($wp_post_types as $post_type) {
                if ('listings' == $post_type->show_in_menu) {
                    $name                                    = $post_type->name;
                    $published                               = wp_count_posts($name)->publish;
                    $draft                                   = wp_count_posts($name)->draft;
                    $pending                                 = wp_count_posts($name)->pending;
                    $count                                   = $published + $draft + $pending;
                    $name_with_count
                                                             = sprintf('%s <span class="inventor-menu-count">(%s)</span>',
                        $wp_post_types[$name]->labels->all_items, $count);
                    $wp_post_types[$name]->labels->all_items = $name_with_count;
                }
            }
        }

        public function admin_separator()
        {
            global $menu;
            $menu[49] = ['', 'read', 'separator', '', 'wp-menu-separator'];
        }

        public function admin_menu()
        {
            add_menu_page(__('Inventor', 'inventor'), __('Inventor', 'inventor'), 'edit_posts', 'inventor', null, null,
                '50');
            add_submenu_page('inventor', __('Colors', 'inventor'), __('Colors', 'inventor'), 'edit_posts',
                'edit-tags.php?taxonomy=colors', false);
            add_submenu_page('inventor', __('Locations', 'inventor'), __('Locations', 'inventor'), 'edit_posts',
                'edit-tags.php?taxonomy=locations', false);
            add_submenu_page('inventor', __('Categories', 'inventor'), __('Categories', 'inventor'), 'edit_posts',
                'edit-tags.php?taxonomy=listing_categories', false);
            remove_submenu_page('inventor', 'inventor');
            add_menu_page(__('Listings', 'inventor'), __('Listings', 'inventor'), 'edit_posts', 'listings', null, null,
                '51');
            add_menu_page(__('Lexicon', 'inventor'), __('Lexicon', 'inventor'), 'edit_posts', 'lexicon', null, null,
                '52');
            $taxonomies         = get_taxonomies([], 'objects');
            $enabled_post_types = $this->get_listing_post_types();
            foreach ($taxonomies as $taxonomy) {
                if ($taxonomy->show_in_menu !== 'lexicon') {
                    continue;
                }
                $name              = $taxonomy->name;
                $label             = $taxonomy->label;
                $object_type       = $taxonomy->object_type;
                $object_type_count = count($object_type);
                $add_submenu       = true;
                if (is_array($object_type) && $object_type_count === 1) {
                    $object_type = $object_type[0];
                    $add_submenu = in_array($object_type, $enabled_post_types);
                }
                if ($add_submenu) {
                    add_submenu_page('lexicon', $label, $label, 'edit_posts', 'edit-tags.php?taxonomy=' . $name, false);
                }
            }
            remove_submenu_page('lexicon', 'lexicon');
        }
    }

    new Admin_Menu();

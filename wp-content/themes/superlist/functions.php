<?php
    /**
     * Superlist functions and definitions
     * @package Superlist
     * @since   Superlist 1.0.0
     */
    //$theme_root = __DIR__;
    /**
     * Constants
     */
    define('POST_EXCERPT_LENGTH', 40);
    define('EXCERPT_LENGTH', 20);
    define('THEME_ASSETS_DIR', get_template_directory_uri() . '/assets');
    define('THEME_ASSETS_LIB_DIR', THEME_ASSETS_DIR . '/libraries');
    define('THEME_BOOTSTRAP_DIR', THEME_ASSETS_LIB_DIR . '/bootstrap-sass');
    define('THEME_CSS_DIR', THEME_ASSETS_DIR . '/css');
    define('THEME_JS_DIR', THEME_ASSETS_DIR . '/js');
    define('THEME_IMG_DIR', THEME_ASSETS_DIR . '/img');
    define('LIB_DIR', __DIR__ . '/library');
    define('CLASS_DIR', LIB_DIR . '/class');
    define('THEME_TPL_DIR', __DIR__ . '/templates');
    define('THEME_WIDGETS_DIR', __DIR__ . '/widgets');
    define('THEME_WIDGETS_TPL_DIR', THEME_WIDGETS_DIR . '/templates');
    /**
     * Libraries
     */
    require_once LIB_DIR . '/class-tgm-plugin-activation.php';
    //require_once CLASS_DIR . '/class-customize-register.php';
    /**
     * Widgets
     */
    require_once THEME_WIDGETS_DIR . '/widget-boxes.php';
    require_once THEME_WIDGETS_DIR . '/widget-call-to-action.php';
    require_once THEME_WIDGETS_DIR . '/widget-simple-map.php';
    require_once THEME_WIDGETS_DIR . '/widget-video-cover.php';
    /**
     * Body classes
     * @filter body_class
     *
     * @param array $body_class Body classes.
     *
     * @return array
     */
    function superlist_body_classes($body_class)
    {
        $body_class[] = get_theme_mod('superlist_general_header', 'header-sticky');
        $body_class[] = get_theme_mod('superlist_general_layout', 'layout-wide');
        $body_class[] = get_theme_mod('superlist_general_submenu', 'submenu-dark');
        if ( ! is_active_sidebar('header-topbar-left') && ! is_active_sidebar('header-topbar-right')) {
            $body_class[] = 'header-empty-topbar';
        }
        //        if( is_front_page()){
        //            $body_class[] = 'header-transparent listing-slider-append-top header-disable-topbar';
        //        }
        return $body_class;
    }

    add_filter('body_class', 'superlist_body_classes');
    /**
     * Widgets Init
     * @action widgets_init
     * @return void
     */
    function superlist_widgets_init()
    {
        register_widget('Superlist_Widget_Boxes');
        register_widget('Superlist_Widget_Call_To_Action');
        register_widget('Superlist_Widget_Video_Cover');
        register_widget('Superlist_Widget_Simple_Map');
    }

    add_action('widgets_init', 'superlist_widgets_init');
    /**
     * Enqueue scripts & styles
     * @action wp_enqueue_scripts
     * @return void
     */
    function superlist_enqueue_files()
    {
        $google_lib_url   = '//ajax.googleapis.com/ajax/libs';
        $bootstrapcdn     = 'https://maxcdn.bootstrapcdn.com/';
        $jsdelivr_lib_url = 'https://cdn.jsdelivr.net/';
        $cdnjs_lib_url    = 'https://cdnjs.cloudflare.com/ajax/libs/';
        wp_deregister_script('jquery');
        $register_js  = [
            [
                'handle'   => 'jquery',
                'src'      => $google_lib_url . '/jquery/2.2.0/jquery.min.js',
                'deps'     => '',
                'in_foter' => true,
                'enqueue'  => true
            ],
            [
                'handle'   => 'bootstrap-select',
                'src'      => THEME_ASSETS_LIB_DIR . '/bootstrap-select/bootstrap-select.min.js',
                'deps'     => 'jquery',
                'in_foter' => true,
                'enqueue'  => true
            ],
            [
                'handle'   => 'bootstrap-dropdown',
                'src'      => THEME_BOOTSTRAP_DIR . '/javascripts/bootstrap/dropdown.min.js',
                'deps'     => 'jquery',
                'in_foter' => true,
                'enqueue'  => true
            ],
            [
                'handle'   => 'bootstrap-collapse',
                'src'      => THEME_BOOTSTRAP_DIR . '/javascripts/bootstrap/collapse.min.js',
                'deps'     => 'jquery',
                'in_foter' => true,
                'enqueue'  => true
            ],
            [
                'handle'   => 'bootstrap-tooltip',
                'src'      => THEME_BOOTSTRAP_DIR . '/javascripts/bootstrap/tooltip.min.js',
                'deps'     => 'jquery',
                'in_foter' => true,
                'enqueue'  => true
            ],
            [
                'handle'   => 'bootstrap-alert',
                'src'      => THEME_BOOTSTRAP_DIR . '/javascripts/bootstrap/alert.min.js',
                'deps'     => 'jquery',
                'in_foter' => true,
                'enqueue'  => true
            ],
            [
                'handle'   => 'bootstrap-affix',
                'src'      => THEME_BOOTSTRAP_DIR . '/javascripts/bootstrap/affix.min.js',
                'deps'     => 'jquery',
                'in_foter' => true,
                'enqueue'  => true
            ],
            [
                'handle'   => 'bootstrap-tab',
                'src'      => THEME_BOOTSTRAP_DIR . '/javascripts/bootstrap/tab.min.js',
                'deps'     => 'jquery',
                'in_foter' => true,
                'enqueue'  => true
            ],
            [
                'handle'   => 'bootstrap-transition',
                'src'      => THEME_BOOTSTRAP_DIR . '/javascripts/bootstrap/transition.min.js',
                'deps'     => 'jquery',
                'in_foter' => true,
                'enqueue'  => true
            ],
            [
                'handle'   => 'bootstrap-scrollspy',
                'src'      => THEME_BOOTSTRAP_DIR . '/javascripts/bootstrap/scrollspy.min.js',
                'deps'     => 'jquery',
                'in_foter' => true,
                'enqueue'  => true
            ],
            [
                'handle'   => 'colorbox',
                'src'      => THEME_ASSETS_LIB_DIR . '/colorbox/jquery.colorbox-min.js',
                'deps'     => 'jquery',
                'in_foter' => true,
                'enqueue'  => true
            ],
            [
                'handle'   => 'owl-carousel',
                'src'      => THEME_ASSETS_LIB_DIR . '/owl.carousel/owl.carousel.min.js',
                'deps'     => 'jquery',
                'in_foter' => true,
                'enqueue'  => true
            ],
            [
                'handle'   => 'scrollto',
                'src'      => THEME_ASSETS_LIB_DIR . '/scrollto/jquery.scrollTo.min.js',
                'deps'     => 'jquery',
                'in_foter' => true,
                'enqueue'  => true
            ],
            [
                'handle'   => 'upages',
                'src'      => THEME_JS_DIR. '/upages.min.js',
                'deps'     => 'jquery',
                'in_foter' => true,
                'enqueue'  => true
            ]
        ];
        $register_css = [
            [
                'handle' => 'roboto',
                'src'    => '//fonts.googleapis.com/css?family=Roboto:300,400,500,700&subset=latin,latin-ext',
                'deps'   => ''
            ],
            [
                'handle' => 'font-awesome',
                'src'    => $bootstrapcdn . 'font-awesome/4.6.1/css/font-awesome.min.css',
                'deps'   => ''
            ],
            [
                'handle' => 'superlist-font',
                'src'    => THEME_ASSETS_LIB_DIR . '/superlist-font/style.css',
                'deps'   => ''
            ],
            [
                'handle' => 'main_style',
                'src'    => THEME_CSS_DIR . '/upages.css',
                'deps'   => ''
            ]
        ];
        foreach ($register_js as $file_js) {
            wp_register_script($file_js['handle'], $file_js['src'], $file_js['deps'], null, $file_js['in_foter']);
            if ($file_js['enqueue'] == true) {
                wp_enqueue_script($file_js['handle']);
            }
        }
        foreach ($register_css as $file_css) {
            wp_enqueue_style($file_css['handle'], $file_css['src'], $file_css['deps'], null);
        }
        if (is_singular()) {
            wp_enqueue_script('comment-reply');
        }
    }

    add_action('wp_enqueue_scripts', 'superlist_enqueue_files', 9);
    /**
     * Register navigations
     * @action init
     * @return void
     */
    function superlist_menus()
    {
        register_nav_menu('main', __('Main', 'superlist'));
    }

    add_action('init', 'superlist_menus');
    /**
     * Custom widget areas
     * @action widgets_init
     * @return void
     */
    function superlist_sidebars()
    {
        register_sidebar([
            'name'          => __('Primary', 'superlist'),
            'id'            => 'sidebar-1',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Dashboard Sidebar Top', 'superlist'),
            'id'            => 'dashboard-top',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Dashboard Sidebar Bottom', 'superlist'),
            'id'            => 'dashboard-bottom',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Header Topbar Left', 'superlist'),
            'id'            => 'header-topbar-left',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Header Topbar Right', 'superlist'),
            'id'            => 'header-topbar-right',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Top Fullwidth', 'superlist'),
            'id'            => 'top-fullwidth',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Top', 'superlist'),
            'id'            => 'top',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Content Top', 'superlist'),
            'id'            => 'content-top',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Content Bottom', 'superlist'),
            'id'            => 'content-bottom',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Bottom', 'superlist'),
            'id'            => 'bottom',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Footer Top First', 'superlist'),
            'id'            => 'footer-top-first',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Footer Top Second', 'superlist'),
            'id'            => 'footer-top-second',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Footer Top Third', 'superlist'),
            'id'            => 'footer-top-third',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Footer Top Fourth', 'superlist'),
            'id'            => 'footer-top-fourth',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Footer First', 'superlist'),
            'id'            => 'footer-first',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Footer Second', 'superlist'),
            'id'            => 'footer-second',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Footer Bottom First', 'superlist'),
            'id'            => 'footer-bottom-first',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
        register_sidebar([
            'name'          => __('Footer Bottom Second', 'superlist'),
            'id'            => 'footer-bottom-second',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ]);
    }

    add_action('widgets_init', 'superlist_sidebars');
    /**
     * Additional after theme setup functions
     * @action after_setup_theme
     * @return void
     */
    function superlist_after_theme_setup()
    {
        load_theme_textdomain('superlist', get_template_directory() . '/languages');
        add_theme_support('automatic-feed-links');
        add_theme_support('post-thumbnails');
        add_theme_support('custom-header', []);
        add_theme_support('custom-background');
        add_theme_support('menus');
        add_theme_support('title-tag');
        $listing_types = get_theme_support('inventor-listing-types');
        if (empty($listing_types)) {
            add_theme_support('inventor-listing-types', [
                'business',
                'car',
                'coupon',
                'dating',
                'education',
                'event',
                'food',
                'hotel',
                'job',
                'pet',
                'property',
                'shopping',
                'travel',
            ]);
        }
        add_filter('widget_text', 'do_shortcode');
        if ( ! isset($content_width)) {
            $content_width = 1170;
        }
    }

    add_action('after_setup_theme', 'superlist_after_theme_setup');
    /**
     * Shares
     * @action superlist_after_listing_banner
     * @action superlist_before_card_box_detail
     * @return void
     */
    function superlist_render_share_button()
    {
        if (class_exists('Inventor')) {
            include Inventor_Template_Loader::locate('misc/share');
        }
    }

    add_action('superlist_after_listing_banner', 'superlist_render_share_button', 0);
    add_action('superlist_before_card_box_detail', 'superlist_render_share_button');
    /**
     * Favorites
     *
     * @param int $listing_id Listing ID.
     *
     * @action superlist_after_listing_banner
     * @action superlist_after_card_box_detail
     * @return void
     */
    function superlist_render_favorite_button($listing_id)
    {
        if (class_exists('Inventor_Favorites')) {
            Inventor_Favorites_Logic::render_favorite_button($listing_id);
        }
    }

    add_action('superlist_after_listing_banner', 'superlist_render_favorite_button', 1, 1);
    add_action('superlist_after_card_box_detail', 'superlist_render_favorite_button', 0, 1);
    /**
     * Reviews
     *
     * @param int $listing_id Listing ID.
     *
     * @action superlist_after_listing_banner
     * @return void
     */
    function superlist_render_total_review($listing_id)
    {
        if (class_exists('Inventor_Reviews')) {
            Inventor_Reviews_Logic::render_listing_rating($listing_id);
        }
    }

    add_action('superlist_after_listing_banner', 'superlist_render_total_review', -1, 1);
    /**
     * Print
     * @action superlist_after_listing_banner
     * @return void
     */
    function superlist_render_print_button()
    {
        if (class_exists('Inventor')) {
            if (get_theme_mod('superlist_general_show_print_listing_button', null) == '1') {
                include Inventor_Template_Loader::locate('misc/print-button');
            }
        }
    }

    add_action('superlist_after_listing_banner', 'superlist_render_print_button', 100);
    /**
     * Custom excerpt length
     *
     * @param int $length String length.
     *
     * @filter excerpt_length
     * @return int
     */
    function superlist_excerpt_length($length)
    {
        global $post;
        if ($post->post_type == 'post') {
            return POST_EXCERPT_LENGTH;
        } else {
            return EXCERPT_LENGTH;
        }
    }

    add_filter('excerpt_length', 'superlist_excerpt_length');
    /**
     * Custom read more
     *
     * @param string $more Read more string.
     *
     * @filter excerpt_more
     * @return string
     */
    function superlist_excerpt_more($more)
    {
        return '&hellip;';
    }

    add_filter('excerpt_more', 'superlist_excerpt_more');
    /**
     * Disable admin's bar top margin
     * @action get_header
     * @return void
     */
    function superlist_disable_admin_bar_top_margin()
    {
        remove_action('wp_head', '_admin_bar_bump_cb');
    }

    add_action('get_header', 'superlist_disable_admin_bar_top_margin');
    /**
     * Custom class for parent menu
     *
     * @param array $items Menu items.
     *
     * @action wp_nav_menu_objects
     * @return array
     */
    function superlist_menu_class($items)
    {
        $parents = [];
        foreach ($items as $item) {
            if ($item->menu_item_parent && $item->menu_item_parent > 0) {
                $parents[] = $item->menu_item_parent;
            }
        }
        foreach ($items as $item) {
            if (in_array($item->ID, $parents)) {
                $item->classes[] = 'has-children';
            }
        }

        return $items;
    }

    add_filter('wp_nav_menu_objects', 'superlist_menu_class');
    /**
     * Customizations
     *
     * @param StdClass $wp_customize WP_Customize object.
     *
     * @action customize_register
     * @return void
     */
    function superlist_customizations($wp_customize)
    {
        $wp_customize->add_section('superlist_general',
            ['title' => __('Superlist General', 'superlist'), 'priority' => 0]);
        // Logo.
        $wp_customize->add_setting('superlist_logo', ['sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_logo', [
            'label'       => __('Logo', 'superlist'),
            'section'     => 'title_tagline',
            'settings'    => 'superlist_logo',
            'description' => __('Logo displayed in header.', 'superlist'),
            'priority'    => 40,
        ]));
        // Layout.
        $wp_customize->add_setting('superlist_general_layout', [
            'default'           => 'layout-wide',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('superlist_general_layout', [
            'label'    => __('Layout', 'superlist'),
            'section'  => 'superlist_general',
            'settings' => 'superlist_general_layout',
            'type'     => 'select',
            'choices'  => [
                'layout-wide'  => __('Wide', 'superlist'),
                'layout-boxed' => __('Boxed', 'superlist'),
            ],
        ]);
        // Header.
        $wp_customize->add_setting('superlist_general_header', [
            'default'           => 'header-sticky',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('superlist_general_header', [
            'label'    => __('Header', 'superlist'),
            'section'  => 'superlist_general',
            'settings' => 'superlist_general_header',
            'type'     => 'select',
            'choices'  => [
                'header-sticky' => __('Sticky', 'superlist'),
                'header-fixed'  => __('Fixed', 'superlist'),
            ],
        ]);
        // Submenu.
        $wp_customize->add_setting('superlist_general_submenu', [
            'default'           => 'submenu-dark',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('superlist_general_submenu', [
            'label'    => __('Submenu', 'superlist'),
            'section'  => 'superlist_general',
            'settings' => 'superlist_general_submenu',
            'type'     => 'select',
            'choices'  => [
                'submenu-dark'  => __('Dark', 'superlist'),
                'submenu-light' => __('Light', 'superlist'),
            ],
        ]);
        // Action text.
        $wp_customize->add_setting('superlist_general_action_text', [
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('superlist_general_action_text', [
            'label'       => __('Action Button Text', 'superlist'),
            'section'     => 'superlist_general',
            'settings'    => 'superlist_general_action_text',
            'description' => __('Text is displayed when button is hovered.', 'superlist'),
        ]);
        // Action page.
        $wp_customize->add_setting('superlist_general_action', ['sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control('superlist_general_action', [
            'label'       => __('Action Button Page', 'superlist'),
            'type'        => 'select',
            'section'     => 'superlist_general',
            'settings'    => 'superlist_general_action',
            'choices'     => superlist_get_pages(),
            'description' => __('Page where the action button will point to.', 'superlist'),
        ]);
        // Show print button in listing detail.
        $wp_customize->add_setting('superlist_general_show_print_listing_button', [
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('superlist_general_show_print_listing_button', [
            'type'     => 'checkbox',
            'label'    => __('Show print button in listing detail', 'superlist'),
            'section'  => 'superlist_general',
            'settings' => 'superlist_general_show_print_listing_button',
        ]);
    }

    add_action('customize_register', 'superlist_customizations');
    /**
     * Comments template
     *
     * @param string $comment Comment message.
     * @param array  $args    Arguments.
     * @param int    $depth   Depth.
     *
     * @return void
     */
    function superlist_comment($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        extract($args, EXTR_SKIP);
        include THEME_TPL_DIR . '/misc/comment.php';
    }

    /**
     * Get pages list
     * @return array
     */
    function superlist_get_pages()
    {
        $pages   = [];
        $pages[] = __('Not set', 'superlist');
        foreach (get_pages() as $page) {
            $pages[$page->ID] = $page->post_title;
        }

        return $pages;
    }

    /**
     * Register plugins
     * @action tgmpa_register
     * @return void
     */
    function superlist_register_required_plugins()
    {
        $plugins          = [
            [
                'name'         => 'CMB2',
                'slug'         => 'cmb2',
                'is_automatic' => true,
                'required'     => false,
            ],
            [
                'name'         => 'Widget Logic',
                'slug'         => 'widget-logic',
                'is_automatic' => true,
                'required'     => false,
            ],
            [
                'name'     => 'Wordpress Importer',
                'slug'     => 'wordpress-importer',
                'required' => true,
            ],
            [
                'name'         => 'Contact Form 7',
                'slug'         => 'contact-form-7',
                'required'     => false,
                'is_automatic' => true,
            ],
            [
                'name'     => 'WordPress Social Login',
                'slug'     => 'wordpress-social-login',
                'required' => false,
            ]
        ];
        tgmpa($plugins);
    }

    add_action('tgmpa_register', 'superlist_register_required_plugins');
    /**
     * Posts pagination
     * @return void
     */
    function superlist_pagination()
    {
        the_posts_pagination([
            'prev_text' => __('Previous', 'superlist'),
            'next_text' => __('Next', 'superlist'),
            'mid_size'  => 2,
        ]);
    }

    /**
     * Remove 'Archives:' from post type archive title
     * @filter get_the_archive_title
     *
     * @param string $title Archive title.
     *
     * @return string|void
     */
    function superlist_get_the_archive_title($title)
    {
        if (is_post_type_archive()) {
            return post_type_archive_title('', false);
        }

        return $title;
    }

    add_filter('get_the_archive_title', 'superlist_get_the_archive_title');
    /**
     * Custom total rating attrs
     *
     * @param $listing_id
     *
     * @return string
     */
    function superlist_review_rating_toral_attrs($listing_id)
    {
        echo 'data-fontawesome data-starOn="fa fa-star" data-starHalf="fa fa-star-half-o" data-starOff="fa fa-star-o"';
    }

    add_action('inventor_review_rating_total_attrs', 'superlist_review_rating_toral_attrs', 10, 1);

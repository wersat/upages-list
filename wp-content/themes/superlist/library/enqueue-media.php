<?php
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
                'src'      => THEME_JS_DIR . '/upages.min.js',
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
        wp_enqueue_script('wp-api');
    }

    add_action('wp_enqueue_scripts', 'superlist_enqueue_files', 9);


    function admin_custom_js() {
        wp_enqueue_script( 'media-upload' );
        wp_enqueue_media();

        wp_enqueue_script( 'my_custom_script', THEME_JS_DIR . '/admin_custom.js' ,['jquery']);
    }
    add_action( 'admin_enqueue_scripts', 'admin_custom_js' );

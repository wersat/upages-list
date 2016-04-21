<?php
    return [
        ////////////////////////////////////////////////
        // Scripts and Styles Dependencies Definition //
        ////////////////////////////////////////////////
        /*
         * jQuery UI Theme
         */
        'jqui_theme' => ($jqui_theme = 'smoothness'),
        /*
         * Scripts.
         */
        'scripts' => [
            'always' => ['jquery', 'scrollspy', 'tipsy', 'jquery-typing', 'datetimepicker'],
            'paths' => [
                'jquery' => [
                    'path' => '',
                    'deps' => [],
                    'ver' => '1.8.3',
                    'override' => false,
                ],
                'bootstrap-colorpicker' => [
                    'path' => VP_PUBLIC_URL.'/js/vendor/bootstrap-colorpicker.js',
                    'deps' => ['jquery'],
                    'ver' => false,
                ],
                'tipsy' => [
                    'path' => VP_PUBLIC_URL.'/js/vendor/jquery.tipsy.js',
                    'deps' => ['jquery'],
                    'ver' => '1.0.0a',
                ],
                'scrollspy' => [
                    'path' => VP_PUBLIC_URL.'/js/vendor/jquery-scrollspy.js',
                    'deps' => ['jquery'],
                    'ver' => false,
                ],
                'jquery-ui-core' => [
                    'path' => '',
                    'deps' => [],
                    'ver' => '1.9.2',
                ],
                'jquery-ui-widget' => [
                    'path' => '',
                    'deps' => [],
                    'ver' => '1.9.2',
                ],
                'jquery-ui-mouse' => [
                    'path' => '',
                    'deps' => ['jquery-ui-widget'],
                    'ver' => '1.9.2',
                ],
                'jquery-ui-slider' => [
                    'path' => '',
                    'deps' => ['jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse'],
                    'ver' => '1.9.2',
                ],
                'jquery-ui-datepicker' => [
                    'path' => '',
                    'deps' => ['jquery', 'jquery-ui-core', 'jquery-ui-widget'],
                    'ver' => '1.9.2',
                ],
                'jquery-typing' => [
                    'path' => VP_PUBLIC_URL.'/js/vendor/jquery.typing-0.2.0.min.js',
                    'deps' => ['jquery'],
                    'ver' => '0.2',
                ],
                'ace-editor' => [
                    'path' => VP_PUBLIC_URL.'/js/vendor/ace/ace.js',
                    'deps' => [],
                    'ver' => '1.0.0',
                ],
                'select2' => [
                    'path' => VP_PUBLIC_URL.'/js/vendor/select2.min.js',
                    'deps' => ['jquery'],
                    'ver' => '3.3.2',
                    'override' => true,
                ],
                'select2-sortable' => [
                    'path' => VP_PUBLIC_URL.'/js/vendor/select2.sortable.js',
                    'deps' => ['jquery', 'jquery-ui-sortable', 'select2'],
                    'ver' => '1.0.0',
                    'override' => true,
                ],
                'reveal' => [
                    'path' => VP_PUBLIC_URL.'/js/vendor/jquery.reveal.js',
                    'deps' => ['jquery'],
                    'ver' => '1.0.0',
                ],
                'kia-metabox' => [
                    'path' => VP_PUBLIC_URL.'/js/kia-metabox.js',
                    'deps' => ['jquery', 'editor'],
                    'ver' => '1.0',
                    'override' => true,
                ],
                'shared' => [
                    'path' => VP_PUBLIC_URL.'/js/shared.min.js',
                    'deps' => [],
                    'ver' => '1.1',
                    'localize' => [
                        'name' => 'vp_wp',
                        'keys' => [
                            'use_upload',
                            'use_new_media_upload',
                            'public_url',
                            'wp_include_url',
                            'val_msg',
                            'ctrl_msg',
                            'alphabet_validatable',
                            'alphanumeric_validatable',
                            'numeric_validatable',
                            'email_validatable',
                            'url_validatable',
                            'maxlength_validatable',
                            'minlength_validatable',
                        ],
                    ],
                ],
                'vp-option' => [
                    'path' => VP_PUBLIC_URL.'/js/option.min.js',
                    'deps' => [],
                    'ver' => '2.0',
                    'localize' => [
                        'name' => 'vp_opt',
                        'keys' => [
                            'util_msg',
                            'nonce',
                        ],
                    ],
                ],
                'vp-metabox' => [
                    'path' => VP_PUBLIC_URL.'/js/metabox.min.js',
                    'deps' => [],
                    'ver' => '2.0',
                    'localize' => [
                        'name' => 'vp_mb',
                        'keys' => [
                            'use_upload',
                            'use_new_media_upload',
                        ],
                    ],
                ],
                'datetimepicker' => [
                    'path' => VP_PUBLIC_URL.'/js/vendor/jquery.datetimepicker.full.min.js',
                    'deps' => ['jquery'],
                    'ver' => '2.0',
                ],
                'vp-shortcode-qt' => [
                    'path' => VP_PUBLIC_URL.'/js/shortcode-quicktags.js',
                    'deps' => ['reveal'],
                    'ver' => '1.0.0',
                ],
                'vp-shortcode' => [
                    'path' => VP_PUBLIC_URL.'/js/shortcode-menu.js',
                    'deps' => ['reveal', 'vp-shortcode-qt'],
                    'ver' => '2.0',
                    'localize' => [
                        'name' => 'vp_ext_sc',
                        'keys' => [
                            'use_upload',
                            'use_new_media_upload',
                            'public_url',
                        ],
                    ],
                ],
            ],
        ],
        /*
         * Styles.
         */
        'styles' => [
            'always' => ['tipsy', 'font-awesome', 'vp-datetimepicker'],
            'paths' => [
                'bootstrap-colorpicker' => [
                    'path' => VP_PUBLIC_URL.'/css/vendor/bootstrap-colorpicker.css',
                    'deps' => [],
                ],
                'tipsy' => [
                    'path' => VP_PUBLIC_URL.'/css/vendor/tipsy.css',
                    'deps' => [],
                ],
                'jqui' => [
                    'path' => VP_PUBLIC_URL.'/css/vendor/jqueryui/themes/'.$jqui_theme.'/jquery-ui-1.9.2.custom.min.css',
                    'deps' => [],
                ],
                'font-awesome' => [
                    'path' => VP_PUBLIC_URL.'/css/vendor/font-awesome.min.css',
                    'deps' => [],
                ],
                'select2' => [
                    'path' => VP_PUBLIC_URL.'/css/vendor/select2.css',
                    'deps' => [],
                ],
                'reveal' => [
                    'path' => VP_PUBLIC_URL.'/css/vendor/reveal.css',
                    'deps' => [],
                ],
                'vp-option' => [
                    'path' => VP_PUBLIC_URL.'/css/option.min.css',
                    'deps' => [],
                ],
                'vp-metabox' => [
                    'path' => VP_PUBLIC_URL.'/css/metabox.min.css',
                    'deps' => [],
                ],
                'vp-shortcode' => [
                    'path' => VP_PUBLIC_URL.'/css/shortcode.min.css',
                    'deps' => ['reveal'],
                ],
                'vp-datetimepicker' => [
                    'path' => VP_PUBLIC_URL.'/css/vendor/jquery.datetimepicker.css',
                    'deps' => [],
                ],
            ],
        ],
        /*
         * Rules for dynamic loading of dependencies, load only what needed.
         */
        'rules' => [
            'color' => ['js' => ['bootstrap-colorpicker'], 'css' => ['bootstrap-colorpicker']],
            'select' => ['js' => ['select2'], 'css' => ['select2']],
            'multiselect' => ['js' => ['select2'], 'css' => ['select2']],
            'slider' => ['js' => ['jquery-ui-slider'], 'css' => ['jqui']],
            'date' => ['js' => ['datetimepicker'], 'css' => ['jqui']],
            'codeeditor' => ['js' => ['ace-editor'], 'css' => []],
            'sorter' => ['js' => ['select2-sortable'], 'css' => ['select2', 'jqui']],
            'fontawesome' => ['js' => ['select2'], 'css' => ['select2']],
            'wpeditor' => ['js' => ['kia-metabox'], 'css' => []],
        ],
    ];

    /*
     * EOF
     */

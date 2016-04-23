<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Fields_Scripts.
     * @class  Inventor_Fields_Scripts
     * @author Pragmatic Mates
     */
    class Inventor_Fields_Scripts
    {
        /**
         * Initialize scripts.
         */
        public static function init()
        {
            add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_backend']);
        }

        /**
         * Loads backend files.
         */
        public static function enqueue_backend()
        {
            wp_register_script('inventor-fields', plugins_url('/inventor-fields/assets/js/inventor-fields.min.js'),
                ['jquery'], false, true);
            wp_enqueue_script('inventor-fields');
        }
    }

    Inventor_Fields_Scripts::init();

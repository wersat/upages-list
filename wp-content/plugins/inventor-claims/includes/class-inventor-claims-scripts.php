<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Claims_Scripts.
     * @class  Inventor_Claims_Scripts
     * @author Pragmatic Mates
     */
    class Inventor_Claims_Scripts
    {
        /**
         * Initialize scripts.
         */
        public static function init()
        {
            add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_frontend']);
        }

        /**
         * Loads frontend files.
         */
        public static function enqueue_frontend()
        {
            wp_register_script('inventor-claims', plugins_url('/inventor-claims/assets/js/inventor-claims.min.js'),
                ['jquery'], false, true);
            wp_enqueue_script('inventor-claims');
        }
    }

    Inventor_Claims_Scripts::init();

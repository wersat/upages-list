<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Favorites_Scripts.
     * @class  Inventor_Favorites_Scripts
     * @author Pragmatic Mates
     */
    class Inventor_Favorites_Scripts
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
            wp_register_script('inventor-favorites', plugins_url('/inventor-favorites/assets/js/inventor-favorites.min.js'),
                ['jquery'], false, true);
            wp_enqueue_script('inventor-favorites');
        }
    }

    Inventor_Favorites_Scripts::init();

<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Google_Map_Scripts
     * @class   Inventor_Google_Map_Scripts
     * @package Inventor_Google_Map/Classes
     * @author  Pragmatic Mates
     */
    class Inventor_Google_Map_Scripts
    {
        /**
         * Initialize scripts
         * @access public
         * @return void
         */
        public static function init()
        {
            add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_frontend']);
        }

        /**
         * Loads frontend files
         * @access public
         * @return void
         */
        public static function enqueue_frontend()
        {
            $browser_key = get_theme_mod('inventor_general_google_browser_key');
            $key         = empty($browser_key) ? '' : 'key=' . $browser_key . '&';
            wp_enqueue_script('google-maps',
                '//maps.googleapis.com/maps/api/js?' . $key . 'libraries=weather,geometry,visualization,places,drawing');
            wp_register_script('infobox', plugins_url('/inventor-google-map/libraries/jquery-google-map/infobox.js'),
                ['jquery'], false, true);
            wp_enqueue_script('infobox');
            wp_register_script('markerclusterer',
                plugins_url('/inventor-google-map/libraries/jquery-google-map/markerclusterer.min.js'), ['jquery'], false,
                true);
            wp_enqueue_script('markerclusterer');
            wp_register_script('cookie', plugins_url('/inventor-google-map/libraries/js-cookie.min.js'), ['jquery'], false,
                true);
            wp_enqueue_script('cookie');
            wp_register_script('jquery-google-map',
                plugins_url('/inventor-google-map/libraries/jquery-google-map/jquery-google-map.min.js'), ['jquery'], false,
                true);
            wp_enqueue_script('jquery-google-map');
            wp_register_script('inventor-google-map',
                plugins_url('/inventor-google-map/assets/js/inventor-google-map.min.js'), ['jquery'], false, true);
            wp_enqueue_script('inventor-google-map');
        }
    }

    Inventor_Google_Map_Scripts::init();

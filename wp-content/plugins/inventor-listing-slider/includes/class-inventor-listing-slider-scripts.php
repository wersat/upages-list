<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Listing_Slider_Scripts.
     * @class  Inventor_Listing_Slider_Scripts
     * @author Pragmatic Mates
     */
    class Inventor_Listing_Slider_Scripts
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
            wp_register_script('owl-carousel',
                plugins_url('/inventor-listing-slider/libraries/owl.carousel/owl.carousel.min.js'), ['jquery'], false,
                true);
            wp_enqueue_script('owl-carousel');
//            wp_register_style('owl-carousel',
//                plugins_url('/inventor-listing-slider/libraries/owl.carousel/owl.carousel.css'));
//            wp_enqueue_style('owl-carousel');
        }
    }

    Inventor_Listing_Slider_Scripts::init();

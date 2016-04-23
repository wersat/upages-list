<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Coupons_Scripts.
     * @class  Inventor_Coupons_Scripts
     * @author Pragmatic Mates
     */
    class Inventor_Coupons_Scripts
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
            wp_register_script('inventor-coupons', plugins_url('/inventor-coupons/assets/js/inventor-coupons.min.js'),
                ['jquery'], false, true);
            wp_enqueue_script('inventor-coupons');
        }
    }

    Inventor_Coupons_Scripts::init();

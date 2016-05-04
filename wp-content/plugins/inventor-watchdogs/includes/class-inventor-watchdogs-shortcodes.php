<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Watchdogs_Shortcodes.
     * @class   Inventor_Watchdogs_Shortcodes
     * @author  Pragmatic Mates
     */
    class Inventor_Watchdogs_Shortcodes
    {
        /**
         * Initialize shortcodes.
         */
        public static function init()
        {
            add_shortcode('inventor_watchdogs', [__CLASS__, 'watchdogs']);
        }

        /**
         * Watchdogs.
         *
         * @param $atts
         */
        public static function watchdogs($atts)
        {
            if ( ! is_user_logged_in()) {
                echo Inventor_Template_Loader::load('misc/not-allowed');

                return;
            }
            Inventor_Watchdogs_Logic::loop_my_watchdogs();
            echo Inventor_Template_Loader::load('watchdogs', $atts, $plugin_dir = INVENTOR_WATCHDOGS_DIR);
            wp_reset_query();
        }
    }

    Inventor_Watchdogs_Shortcodes::init();

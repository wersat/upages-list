<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Favorites_Shortcodes.
     * @class  Inventor_Favorites_Shortcodes
     * @author Pragmatic Mates
     */
    class Inventor_Favorites_Shortcodes
    {
        /**
         * Initialize shortcodes.
         */
        public static function init()
        {
            add_shortcode('inventor_favorites', [__CLASS__, 'favorites']);
        }

        /**
         * Favorites.
         *
         * @param $atts
         */
        public static function favorites($atts)
        {
            if ( ! is_user_logged_in()) {
                echo Inventor_Template_Loader::load('misc/not-allowed');

                return;
            }
            Inventor_Favorites_Logic::loop_my_favorites();
            echo Inventor_Template_Loader::load('favorites', $atts, $plugin_dir = INVENTOR_FAVORITES_DIR);
            wp_reset_query();
        }
    }

    Inventor_Favorites_Shortcodes::init();

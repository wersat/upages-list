<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Packages_Shortcodes.
     * @class  Inventor_Packages_Shortcodes
     * @author Pragmatic Mates
     */
    class Inventor_Packages_Shortcodes
    {
        /**
         * Initialize shortcodes.
         */
        public static function init()
        {
            add_shortcode('inventor_package_info', [__CLASS__, 'package_info']);
        }

        /**
         * Package information.
         *
         * @param $atts
         *
         * @return string
         */
        public static function package_info($atts = [])
        {
            if ( ! is_user_logged_in()) {
                return Inventor_Template_Loader::load('misc/not-allowed');
            }

            return Inventor_Template_Loader::load('package-info', [], INVENTOR_PACKAGES_DIR);
        }
    }

    Inventor_Packages_Shortcodes::init();

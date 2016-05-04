<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Favorites_Customizations.
     */
    class Inventor_Favorites_Customizations
    {
        /**
         * Initialize customizations.
         */
        public static function init()
        {
            self::includes();
        }

        /**
         * Include all customizations.
         */
        public static function includes()
        {
            require_once INVENTOR_FAVORITES_DIR . 'includes/customizations/class-inventor-favorites-customizations-favorites.php';
        }
    }

    Inventor_Favorites_Customizations::init();

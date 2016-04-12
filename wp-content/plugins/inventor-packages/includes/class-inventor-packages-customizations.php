<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Packages_Customizations.
     */
    class Inventor_Packages_Customizations
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
            require_once INVENTOR_PACKAGES_DIR . 'includes/customizations/class-inventor-packages-customizations-packages.php';
        }
    }

    Inventor_Packages_Customizations::init();

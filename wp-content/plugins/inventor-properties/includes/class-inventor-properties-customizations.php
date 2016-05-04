<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Properties_Customizations.
     */
    class Inventor_Properties_Customizations
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
            require_once INVENTOR_PROPERTIES_DIR . 'includes/customizations/class-inventor-properties-customizations-properties.php';
        }
    }

    Inventor_Properties_Customizations::init();

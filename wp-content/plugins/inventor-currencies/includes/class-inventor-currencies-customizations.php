<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Currencies_Customizations.
     */
    class Inventor_Currencies_Customizations
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
            require_once INVENTOR_CURRENCIES_DIR . 'includes/customizations/class-inventor-currencies-customizations-currencies.php';
        }
    }

    Inventor_Currencies_Customizations::init();

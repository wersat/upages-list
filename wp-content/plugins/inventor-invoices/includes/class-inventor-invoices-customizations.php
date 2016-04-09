<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Invoices_Customizations.
     */
    class Inventor_Invoices_Customizations
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
            require_once INVENTOR_INVOICES_DIR . 'includes/customizations/class-inventor-invoices-customizations-invoices.php';
        }
    }

    Inventor_Invoices_Customizations::init();

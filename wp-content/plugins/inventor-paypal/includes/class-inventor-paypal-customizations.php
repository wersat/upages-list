<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Paypal_Customizations.
     */
    class Inventor_Paypal_Customizations
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
            require_once INVENTOR_PAYPAL_DIR . 'includes/customizations/class-inventor-paypal-customizations-paypal.php';
        }
    }

    Inventor_PayPal_Customizations::init();

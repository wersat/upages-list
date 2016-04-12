<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Stripe_Customizations.
     */
    class Inventor_Stripe_Customizations
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
            require_once INVENTOR_STRIPE_DIR.'includes/customizations/class-inventor-stripe-customizations-stripe.php';
        }
    }

    Inventor_Stripe_Customizations::init();

<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Claims_Customizations.
     * @author Pragmatic Mates
     */
    class Inventor_Claims_Customizations
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
            require_once INVENTOR_CLAIMS_DIR . 'includes/customizations/class-inventor-claims-customizations-claims.php';
        }
    }

    Inventor_Claims_Customizations::init();

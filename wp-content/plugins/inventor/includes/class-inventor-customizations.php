<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Customizations.
     */
    class Inventor_Customizations
    {
        /**
         * Initialize customizations.
         */
        public static function init()
        {
            add_action('customize_register', [__CLASS__, 'types']);
            self::includes();
        }

        /**
         * Include all customizations.
         */
        public static function includes()
        {
            require_once INVENTOR_DIR.'includes/customizations/class-inventor-customizations-general.php';
            require_once INVENTOR_DIR.'includes/customizations/class-inventor-customizations-currency.php';
            require_once INVENTOR_DIR.'includes/customizations/class-inventor-customizations-measurement.php';
            require_once INVENTOR_DIR.'includes/customizations/class-inventor-customizations-pages.php';
            require_once INVENTOR_DIR.'includes/customizations/class-inventor-customizations-submission.php';
            require_once INVENTOR_DIR.'includes/customizations/class-inventor-customizations-wire-transfer.php';
        }

        /**
         * Register new types for customizer.
         */
        public static function types()
        {
            require_once INVENTOR_DIR.'includes/customizations/class-inventor-customizations-types.php';
        }
    }

    Inventor_Customizations::init();

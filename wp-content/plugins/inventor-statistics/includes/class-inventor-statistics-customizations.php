<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Statistics_Customizations.
     */
    class Inventor_Statistics_Customizations
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
            require_once INVENTOR_STATISTICS_DIR . 'includes/customizations/class-inventor-statistics-customizations-statistics.php';
        }
    }

    Inventor_Statistics_Customizations::init();

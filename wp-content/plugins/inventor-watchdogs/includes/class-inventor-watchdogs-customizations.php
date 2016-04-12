<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Watchdogs_Customizations.
     * @author  Pragmatic Mates
     */
    class Inventor_Watchdogs_Customizations
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
            require_once INVENTOR_WATCHDOGS_DIR . 'includes/customizations/class-inventor-watchdogs-customizations-watchdogs.php';
        }
    }

    Inventor_Watchdogs_Customizations::init();

<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Notifications_Customizations.
     */
    class Inventor_Notifications_Customizations
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
            require_once INVENTOR_NOTIFICATIONS_DIR . 'includes/customizations/class-inventor-notifications-customizations-notifications.php';
        }
    }

    Inventor_Notifications_Customizations::init();

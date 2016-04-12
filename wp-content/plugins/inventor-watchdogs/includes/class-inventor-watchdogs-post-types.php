<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Watchdogs_Post_Types.
     * @class   Inventor_Watchdogs_Post_Types
     * @author  Pragmatic Mates
     */
    class Inventor_Watchdogs_Post_Types
    {
        /**
         * Initialize listing types.
         */
        public static function init()
        {
            self::includes();
        }

        /**
         * Loads listing types.
         */
        public static function includes()
        {
            require_once INVENTOR_WATCHDOGS_DIR . 'includes/post-types/class-inventor-watchdogs-post-type-watchdog.php';
        }
    }

    Inventor_Watchdogs_Post_Types::init();

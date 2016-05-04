<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Jobs_Customizations.
     * @author Pragmatic Mates
     */
    class Inventor_Jobs_Customizations
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
            require_once INVENTOR_JOBS_DIR . 'includes/customizations/class-inventor-jobs-customizations-jobs.php';
        }
    }

    Inventor_Jobs_Customizations::init();

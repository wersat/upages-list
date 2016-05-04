<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Jobs_Taxonomies.
     * @class  Inventor_Jobs_Taxonomies
     * @author Pragmatic Mates
     */
    class Inventor_Jobs_Taxonomies
    {
        /**
         * Initialize taxonomies.
         */
        public static function init()
        {
            self::includes();
        }

        /**
         * Includes all taxonomies.
         */
        public static function includes()
        {
            require_once INVENTOR_JOBS_DIR . 'includes/taxonomies/class-inventor-jobs-taxonomy-job-positions.php';
            require_once INVENTOR_JOBS_DIR . 'includes/taxonomies/class-inventor-jobs-taxonomy-job-skills.php';
        }
    }

    Inventor_Jobs_Taxonomies::init();

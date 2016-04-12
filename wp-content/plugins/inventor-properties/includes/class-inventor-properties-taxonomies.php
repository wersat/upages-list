<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Properties_Taxonomies.
     * @class   Inventor_Properties_Taxonomies
     * @author  Pragmatic Mates
     */
    class Inventor_Properties_Taxonomies
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
            require_once INVENTOR_PROPERTIES_DIR . 'includes/taxonomies/class-inventor-properties-taxonomy-property-amenities.php';
            require_once INVENTOR_PROPERTIES_DIR . 'includes/taxonomies/class-inventor-properties-taxonomy-property-types.php';
        }
    }

    Inventor_Properties_Taxonomies::init();

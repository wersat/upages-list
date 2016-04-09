<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Fields_Post_Types.
     * @class  Inventor_Fields_Post_Types
     * @author Pragmatic Mates
     */
    class Inventor_Fields_Post_Types
    {
        /**
         * Initialize property types.
         */
        public static function init()
        {
            self::includes();
        }

        /**
         * Loads property types.
         */
        public static function includes()
        {
            require_once INVENTOR_FIELDS_DIR . 'includes/post-types/class-inventor-fields-post-type-listing-type.php';
            require_once INVENTOR_FIELDS_DIR . 'includes/post-types/class-inventor-fields-post-type-metabox.php';
            require_once INVENTOR_FIELDS_DIR . 'includes/post-types/class-inventor-fields-post-type-field.php';
        }
    }

    Inventor_Fields_Post_Types::init();

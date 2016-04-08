<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_FAQ_Post_Types.
     * @class  Inventor_FAQ_Post_Types
     * @author Pragmatic Mates
     */
    class Inventor_FAQ_Post_Types
    {
        /**
         * Initialize post types.
         */
        public static function init()
        {
            self::includes();
        }

        /**
         * Loads post types.
         */
        public static function includes()
        {
            require_once INVENTOR_FAQ_DIR . 'includes/post-types/class-inventor-faq-post-type-faq.php';
        }
    }

    Inventor_FAQ_Post_Types::init();

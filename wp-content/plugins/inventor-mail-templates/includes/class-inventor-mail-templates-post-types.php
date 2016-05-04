<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Mail_Templates_Post_Types.
     * @class  Inventor_Mail_Templates_Post_Types
     * @author Pragmatic Mates
     */
    class Inventor_Mail_Templates_Post_Types
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
            require_once INVENTOR_MAIL_TEMPLATES_DIR . 'includes/post-types/class-inventor-mail-templates-post-type-mail-template.php';
        }
    }

    Inventor_Mail_Templates_Post_Types::init();

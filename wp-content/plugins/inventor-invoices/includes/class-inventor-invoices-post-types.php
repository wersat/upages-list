<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Invoices_Post_Types.
     * @class  Inventor_Invoices_Post_Types
     * @author Pragmatic Mates
     */
    class Inventor_Invoices_Post_Types
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
            require_once INVENTOR_INVOICES_DIR . 'includes/post-types/class-inventor-invoices-post-type-invoice.php';
        }
    }

    Inventor_Invoices_Post_Types::init();

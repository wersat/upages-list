<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Invoices_Shortcodes.
     * @class  Inventor_Invoices_Shortcodes
     * @author Pragmatic Mates
     */
    class Inventor_Invoices_Shortcodes
    {
        /**
         * Initialize shortcodes.
         */
        public static function init()
        {
            add_shortcode('inventor_invoices', [__CLASS__, 'invoices']);
        }

        /**
         * Invoices.
         *
         * @param $atts
         */
        public static function invoices($atts)
        {
            if ( ! is_user_logged_in()) {
                echo Inventor_Template_Loader::load('misc/not-allowed');

                return;
            }
            Inventor_Invoices_Logic::loop_my_invoices();
            echo Inventor_Template_Loader::load('invoices', $atts, $plugin_dir = INVENTOR_INVOICES_DIR);
            wp_reset_query();
        }
    }

    Inventor_Invoices_Shortcodes::init();

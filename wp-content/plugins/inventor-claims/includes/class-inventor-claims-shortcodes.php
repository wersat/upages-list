<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Claims_Shortcodes.
     * @class  Inventor_Claims_Shortcodes
     * @author Pragmatic Mates
     */
    class Inventor_Claims_Shortcodes
    {
        /**
         * Initialize shortcodes.
         */
        public static function init()
        {
            add_shortcode('inventor_claim_form', [__CLASS__, 'claim_form']);
        }

        /**
         * Claim form.
         *
         * @param $atts
         */
        public static function claim_form($atts)
        {
            if ( ! is_user_logged_in()) {
                echo Inventor_Template_Loader::load('misc/not-allowed');

                return;
            }
            $atts = [
                'listing' => Inventor_Post_Types::get_listing($_GET['id']),
            ];
            echo Inventor_Template_Loader::load('claims-form', $atts, $plugin_dir = INVENTOR_CLAIMS_DIR);
        }
    }

    Inventor_Claims_Shortcodes::init();

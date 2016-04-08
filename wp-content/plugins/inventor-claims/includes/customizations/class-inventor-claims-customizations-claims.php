<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Claims_Customizations_Claims.
     * @class  Inventor_Claims_Customizations_Claims
     * @author Pragmatic Mates
     */
    class Inventor_Claims_Customizations_Claims
    {
        /**
         * Initialize customization type.
         */
        public static function init()
        {
            add_action('customize_register', [__CLASS__, 'customizations']);
        }

        /**
         * Customizations.
         *
         * @param object $wp_customize
         */
        public static function customizations($wp_customize)
        {
            $pages = Inventor_Utilities::get_pages();
            // Claim page
            $wp_customize->add_setting('inventor_claims_page', [
                'default'           => null,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_claims_page', [
                'type'     => 'select',
                'label'    => __('Claim listing', 'inventor-claims'),
                'section'  => 'inventor_pages',
                'settings' => 'inventor_claims_page',
                'choices'  => $pages,
            ]);
        }
    }

    Inventor_Claims_Customizations_Claims::init();

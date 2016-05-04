<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Customizations_Properties.
     * @class   Inventor_Properties_Customizations_Properties
     * @author  Pragmatic Mates
     */
    class Inventor_Properties_Customizations_Properties
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
            $wp_customize->add_section('inventor_properties', [
                'title'    => __('Inventor Properties', 'inventor-properties'),
                'priority' => 1,
            ]);
            // Unassigned amenities
            $wp_customize->add_setting('inventor_properties_hide_unassigned_amenities', [
                'default'           => false,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_properties_hide_unassigned_amenities', [
                'type'     => 'checkbox',
                'label'    => __('Hide unasigned amenities', 'inventor-properties'),
                'section'  => 'inventor_properties',
                'settings' => 'inventor_properties_hide_unassigned_amenities',
            ]);
        }
    }

    Inventor_Properties_Customizations_Properties::init();

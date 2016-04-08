<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Customizations_Measurement.
     *
     * @class  Inventor_Customizations_Measurement
     *
     * @author Pragmatic Mates
     */
    class Inventor_Customizations_Measurement
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
            $wp_customize->add_section('inventor_measurement', [
                'title' => __('Inventor Measurement', 'inventor'),
                'priority' => 1,
            ]);
            // Area unit
            $wp_customize->add_setting('inventor_measurement_area_unit', [
                'default' => 'sqft',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_measurement_area_unit', [
                'label' => __('Area Unit', 'inventor'),
                'section' => 'inventor_measurement',
                'settings' => 'inventor_measurement_area_unit',
            ]);
            // Distance unit
            $wp_customize->add_setting('inventor_measurement_distance_unit', [
                'default' => 'ft',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_measurement_distance_unit', [
                'label' => __('Short Distance Unit', 'inventor'),
                'section' => 'inventor_measurement',
                'settings' => 'inventor_measurement_distance_unit',
                'description' => __('Example: "ft" or "m"', 'inventor'),
            ]);
            // Distance unit long
            $wp_customize->add_setting('inventor_measurement_distance_unit_long', [
                'default' => 'mi',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_measurement_distance_unit_long', [
                'label' => __('Long Distance Unit', 'inventor'),
                'section' => 'inventor_measurement',
                'settings' => 'inventor_measurement_distance_unit_long',
                'description' => __('Example: "mi" or "km"', 'inventor'),
            ]);
            // Weight unit
            $wp_customize->add_setting('inventor_measurement_weight_unit', [
                'default' => 'lbs',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_measurement_weight_unit', [
                'label' => __('Weight unit', 'inventor'),
                'section' => 'inventor_measurement',
                'settings' => 'inventor_measurement_weight_unit',
                'description' => __('Example: "lbs" or "kg"', 'inventor'),
            ]);
        }
    }

    Inventor_Customizations_Measurement::init();

<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Customizations_Statistics.
     * @class  Inventor_Statistics_Customizations_Statistics
     * @author Pragmatic Mates
     */
    class Inventor_Statistics_Customizations_Statistics
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
            $wp_customize->add_section('inventor_statistics', [
                'title'    => __('Inventor Statistics', 'inventor-statistics'),
                'priority' => 1,
            ]);
            // Query logging
            $wp_customize->add_setting('inventor_statistics_enable_query_logging', [
                'default'           => false,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_statistics_enable_query_logging', [
                'type'     => 'checkbox',
                'label'    => __('Enable Search Query Logging', 'inventor-statistics'),
                'section'  => 'inventor_statistics',
                'settings' => 'inventor_statistics_enable_query_logging',
            ]);
            // Listing logging
            $wp_customize->add_setting('inventor_statistics_enable_listing_logging', [
                'default'           => false,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_statistics_enable_listing_logging', [
                'type'     => 'checkbox',
                'label'    => __('Enable Listing Views Logging', 'inventor-statistics'),
                'section'  => 'inventor_statistics',
                'settings' => 'inventor_statistics_enable_listing_logging',
            ]);
        }
    }

    Inventor_Statistics_Customizations_Statistics::init();

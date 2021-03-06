<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Watchdogs_Customizations_Watchdogs.
     * @class  Inventor_Watchdogs_Customizations_Watchdogs
     * @author Pragmatic Mates
     */
    class Inventor_Watchdogs_Customizations_Watchdogs
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
            $wp_customize->add_section('inventor_watchdogs', [
                'title'    => __('Inventor Watchdogs', 'inventor-watchdogs'),
                'priority' => 1,
            ]);
            // Watchdogs
            $wp_customize->add_setting('inventor_watchdogs_page', [
                'default'           => null,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_watchdogs_page', [
                'type'     => 'select',
                'label'    => __('Watchdogs', 'inventor-watchdogs'),
                'section'  => 'inventor_pages',
                'settings' => 'inventor_watchdogs_page',
                'choices'  => $pages,
            ]);
            // Listing logging
            $wp_customize->add_setting('inventor_watchdogs_enable_search_queries', [
                'default'           => false,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_watchdogs_enable_search_queries', [
                'type'     => 'checkbox',
                'label'    => __('Enable Search Queries Watchdogs', 'inventor-watchdogs'),
                'section'  => 'inventor_watchdogs',
                'settings' => 'inventor_watchdogs_enable_search_queries',
            ]);
        }
    }

    Inventor_Watchdogs_Customizations_Watchdogs::init();

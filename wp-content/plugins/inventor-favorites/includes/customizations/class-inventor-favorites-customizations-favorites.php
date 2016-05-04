<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Favorites_Customizations_Favorites.
     * @class  Inventor_Favorites_Customizations_Favorites
     * @author Pragmatic Mates
     */
    class Inventor_Favorites_Customizations_Favorites
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
            // Favorites
            $wp_customize->add_setting('inventor_favorites_page', [
                'default'           => null,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_favorites_page', [
                'type'     => 'select',
                'label'    => __('Favorite listings', 'inventor-favorites'),
                'section'  => 'inventor_pages',
                'settings' => 'inventor_favorites_page',
                'choices'  => $pages,
            ]);
        }
    }

    Inventor_Favorites_Customizations_Favorites::init();

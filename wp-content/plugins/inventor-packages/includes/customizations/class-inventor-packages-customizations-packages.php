<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Packages_Customizations_Packages.
     * @class  Inventor_Packages_Customizations_Packages
     * @author Pragmatic Mates
     */
    class Inventor_Packages_Customizations_Packages
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
            $wp_customize->add_section('inventor_packages', [
                'title'    => __('Inventor Packages', 'inventor-packages'),
                'priority' => 1,
            ]);
            $packages = Inventor_Packages_Logic::get_packages_choices(true, true, true, true);
            // Default package
            $wp_customize->add_setting('inventor_default_package', [
                'default'           => null,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_default_package', [
                'type'        => 'select',
                'label'       => __('Default package', 'inventor-packages'),
                'section'     => 'inventor_packages',
                'settings'    => 'inventor_default_package',
                'choices'     => $packages,
                'description' => __('For newly registered user', 'inventor-packages'),
            ]);
        }
    }

    Inventor_Packages_Customizations_Packages::init();

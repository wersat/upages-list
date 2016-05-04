<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Customizations_Stripe.
     *
     * @class  Inventor_Stripe_Customizations_Stripe
     *
     * @author Pragmatic Mates
     */
    class Inventor_Stripe_Customizations_Stripe
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
            $wp_customize->add_section('inventor_stripe', [
                'title' => __('Inventor Stripe', 'inventor-stripe'),
                'priority' => 1,
            ]);
            // Stripe Secret Key
            $wp_customize->add_setting('inventor_stripe_secret_key', [
                'default' => null,
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_stripe_secret_key', [
                'label' => __('Secret Key', 'inventor-stripe'),
                'section' => 'inventor_stripe',
                'settings' => 'inventor_stripe_secret_key',
            ]);
            // Stripe Publishable Key
            $wp_customize->add_setting('inventor_stripe_publishable_key', [
                'default' => null,
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_stripe_publishable_key', [
                'label' => __('Publishable Key', 'inventor-stripe'),
                'section' => 'inventor_stripe',
                'settings' => 'inventor_stripe_publishable_key',
            ]);
        }
    }

    Inventor_Stripe_Customizations_Stripe::init();

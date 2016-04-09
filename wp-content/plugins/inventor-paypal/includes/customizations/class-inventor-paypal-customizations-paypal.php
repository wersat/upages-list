<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Customizations_PayPal
     * @class   Inventor_PayPal_Customizations_PayPal
     * @package Inventor_PayPal/Classes/Customizations
     * @author  Pragmatic Mates
     */
    class Inventor_PayPal_Customizations_Paypal
    {
        /**
         * Initialize customization type
         * @access public
         * @return void
         */
        public static function init()
        {
            add_action('customize_register', [__CLASS__, 'customizations']);
        }

        /**
         * Customizations
         * @access public
         *
         * @param object $wp_customize
         *
         * @return void
         */
        public static function customizations($wp_customize)
        {
            $wp_customize->add_section('inventor_paypal', [
                'title'    => __('Inventor PayPal', 'inventor-paypal'),
                'priority' => 1,
            ]);
            // PayPal Client ID
            $wp_customize->add_setting('inventor_paypal_client_id', [
                'default'           => null,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_paypal_client_id', [
                'label'    => __('Client ID', 'inventor-paypal'),
                'section'  => 'inventor_paypal',
                'settings' => 'inventor_paypal_client_id',
            ]);
            // PayPal Client Secret
            $wp_customize->add_setting('inventor_paypal_client_secret', [
                'default'           => null,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_paypal_client_secret', [
                'label'    => __('Client Secret', 'inventor-paypal'),
                'section'  => 'inventor_paypal',
                'settings' => 'inventor_paypal_client_secret',
            ]);
            // PayPal Live Mode
            $wp_customize->add_setting('inventor_paypal_live', [
                'default'           => false,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_paypal_live', [
                'label'    => __('Live Mode', 'inventor-paypal'),
                'type'     => 'checkbox',
                'section'  => 'inventor_paypal',
                'settings' => 'inventor_paypal_live',
            ]);
            // Credit card
            $wp_customize->add_setting('inventor_paypal_credit_card', [
                'default'           => false,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_paypal_credit_card', [
                'label'    => __('Credit Card', 'inventor-paypal'),
                'type'     => 'checkbox',
                'section'  => 'inventor_paypal',
                'settings' => 'inventor_paypal_credit_card',
            ]);
        }
    }

    Inventor_PayPal_Customizations_Paypal::init();

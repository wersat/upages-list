<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Customizations_Invoices.
     * @class  Inventor_Invoices_Customizations_Invoices
     * @author Pragmatic Mates
     */
    class Inventor_Invoices_Customizations_Invoices
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
            $wp_customize->add_section('inventor_invoices', [
                'title'    => __('Inventor Invoices', 'inventor-invoices'),
                'priority' => 1,
            ]);
            // Invoices page
            $pages = Inventor_Utilities::get_pages();
            $wp_customize->add_setting('inventor_invoices_page', [
                'default'           => null,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_invoices_page', [
                'type'     => 'select',
                'label'    => __('Invoices', 'inventor-invoices'),
                'section'  => 'inventor_pages',
                'settings' => 'inventor_invoices_page',
                'choices'  => $pages,
            ]);
            // Payment term
            $wp_customize->add_setting('inventor_invoices_payment_term', [
                'default'           => 15,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_invoices_payment_term', [
                'label'       => __('Payment term', 'inventor-invoices'),
                'section'     => 'inventor_invoices',
                'settings'    => 'inventor_invoices_payment_term',
                'description' => __('In days', 'inventor-invoices'),
            ]);
            // Tax rate
            $wp_customize->add_setting('inventor_invoices_tax_rate', [
                'default'           => 0,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_invoices_tax_rate', [
                'label'       => __('Tax rate', 'inventor-invoices'),
                'section'     => 'inventor_invoices',
                'settings'    => 'inventor_invoices_tax_rate',
                'description' => __('In %', 'inventor-invoices'),
            ]);
            // Billing name
            $wp_customize->add_setting('inventor_invoices_billing_name', [
                'default'           => null,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_invoices_billing_name', [
                'label'    => __('Billing name', 'inventor-invoices'),
                'section'  => 'inventor_invoices',
                'settings' => 'inventor_invoices_billing_name',
            ]);
            // Billing registration number
            $wp_customize->add_setting('inventor_invoices_billing_registration_number', [
                'default'           => null,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_invoices_billing_registration_number', [
                'label'    => __('Reg. No.', 'inventor-invoices'),
                'section'  => 'inventor_invoices',
                'settings' => 'inventor_invoices_billing_registration_number',
            ]);
            // Billing VAT number
            $wp_customize->add_setting('inventor_invoices_billing_vat_number', [
                'default'           => null,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_invoices_billing_vat_number', [
                'label'    => __('VAT No.', 'inventor-invoices'),
                'section'  => 'inventor_invoices',
                'settings' => 'inventor_invoices_billing_vat_number',
            ]);
            // Billing details
            $wp_customize->add_setting('inventor_invoices_billing_details', [
                'default'           => null,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => ['Inventor_Utilities', 'sanitize_textarea'],
            ]);
            $wp_customize->add_control('inventor_invoices_billing_details', [
                'label'    => __('Billing details', 'inventor-invoices'),
                'section'  => 'inventor_invoices',
                'settings' => 'inventor_invoices_billing_details',
                'type'     => 'textarea',
            ]);
        }
    }

    Inventor_Invoices_Customizations_Invoices::init();

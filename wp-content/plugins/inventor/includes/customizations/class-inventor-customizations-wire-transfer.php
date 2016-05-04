<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Customizations_Wire_Transfer.
     *
     * @class  Inventor_Customizations_Submission
     * @author Pragmatic Mates
     */
class Inventor_Customizations_Wire_Transfer
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
        $wp_customize->add_section(
            'inventor_wire_transfer', [
            'title'    => __('Inventor Wire Transfer', 'inventor'),
            'priority' => 1,
            ]
        );
        // Account number
        $wp_customize->add_setting(
            'inventor_wire_transfer_account_number', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
            ]
        );
        $wp_customize->add_control(
            'inventor_wire_transfer_account_number', [
            'label'       => self::get_control_label('inventor_wire_transfer_account_number'),
            'section'     => 'inventor_wire_transfer',
            'settings'    => 'inventor_wire_transfer_account_number',
            'description' => __('Bank account number [mandatory]', 'inventor'),
            ]
        );
        // Bank code
        $wp_customize->add_setting(
            'inventor_wire_transfer_swift', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
            ]
        );
        $wp_customize->add_control(
            'inventor_wire_transfer_swift', [
            'label'       => self::get_control_label('inventor_wire_transfer_swift'),
            'section'     => 'inventor_wire_transfer',
            'settings'    => 'inventor_wire_transfer_swift',
            'description' => __('SWIFT or BIC of your bank [mandatory]', 'inventor'),
            ]
        );
        // Full name
        $wp_customize->add_setting(
            'inventor_wire_transfer_full_name', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
            ]
        );
        $wp_customize->add_control(
            'inventor_wire_transfer_full_name', [
            'label'       => self::get_control_label('inventor_wire_transfer_full_name'),
            'section'     => 'inventor_wire_transfer',
            'settings'    => 'inventor_wire_transfer_full_name',
            'description' => __('Your full name [mandatory]', 'inventor'),
            ]
        );
        // Street
        $wp_customize->add_setting(
            'inventor_wire_transfer_street', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
            ]
        );
        $wp_customize->add_control(
            'inventor_wire_transfer_street', [
            'label'       => self::get_control_label('inventor_wire_transfer_street'),
            'section'     => 'inventor_wire_transfer',
            'settings'    => 'inventor_wire_transfer_street',
            'description' => __('Enter your street.', 'inventor'),
            ]
        );
        // Postcode
        $wp_customize->add_setting(
            'inventor_wire_transfer_postcode', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
            ]
        );
        $wp_customize->add_control(
            'inventor_wire_transfer_postcode', [
            'label'       => self::get_control_label('inventor_wire_transfer_postcode'),
            'section'     => 'inventor_wire_transfer',
            'settings'    => 'inventor_wire_transfer_postcode',
            'description' => __('Enter your postcode (ZIP).', 'inventor'),
            ]
        );
        // City
        $wp_customize->add_setting(
            'inventor_wire_transfer_city', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
            ]
        );
        $wp_customize->add_control(
            'inventor_wire_transfer_city', [
            'label'       => self::get_control_label('inventor_wire_transfer_city'),
            'section'     => 'inventor_wire_transfer',
            'settings'    => 'inventor_wire_transfer_city',
            'description' => __('Enter your city.', 'inventor'),
            ]
        );
        // Country
        $wp_customize->add_setting(
            'inventor_wire_transfer_country', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
            ]
        );
        $wp_customize->add_control(
            'inventor_wire_transfer_country', [
            'label'       => self::get_control_label('inventor_wire_transfer_country'),
            'section'     => 'inventor_wire_transfer',
            'settings'    => 'inventor_wire_transfer_country',
            'description' => __('Enter your country [mandatory]', 'inventor'),
            ]
        );
    }

    /**
         * Returns control label by its id.
         *
         * @param string $id
         *
         * @return string
         */
    public static function get_control_label($id)
    {
        $labels = [
            'inventor_wire_transfer_account_number' => __('Account number', 'inventor'),
            'inventor_wire_transfer_swift'          => __('Bank code', 'inventor'),
            'inventor_wire_transfer_full_name'      => __('Full name', 'inventor'),
            'inventor_wire_transfer_street'         => __('Street / P.O.Box', 'inventor'),
            'inventor_wire_transfer_postcode'       => __('Postcode', 'inventor'),
            'inventor_wire_transfer_city'           => __('City', 'inventor'),
            'inventor_wire_transfer_country'        => __('Country', 'inventor'),
        ];

        return array_key_exists($id, $labels) ? $labels[$id] : $id;
    }
}

    Inventor_Customizations_Wire_Transfer::init();

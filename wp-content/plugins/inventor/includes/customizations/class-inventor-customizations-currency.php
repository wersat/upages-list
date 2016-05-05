<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Customizations_Currency.
     *
     * @class  Inventor_Customizations_Currency
     * @author Pragmatic Mates
     */
class Inventor_Customizations_Currency
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
            'inventor_currencies[0]', [
            'title'    => __('Inventor Currency', 'inventor'),
            'priority' => 1,
            ]
        );
//        // Currency symbol
//        $wp_customize->add_setting(
//            'inventor_currencies[0][symbol]', [
//            'default'           => '$',
//            'capability'        => 'edit_theme_options',
//            'sanitize_callback' => 'sanitize_text_field',
//            ]
//        );
//        $wp_customize->add_control(
//            'inventor_currencies[0][symbol]', [
//            'label'    => __('Currency Symbol', 'inventor'),
//            'section'  => 'inventor_currencies[0]',
//            'settings' => 'inventor_currencies[0][symbol]',
//            ]
//        );
        // Currency code
        $wp_customize->add_setting(
            'inventor_currencies[0][code]', [
            'default'           => 'USD',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
            ]
        );
        $wp_customize->add_control(
            'inventor_currencies[0][code]', [
            'label'    => __('Currency Code', 'inventor'),
            'section'  => 'inventor_currencies[0]',
            'settings' => 'inventor_currencies[0][code]',
            ]
        );
        // Show after
        $wp_customize->add_setting(
            'inventor_currencies[0][show_after]', [
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
            ]
        );
        $wp_customize->add_control(
            'inventor_currencies[0][show_after]', [
            'type'     => 'checkbox',
            'label'    => __('Show Symbol After Amount', 'inventor'),
            'section'  => 'inventor_currencies[0]',
            'settings' => 'inventor_currencies[0][show_after]',
            ]
        );
        // Decimal places
        $wp_customize->add_setting(
            'inventor_currencies[0][money_decimals]', [
            'default'           => 0,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
            ]
        );
        $wp_customize->add_control(
            'inventor_currencies[0][money_decimals]', [
            'label'    => __('Decimal places', 'inventor'),
            'section'  => 'inventor_currencies[0]',
            'settings' => 'inventor_currencies[0][money_decimals]',
            'type'     => 'select',
            'choices'  => [
                0 => '0',
                1 => '1',
                2 => '2',
            ],
            ]
        );
        // Decimal Separator
        $wp_customize->add_setting(
            'inventor_currencies[0][money_dec_point]', [
            'default'           => '.',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
            ]
        );
        $wp_customize->add_control(
            'inventor_currencies[0][money_dec_point]', [
            'label'    => __('Decimal Separator', 'inventor'),
            'section'  => 'inventor_currencies[0]',
            'settings' => 'inventor_currencies[0][money_dec_point]',
            'type'     => 'select',
            'choices'  => [
                '.' => __('. (dot)', 'inventor-currencies'),
                ',' => __(', (comma)', 'inventor-currencies'),
            ],
            ]
        );
        // Thousands Separator
        $wp_customize->add_setting(
            'inventor_currencies[0][money_thousands_separator]', [
            'default'           => ',',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
            ]
        );
        $wp_customize->add_control(
            'inventor_currencies[0][money_thousands_separator]', [
            'label'    => __('Thousands Separator', 'inventor'),
            'section'  => 'inventor_currencies[0]',
            'settings' => 'inventor_currencies[0][money_thousands_separator]',
            'type'     => 'select',
            'choices'  => [
                '.'     => __('. (dot)', 'inventor-currencies'),
                ','     => __(', (comma)', 'inventor-currencies'),
                'space' => __('" " (space)', 'inventor-currencies'),
                ''      => __('"" (empty string)', 'inventor-currencies'),
            ],
            ]
        );
    }
}

    Inventor_Customizations_Currency::init();

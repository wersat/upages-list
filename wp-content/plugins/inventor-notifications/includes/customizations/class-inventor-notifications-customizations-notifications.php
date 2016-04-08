<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Customizations_Notifications.
     * @class  Inventor_Notifications_Customizations_Notifications
     * @author Pragmatic Mates
     */
    class Inventor_Notifications_Customizations_Notifications
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
            $wp_customize->add_section('inventor_notifications', [
                'title'    => __('Inventor Notifications', 'inventor-notifications'),
                'priority' => 1,
            ]);
            // Package expiration warning
            $wp_customize->add_setting('inventor_notifications_package_will_expire', [
                'default'           => false,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_notifications_package_will_expire', [
                'label'    => __('Package expiration warning', 'inventor-notifications'),
                'type'     => 'checkbox',
                'section'  => 'inventor_notifications',
                'settings' => 'inventor_notifications_package_will_expire',
            ]);
            // Package expiration warning threshold
            $wp_customize->add_setting('inventor_notifications_package_expiration_warning_threshold', [
                'sanitize_callback' => 'sanitize_text_field',
                'default'           => 7,
            ]);
            $wp_customize->add_control('inventor_notifications_package_expiration_warning_threshold', [
                'label'       => __('Package expiration warning threshold', 'inventor-notifications'),
                'type'        => 'select',
                'section'     => 'inventor_notifications',
                'settings'    => 'inventor_notifications_package_expiration_warning_threshold',
                'choices'     => [
                    3  => __('3 days', 'inventor_notifications'),
                    7  => __('7 days', 'inventor_notifications'),
                    14 => __('14 days', 'inventor_notifications'),
                    30 => __('30 days', 'inventor_notifications'),
                ],
                'description' => __('Set threshold in days.', 'inventor_notifications'),
            ]);
            // Package expiration announcement
            $wp_customize->add_setting('inventor_notifications_package_expired', [
                'default'           => false,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_notifications_package_expired', [
                'label'       => __('Package expiration announcement', 'inventor-notifications'),
                'type'        => 'checkbox',
                'section'     => 'inventor_notifications',
                'settings'    => 'inventor_notifications_package_expired',
                'description' => __('One day before package expiration.', 'inventor_notifications'),
            ]);
            // Pending submission waiting for review - for admin
            $wp_customize->add_setting('inventor_notifications_submission_pending_admin', [
                'default'           => false,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_notifications_submission_pending_admin', [
                'label'       => __('Submission waiting for review', 'inventor-notifications'),
                'type'        => 'checkbox',
                'section'     => 'inventor_notifications',
                'settings'    => 'inventor_notifications_submission_pending_admin',
                'description' => __('For admin', 'inventor_notifications'),
            ]);
            // Submission waiting for review - for user
            $wp_customize->add_setting('inventor_notifications_submission_pending_user', [
                'default'           => false,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_notifications_submission_pending_user', [
                'label'       => __('Submission waiting for review', 'inventor-notifications'),
                'type'        => 'checkbox',
                'section'     => 'inventor_notifications',
                'settings'    => 'inventor_notifications_submission_pending_user',
                'description' => __('For user', 'inventor_notifications'),
            ]);
            // Submission published - for admin
            $wp_customize->add_setting('inventor_notifications_submission_published_admin', [
                'default'           => false,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_notifications_submission_published_admin', [
                'label'       => __('Submission published', 'inventor-notifications'),
                'type'        => 'checkbox',
                'section'     => 'inventor_notifications',
                'settings'    => 'inventor_notifications_submission_published_admin',
                'description' => __('For admin', 'inventor_notifications'),
            ]);
            // Submission published - for user
            $wp_customize->add_setting('inventor_notifications_submission_published_user', [
                'default'           => false,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_notifications_submission_published_user', [
                'label'       => __('Submission published', 'inventor-notifications'),
                'type'        => 'checkbox',
                'section'     => 'inventor_notifications',
                'settings'    => 'inventor_notifications_submission_published_user',
                'description' => __('For user', 'inventor_notifications'),
            ]);
        }
    }

    Inventor_Notifications_Customizations_Notifications::init();

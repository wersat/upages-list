<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Jobs_Customizations_Jobs.
     * @class  Inventor_Jobs_Customizations_Jobs
     * @author Pragmatic Mates
     */
    class Inventor_Jobs_Customizations_Jobs
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
            if (in_array('resume', Inventor_Post_Types::get_listing_post_types())) {
                // Apply for a job
                $wp_customize->add_setting('inventor_jobs_apply_page', [
                    'default'           => null,
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'sanitize_text_field',
                ]);
                $wp_customize->add_control('inventor_jobs_apply_page', [
                    'type'     => 'select',
                    'label'    => __('Apply for job', 'inventor-jobs'),
                    'section'  => 'inventor_pages',
                    'settings' => 'inventor_jobs_apply_page',
                    'choices'  => $pages,
                ]);
                // Job applicants
                $wp_customize->add_setting('inventor_jobs_applicants_page', [
                    'default'           => null,
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'sanitize_text_field',
                ]);
                $wp_customize->add_control('inventor_jobs_applicants_page', [
                    'type'     => 'select',
                    'label'    => __('Job applicants', 'inventor-jobs'),
                    'section'  => 'inventor_pages',
                    'settings' => 'inventor_jobs_applicants_page',
                    'choices'  => $pages,
                ]);
            }
        }
    }

    Inventor_Jobs_Customizations_Jobs::init();

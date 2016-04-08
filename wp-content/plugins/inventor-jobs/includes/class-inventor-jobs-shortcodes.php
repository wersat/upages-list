<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Jobs_Shortcodes.
     * @class  Inventor_Jobs_Shortcodes
     * @author Pragmatic Mates
     */
    class Inventor_Jobs_Shortcodes
    {
        /**
         * Initialize shortcodes.
         */
        public static function init()
        {
            add_shortcode('inventor_jobs_apply_form', [__CLASS__, 'jobs_apply_form']);
            add_shortcode('inventor_jobs_applicants', [__CLASS__, 'jobs_applicants']);
        }

        /**
         * Apply for a job form.
         *
         * @param $atts
         */
        public static function jobs_apply_form($atts)
        {
            if ( ! is_user_logged_in()) {
                echo Inventor_Template_Loader::load('misc/not-allowed');

                return;
            }
            $listing = Inventor_Post_Types::get_listing($_GET['id']);
            if ('job' != get_post_type($listing)) {
                echo Inventor_Template_Loader::load('misc/not-allowed',
                    ['message' => esc_attr__('Listing is not a job.', 'inventor-jobs')]);
            }
            $user_resumes_query = Inventor_Jobs_Logic::get_user_resumes(get_current_user_id());
            $attrs              = [
                'job'     => $listing,
                'resumes' => $user_resumes_query->posts,
            ];
            echo Inventor_Template_Loader::load('jobs-apply-form', $attrs, $plugin_dir = INVENTOR_JOBS_DIR);
        }

        /**
         * List of job applicants.
         *
         * @param $atts
         */
        public static function jobs_applicants($atts)
        {
            print_r($_GET);
        }
    }

    Inventor_Jobs_Shortcodes::init();

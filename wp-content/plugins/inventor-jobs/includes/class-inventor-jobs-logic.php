<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Jobs_Logic.
     * @class  Inventor_Jobs_Logic
     * @author Pragmatic Mates
     */
    class Inventor_Jobs_Logic
    {
        /**
         * Initialize Jobs functionality.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'process_apply_form'], 9999);
            add_action('wp_ajax_nopriv_inventor_jobs_ajax_can_apply', [__CLASS__, 'ajax_can_apply']);
            add_action('wp_ajax_inventor_jobs_ajax_can_apply', [__CLASS__, 'ajax_can_apply']);
            add_action('inventor_listing_detail', [__CLASS__, 'render_total_job_applications'], 1, 1);
            add_action('inventor_submission_list_row_actions', [__CLASS__, 'render_applicants_button'], 10, 1);
            add_filter('inventor_mail_actions_choices', [__CLASS__, 'mail_actions_choices']);
        }

        /**
         * Adds jobs mail actions.
         *
         * @param array $choices
         *
         * @return array
         */
        public static function mail_actions_choices($choices)
        {
            $choices[INVENTOR_MAIL_ACTION_NEW_JOB_APPLICATION] = __('New job application', 'inventor-jobs');

            return $choices;
        }

        /**
         * Ajax request. Checks if user can apply for a job.
         * @return string
         */
        public static function ajax_can_apply()
        {
            header('HTTP/1.0 200 OK');
            header('Content-Type: application/json');
            if ( ! empty($_GET['id'])) {
                $job_already_assigned = self::job_is_assigned($_GET['id']);
                if ($job_already_assigned) {
                    $data = [
                        'success' => false,
                        'message' => __('Job was already assigned to user.', 'inventor-jobs'),
                    ];
                } else {
                    $user_already_applied = self::user_already_applied($_GET['id'], get_current_user_id());
                    if ($user_already_applied) {
                        $data = [
                            'success' => false,
                            'message' => __('You already applied for this job.', 'inventor-jobs'),
                        ];
                    } else {
                        $data = [
                            'success' => true,
                        ];
                    }
                }
            } else {
                $data = [
                    'success' => false,
                    'message' => __('Job ID is missing.', 'inventor-jobs'),
                ];
            }
            echo json_encode($data);
            exit();
        }

        /**
         * Checks if job is already assigned to user.
         *
         * @param $job_id int
         *
         * @return bool
         */
        public static function job_is_assigned($job_id)
        {
            $assigned_to = get_post_meta($job_id, INVENTOR_LISTING_PREFIX . 'job_assigned_to', true);

            return ! empty($assigned_to);
        }

        /**
         * Checks if user already applied for specified job.
         *
         * @param $job_id  int
         * @param $user_id int
         *
         * @return bool
         */
        public static function user_already_applied($job_id, $user_id)
        {
            $application = self::get_user_application($job_id, $user_id);

            return ! empty($application);
        }

        /**
         * Returns application by user_id and job_id.
         *
         * @param $job_id  int
         * @param $user_id int
         *
         * @return object
         */
        public static function get_user_application($job_id, $user_id)
        {
            $wp_query = new WP_Query([
                'post_type'   => 'application',
                'post_status' => 'any',
                'author'      => $user_id,
                'meta_query'  => [
                    [
                        'key'   => INVENTOR_APPLICATION_PREFIX . 'job_id',
                        'value' => $job_id,
                    ],
                ],
            ]);
            if ($wp_query->post_count <= 0) {
                return;
            }

            return $wp_query->posts[0];
        }

        /**
         * Returns query of user resumes.
         *
         * @param int $user_id
         *
         * @return WP_Query
         */
        public static function get_user_resumes($user_id)
        {
            return new WP_Query([
                'author'         => $user_id,
                'post_type'      => 'resume',
                'posts_per_page' => -1,
                'post_status'    => 'any',
            ]);
        }

        /**
         * Renders job apply button.
         *
         * @param int $listing_id
         */
        public static function render_apply_button($listing_id)
        {
            if (is_user_logged_in() && 'job' == get_post_type($listing_id)) {
                $config      = self::get_config();
                $apply_page  = $config['apply_page'];
                $is_assigned = self::job_is_assigned($listing_id);
                $attrs = [
                    'job_id'      => $listing_id,
                    'apply_page'  => $apply_page,
                    'is_assigned' => $is_assigned,
                ];
                echo Inventor_Template_Loader::load('jobs-apply-button', $attrs, $plugin_dir = INVENTOR_JOBS_DIR);
            }
        }

        /**
         * Gets config.
         * @return array
         */
        public static function get_config()
        {
            $apply_page = get_theme_mod('inventor_jobs_apply_page', false);
            $config = [
                'apply_page' => $apply_page,
            ];

            return $config;
        }

        /**
         * Renders total job users info.
         *
         * @param int $listing_id
         */
        public static function render_total_job_applications($listing_id)
        {
            if ('job' == get_post_type($listing_id)
                && in_array('resume', Inventor_Post_Types::get_listing_post_types())
            ) {
                $total_applications = self::get_total_job_applications($listing_id);
                echo Inventor_Template_Loader::load('jobs-applications-total',
                    ['total_applications' => $total_applications], $plugin_dir = INVENTOR_JOBS_DIR);
            }
        }

        /**
         * Returns total job applications.
         *
         * @param int $job_id
         *
         * @return int
         */
        public static function get_total_job_applications($job_id)
        {
            $wp_query = new WP_Query([
                'post_type'   => 'application',
                'post_status' => 'any',
                'meta_query'  => [
                    [
                        'key'   => INVENTOR_APPLICATION_PREFIX . 'job_id',
                        'value' => $job_id,
                    ],
                ],
            ]);

            return $wp_query->post_count;
        }

        /**
         * Process apply form.
         */
        public static function process_apply_form()
        {
            if ( ! isset($_POST['jobs_apply_form']) || empty($_POST['job_id'])) {
                return;
            }
            $user_already_applied = self::user_already_applied($_POST['job_id'], get_current_user_id());
            if ($user_already_applied) {
                $_SESSION['messages'][] = ['danger', __('You already applied for this job.', 'inventor-jobs')];

                return;
            }
            $job       = get_post($_POST['job_id']);
            $resume    = get_post($_POST['resume']);
            $user_id   = $resume->post_author;
            $user_data = get_userdata($user_id);
            $name      = $user_data->display_name;
            $email     = $user_data->user_email; // get_the_author_meta( 'user_email', $job->post_author );
            $message   = esc_html($_POST['message']);
            $headers = sprintf("From: %s <%s>\r\n Content-type: text/html", $name, $email);
            # template args
            $template_args = [
                'job'     => get_the_title($job),
                'resume'  => get_the_title($resume),
                'url'     => get_permalink($job->ID),
                'name'    => $name,
                'email'   => $email,
                'message' => $message,
            ];
            # subject
            $subject = __(sprintf('New %s application', get_the_title($job)), 'inventor-jobs');
            $subject = apply_filters('inventor_mail_subject', $subject, INVENTOR_MAIL_ACTION_NEW_JOB_APPLICATION,
                $template_args);
            # body
            $body = '';
            $body = apply_filters('inventor_mail_body', $body, INVENTOR_MAIL_ACTION_NEW_JOB_APPLICATION,
                $template_args);
            if (empty($body)) {
                ob_start();
                include Inventor_Template_Loader::locate('jobs-apply-mail', $plugin_dir = INVENTOR_JOBS_DIR);
                $body = ob_get_contents();
                ob_end_clean();
            }
            # recipients
            $emails = [];
            # author
            $emails[] = get_the_author_meta('user_email', $job->post_author);
            $emails = array_unique($emails);
            foreach ($emails as $email) {
                $status = wp_mail($email, $subject, $body, $headers);
            }
            if ( ! empty($status) && 1 == $status) {
                self::save_application($job->ID, $resume->ID, $message);
                $_SESSION['messages'][] = ['success', __('Message has been successfully sent.', 'inventor-jobs')];
            } else {
                $_SESSION['messages'][] = ['danger', __('Unable to send a message.', 'inventor-jobs')];
            }
            wp_redirect(get_the_permalink($job->ID));
            exit();
        }

        /**
         * Saves application.
         *
         * @param $job_id    int
         * @param $resume_id int
         * @param $message   string
         *
         * @return int
         */
        public static function save_application($job_id, $resume_id, $message)
        {
            $resume    = get_post($resume_id);
            $user_id   = $resume->post_author;
            $user_data = get_userdata($user_id);
            $name      = $user_data->display_name;
            $application_id = wp_insert_post([
                'post_type'    => 'application',
                'post_status'  => 'publish',
                'post_author'  => $user_id,
                'post_title'   => $name,
                'post_content' => $message,
            ]);
            update_post_meta($application_id, INVENTOR_APPLICATION_PREFIX . 'job_id', $job_id);
            update_post_meta($application_id, INVENTOR_APPLICATION_PREFIX . 'resume_id', $resume_id);

            return $application_id;
        }

        /**
         * Renders applicants button for specified job.
         *
         * @param $listing_id int
         */
        public static function render_applicants_button($listing_id)
        {
            if ('job' == get_post_type($listing_id)
                && in_array('resume', Inventor_Post_Types::get_listing_post_types())
            ) {
                $jobs_applicants_page_id = get_theme_mod('inventor_jobs_applicants_page', false);
                if ( ! empty($jobs_applicants_page_id)) {
                    $attrs = [
                        'page_id'          => $jobs_applicants_page_id,
                        'job_id'           => $listing_id,
                        'total_applicants' => self::get_total_job_applications($listing_id),
                    ];
                    echo Inventor_Template_Loader::load('jobs-applicants-button', $attrs,
                        $plugin_dir = INVENTOR_JOBS_DIR);
                }
            }
        }
    }

    Inventor_Jobs_Logic::init();

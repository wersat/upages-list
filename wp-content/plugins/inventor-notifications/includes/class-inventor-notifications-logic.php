<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Notifications_Logic.
     * @class  Inventor_Notifications_Logic
     * @author Pragmatic Mates
     */
    class Inventor_Notifications_Logic
    {
        /**
         * Initialize Notifications functionality.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'hook_post_statuses'], 10);
            # set notification emails
            add_action('future_to_publish', [__CLASS__, 'process_notification'], 10, 1);
            # catch package change
            add_action('inventor_user_package_was_set', [__CLASS__, 'create_package_expiration_notifications'], 10, 1);
            # add mail actions for mail templates
            add_filter('inventor_mail_actions_choices', [__CLASS__, 'mail_actions_choices']);
        }

        /**
         * Adds mail actions for package and submission system.
         *
         * @param array $choices
         *
         * @return array
         */
        public static function mail_actions_choices($choices)
        {
            # packages
            $choices[INVENTOR_MAIL_ACTION_PACKAGE_WILL_EXPIRE] = __('Package will expire', 'inventor-notifications');
            $choices[INVENTOR_MAIL_ACTION_PACKAGE_EXPIRED]     = __('Package expired', 'inventor-notifications');
            # submissions
            $choices[INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_ADMIN]   = __('Submission waiting for review - for admin',
                'inventor-notifications');
            $choices[INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_USER]    = __('Submission waiting for review - for user',
                'inventor-notifications');
            $choices[INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_ADMIN] = __('Submission published - for admin',
                'inventor-notifications');
            $choices[INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_USER]  = __('Submission published - for user',
                'inventor-notifications');

            return $choices;
        }

        /**
         * Returns types for notification post type.
         * @return array
         */
        public static function get_notification_types()
        {
            return self::mail_actions_choices([]);
        }

        /**
         * Gets Notifications config.
         * This config is used for custom actions triggering.
         * @return array|bool
         */
        public static function get_config()
        {
            $package_will_expire_enabled        = get_theme_mod('inventor_notifications_package_will_expire', false);
            $package_expiration_warning_threshold
                                                = get_theme_mod('inventor_notifications_package_expiration_warning_threshold',
                false);
            $package_expired_enabled            = get_theme_mod('inventor_notifications_package_expired', false);
            $submission_pending_admin_enabled   = get_theme_mod('inventor_notifications_submission_pending_admin',
                false);
            $submission_pending_user_enabled    = get_theme_mod('inventor_notifications_submission_pending_user',
                false);
            $submission_published_admin_enabled = get_theme_mod('inventor_notifications_submission_published_admin',
                false);
            $submission_published_user_enabled  = get_theme_mod('inventor_notifications_submission_published_user',
                false);
            $notifications_config = [
                'package_will_expire_enabled'          => $package_will_expire_enabled,
                'package_expiration_warning_threshold' => $package_expiration_warning_threshold,
                'package_expired_enabled'              => $package_expired_enabled,
                'submission_pending_admin_enabled'     => $submission_pending_admin_enabled,
                'submission_pending_user_enabled'      => $submission_pending_user_enabled,
                'submission_published_admin_enabled'   => $submission_published_admin_enabled,
                'submission_published_user_enabled'    => $submission_published_user_enabled,
            ];

            return $notifications_config;
        }

        /**
         * Catches post status changes
         * This config is used for custom actions triggering.
         * @return array|bool
         */
        public static function hook_post_statuses()
        {
            # new submission was published (with or without admin review need)
            add_action('transition_post_status', [__CLASS__, 'create_submission_published_notifications'], 10, 3);
            foreach (Inventor_Post_Types::get_listing_post_types() as $listing_type) {
                # new submission was created but needs to be reviewed
                add_action(sprintf('pending_%s', $listing_type), [__CLASS__, 'create_submission_pending_notifications'],
                    10, 1);
            }
        }

        /**
         * Gets user notifications by action.
         *
         * @param int    $user_id
         * @param string $action
         *
         * @return WP_Query
         */
        public static function get_notifications_by_user($user_id, $actions = [], $status = 'any')
        {
            $query = [
                'author'         => $user_id,
                'post_type'      => 'notification',
                'posts_per_page' => -1,
                'post_status'    => $status,
            ];
            if (count($actions) > 0) {
                $query['meta_key']     = INVENTOR_NOTIFICATION_PREFIX . 'action';
                $query['meta_value']   = $actions;
                $query['meta_compare'] = 'IN';
            }

            return new WP_Query($query);
        }

        /**
         * Process scheduled notification.
         *
         * @param $post
         */
        public static function process_notification($post)
        {
            if ($post->post_type == 'notification') {
                $config = self::get_config();
                $action = get_post_meta($post->ID, INVENTOR_NOTIFICATION_PREFIX . 'action', true);
                if (INVENTOR_MAIL_ACTION_PACKAGE_WILL_EXPIRE == $action && ! $config['package_will_expire_enabled'] || INVENTOR_MAIL_ACTION_PACKAGE_EXPIRED == $action && ! $config['package_expired_enabled'] || INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_ADMIN == $action && ! $config['submission_pending_admin_enabled'] || INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_USER == $action && ! $config['submission_pending_user_enabled'] || INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_ADMIN == $action && ! $config['submission_published_admin_enabled'] || INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_USER == $action && ! $config['submission_published_user_enabled']) {
                    return;
                }
                self::sent_email($post);
            }
        }

        /**
         * Sent notification email.
         *
         * @param $notification
         */
        public static function sent_email($notification)
        {
            # recipient
            $author_email = get_the_author_meta('user_email', $notification->post_author);
            $author_name  = get_the_author_meta('display_name', $notification->post_author);
            $to           = $author_name . '<' . $author_email . '>';
            # subject
            $subject = get_the_title($notification->ID);
            # body
            $message = $notification->post_content;
            # admin
            $admin_email = get_bloginfo('admin_email');
            $admin       = get_user_by('email', $admin_email);
            $admin_name  = $admin->user_nicename;
            # headers
            $headers = sprintf("From: %s <%s>\r\n Content-type: text/html", $admin_name, $admin_email);
            $result = wp_mail($to, $subject, $message, $headers);
        }

        /**
         * Get default title by action.
         *
         * @param $action
         * @param $object
         *
         * @return string
         */
        public static function get_title_by_action($action, $object)
        {
            $config    = self::get_config();
            $threshold = $config['package_expiration_warning_threshold'];
            $args = ['object' => $object];
            switch ($action) {
                case INVENTOR_MAIL_ACTION_PACKAGE_WILL_EXPIRE:
                    $args  = ['package' => $object, 'threshold' => $threshold];
                    $title = __('Your package will expire soon', 'inventor-notifications');
                    break;
                case INVENTOR_MAIL_ACTION_PACKAGE_EXPIRED:
                    $args  = ['package' => $object];
                    $title = __('Your package expired', 'inventor-notifications');
                    break;
                case INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_ADMIN:
                    $args  = ['listing' => $object];
                    $title = __('New submission waiting for review', 'inventor-notifications');
                    break;
                case INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_USER:
                    $args  = ['listing' => $object];
                    $title = __('Submission waiting for review', 'inventor-notifications');
                    break;
                case INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_ADMIN:
                    $args  = ['listing' => $object];
                    $title = __('New submission was published', 'inventor-notifications');
                    break;
                case INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_USER:
                    $args  = ['listing' => $object];
                    $title = __('Your submission was published', 'inventor-notifications');
                    break;
                default:
                    $title = $action;
            }
            $title = apply_filters('inventor_mail_subject', $title, $action, $args);

            return $title;
        }

        /**
         * Get default content by action.
         *
         * @param $action
         * @param $object
         *
         * @return string
         */
        public static function get_content_by_action($action, $object)
        {
            $config    = self::get_config();
            $threshold = $config['package_expiration_warning_threshold'];
            $args = ['object' => $object];
            switch ($action) {
                case INVENTOR_MAIL_ACTION_PACKAGE_WILL_EXPIRE:
                    $args    = ['package' => $object, 'threshold' => $threshold];
                    $content = sprintf(__('Your package %s will expire in %d days.', 'inventor-notifications'), $object,
                        $threshold);
                    break;
                case INVENTOR_MAIL_ACTION_PACKAGE_EXPIRED:
                    $args    = ['package' => $object];
                    $content = sprintf(__('Your package %s expired.', 'inventor-notifications'), $object);
                    break;
                case INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_ADMIN:
                    $args    = ['listing' => $object];
                    $content = sprintf(__('New pending submission %s is waiting for admin review.',
                        'inventor-notifications'), $object);
                    break;
                case INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_USER:
                    $args = ['listing' => $object];
                    $content
                          = sprintf(__('Your submission %s is waiting for admin review. Until then, it will be not published.',
                        'inventor-notifications'), $object);
                    break;
                case INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_ADMIN:
                    $args    = ['listing' => $object];
                    $content = sprintf(__('New submission %s was published.', 'inventor-notifications'), $object);
                    break;
                case INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_USER:
                    $args    = ['listing' => $object];
                    $content = sprintf(__('Your submission %s was published.', 'inventor-notifications'), $object);
                    break;
                default:
                    $content = $action;
            }
            $content = apply_filters('inventor_mail_body', $content, $action, $args);

            return $content;
        }

        /**
         * Create notification.
         *
         * @param $action
         * @param $object
         * @param $user_id
         * @param $schedule_date
         */
        public static function create_notification($action, $object, $user_id, $schedule_date = null)
        {
            if ($schedule_date == null) {
                $schedule_date = strtotime('now') + 60;
            }
            $notification_id = wp_insert_post([
                'post_type'     => 'notification',
                'post_title'    => self::get_title_by_action($action, $object),
                'post_content'  => self::get_content_by_action($action, $object),
                'post_status'   => 'future',
                'post_author'   => $user_id,
                'post_date'     => date('Y-m-d H:i:s', $schedule_date),
                'post_date_gmt' => date('Y-m-d H:i:s', $schedule_date),
            ]);
            update_post_meta($notification_id, INVENTOR_NOTIFICATION_PREFIX . 'action', $action);
        }

        /**
         * Create admin and user notifications for published submission.
         *
         * @param $new_status
         * @param $old_status
         * @param $post
         */
        public static function create_submission_published_notifications($new_status, $old_status, $post)
        {
            $post_type          = get_post_type($post);
            $listing_post_types = Inventor_Post_Types::get_listing_post_types();
            $config             = self::get_config();
            if ( ! in_array($post_type, $listing_post_types)) {
                return;
            }
            if ($new_status != 'publish'
                || ! in_array($old_status, ['new', 'auto-draft', 'draft', 'pending', 'future'])
            ) {
                return;
            }
            // admin does not have to be informed about published submission he reviewed himself
            if ($config['submission_published_admin_enabled']
                && ! get_theme_mod('inventor_submission_review_before', false)
            ) {
                $object = get_the_title($post);
                // notify admins
                $admins = get_super_admins();
                foreach ($admins as $admin) {
                    $user    = get_user_by('login', $admin);
                    $user_id = $user->ID;
                    self::create_notification(INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_ADMIN, $object, $user_id);
                }
            }
            // notify post author
            if ($config['submission_published_user_enabled']) {
                $object  = get_the_title($post);
                $user_id = $post->post_author;
                self::create_notification(INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_USER, $object, $user_id);
            }
        }

        /**
         * Create admin and user notifications for pending submission.
         *
         * @param $listing
         */
        public static function create_submission_pending_notifications($post_id)
        {
            $config = self::get_config();
            $object = get_the_title($post_id);
            // notify user
            if ($config['submission_pending_user_enabled']) {
                $post    = get_post($post_id);
                $user_id = $post->post_author;
                self::create_notification(INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_USER, $object, $user_id);
            }
            // notify admins
            if ($config['submission_pending_admin_enabled']) {
                $admins = get_super_admins();
                foreach ($admins as $admin) {
                    $user    = get_user_by('login', $admin);
                    $user_id = $user->ID;
                    self::create_notification(INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_ADMIN, $object, $user_id);
                }
            }
        }

        /**
         * Create notifications for package expiration.
         *
         * @param $post
         */
        public static function create_package_expiration_notifications($user_id)
        {
            $existing_notifications = self::get_notifications_by_user(1,
                [INVENTOR_MAIL_ACTION_PACKAGE_WILL_EXPIRE, INVENTOR_MAIL_ACTION_PACKAGE_EXPIRED]);
            foreach ($existing_notifications->posts as $notification) {
                wp_trash_post($notification->ID);
            }
            if (class_exists('Inventor_Packages_Logic')) {
                $package     = Inventor_Packages_Logic::get_package_for_user($user_id);
                $object      = get_the_title($package);
                $valid_until = Inventor_Packages_Logic::get_package_valid_date_for_user($user_id, false);
                $config      = self::get_config();
                if ( ! $valid_until) {
                    return;
                }
                if ($config['package_expired_enabled']) {
                    self::create_notification(INVENTOR_MAIL_ACTION_PACKAGE_EXPIRED, $object, $user_id, $valid_until);
                }
                if ($config['package_will_expire_enabled']) {
                    $threshold     = $config['package_expiration_warning_threshold'];
                    $schedule_date = $valid_until - $threshold * 60 * 60 * 24;
                    self::create_notification(INVENTOR_MAIL_ACTION_PACKAGE_WILL_EXPIRE, $object, $user_id,
                        $schedule_date);
                }
            }
        }
    }

    Inventor_Notifications_Logic::init();

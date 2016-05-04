<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Mail_Templates_Logic.
     * @class  Inventor_Mail_Templates_Logic
     * @author Pragmatic Mates
     */
    class Inventor_Mail_Templates_Logic
    {
        /**
         * Initialize filtering.
         */
        public static function init()
        {
            add_filter('inventor_mail_subject', [__CLASS__, 'mail_template_subject'], 10, 3);
            add_filter('inventor_mail_body', [__CLASS__, 'mail_template_body'], 10, 3);
        }

        /**
         * Modifies mail template subject.
         * @return array
         */
        public static function mail_template_subject($subject, $action, $args)
        {
            $mail_template = self::get_mail_template_by_action($action);
            if ( ! empty($mail_template)) {
                $title = get_the_title($mail_template);

                return self::pass_variables($title, $args);
            }

            return $subject;
        }

        /**
         * Returns mail template by action.
         *
         * @param string $action
         *
         * @return object
         */
        public static function get_mail_template_by_action($action)
        {
            $query = new WP_Query([
                'post_type'      => 'mail_template',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'meta_key'       => INVENTOR_MAIL_TEMPLATE_PREFIX . 'action',
                'meta_value'     => $action,
            ]);
            if (count($query->posts) > 0) {
                return $query->posts[0];
            }

            return;
        }

        /**
         * Replaces occurrences of all found variables.
         *
         * @param $string string
         * @param $args   array
         *
         * @return array
         */
        public static function pass_variables($string, $args)
        {
            $variable_names  = [];
            $variable_values = [];
            foreach ($args as $key => $value) {
                $variable_names[]  = sprintf('{%s}', $key);
                $variable_values[] = $value;
            }

            return str_replace($variable_names, $variable_values, $string);
        }

        /**
         * Modifies mail template body.
         * @return array
         */
        public static function mail_template_body($body, $action, $args)
        {
            $mail_template = self::get_mail_template_by_action($action);
            if ( ! empty($mail_template)) {
                $content = $mail_template->post_content;
                $content = apply_filters('the_content', $content);
                $content = str_replace(']]>', ']]&gt;', $content);

                return self::pass_variables($content, $args);
            }

            return $body;
        }
    }

    Inventor_Mail_Templates_Logic::init();

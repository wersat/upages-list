<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Reports.
     *
     * @class  Inventor_Reports
     * @author Pragmatic Mates
     */
class Inventor_Reports
{
    /**
         * Initialize Reports functionality.
         */
    public static function init()
    {
        add_action('init', [__CLASS__, 'process_report_form'], 9999);
        add_filter('inventor_mail_actions_choices', [__CLASS__, 'mail_actions_choices']);
    }

    /**
         * Adds report mail action.
         *
         * @param array $choices
         *
         * @return array
         */
    public static function mail_actions_choices($choices)
    {
        $choices[INVENTOR_MAIL_ACTION_REPORTED_LISTING] = __('Listing was reported', 'inventor');

        return $choices;
    }

    /**
         * Gets config.
     *
         * @return array
         */
    public static function get_config()
    {
        $page   = get_theme_mod('inventor_general_report_page', false);
        $config = [
            'page' => $page,
        ];

        return $config;
    }

    /**
         * Process report form.
         */
    public static function process_report_form()
    {
        if (! isset($_POST['report_form']) || empty($_POST['listing_id'])) {
            return;
        }
        $listing = get_post($_POST['listing_id']);
        $reason  = esc_html($_POST['reason']);
        $email   = esc_html($_POST['email']);
        $name    = esc_html($_POST['name']);
        $message = esc_html($_POST['message']);
        $headers = sprintf("From: %s <%s>\r\n Content-type: text/html", $name, $email);
        // template args
        $template_args = [
            'listing' => get_the_title($listing),
            'url'     => get_permalink($listing->ID),
            'name'    => $name,
            'email'   => $email,
            'reason'  => $reason,
            'message' => $message,
        ];
        // subject
        $subject = __(sprintf('%s has been reported', get_the_title($listing)), 'inventor');
        $subject = apply_filters(
            'inventor_mail_subject', $subject, INVENTOR_MAIL_ACTION_REPORTED_LISTING,
            $template_args
        );
        // body
        $body = '';
        $body = apply_filters('inventor_mail_body', $body, INVENTOR_MAIL_ACTION_REPORTED_LISTING, $template_args);
        if (empty($body)) {
            ob_start();
            include Inventor_Template_Loader::locate('mails/report');
            $body = ob_get_contents();
            ob_end_clean();
        }
        // recipients
        $emails = [];
        // admin
        $emails[] = get_bloginfo('admin_email');
        $emails   = array_unique($emails);
        foreach ($emails as $email) {
            $status = wp_mail($email, $subject, $body, $headers);
        }
        if (! empty($status) && 1 === $status) {
            self::save_report($listing->ID, get_current_user_id(), $reason, $name, $email, $message);
            $_SESSION['messages'][] = [
                'success',
                __('Listing was reported. Please, wait for admin review.', 'inventor'),
            ];
        } else {
            $_SESSION['messages'][] = ['danger', __('Unable to send a message.', 'inventor')];
        }
    }

    /**
         * Saves report.
         *
         * @param $listing_id int
         * @param $user_id    int
         * @param $name       string
         * @param $email      string
         * @param $message    string
         *
         * @return int
         */
    public static function save_report($listing_id, $user_id, $reason, $name, $email, $message)
    {
        $report_id = wp_insert_post(
            [
            'post_type'   => 'report',
            'post_status' => 'pending',
            'post_author' => $user_id,
            'post_title'  => get_the_title($listing_id),
            ]
        );
        update_post_meta($report_id, INVENTOR_REPORT_PREFIX . 'listing_id', $listing_id);
        update_post_meta($report_id, INVENTOR_REPORT_PREFIX . 'name', $name);
        update_post_meta($report_id, INVENTOR_REPORT_PREFIX . 'email', $email);
        update_post_meta($report_id, INVENTOR_REPORT_PREFIX . 'reason', $reason);
        update_post_meta($report_id, INVENTOR_REPORT_PREFIX . 'message', $message);

        return $report_id;
    }
}

    Inventor_Reports::init();

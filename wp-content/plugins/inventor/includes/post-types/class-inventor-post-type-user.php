<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Post_Type_User.
     *
     * @class  Inventor_Post_Type_User
     * @author Pragmatic Mates
     */
class Inventor_Post_Type_User
{
    /**
         * Sets initial user profile data.
         *
         * @param $user_id
         */
    public static function set_profile_data($user_id)
    {
        $user_info  = get_userdata($user_id);
        $first_name = $user_info->user_firstname;
        $last_name  = $user_info->last_name;
        $email      = $user_info->user_email;
        update_user_meta($user_id, INVENTOR_USER_PREFIX . 'general_first_name', $first_name);
        update_user_meta($user_id, INVENTOR_USER_PREFIX . 'general_last_name', $last_name);
        update_user_meta($user_id, INVENTOR_USER_PREFIX . 'general_email', $email);
    }

    /**
         * Initialize custom post type.
         */
    public static function init()
    {
        add_action('init', [__CLASS__, 'process_profile_form'], 9999);
        add_action('init', [__CLASS__, 'process_change_password_form'], 9999);
        add_action('init', [__CLASS__, 'process_login_form'], 9999);
        add_action('login_form_lostpassword', [__CLASS__, 'process_reset_password_form']);
        add_action('init', [__CLASS__, 'process_register_form'], 9999);
        add_action('init', [__CLASS__, 'allow_subscriber_to_upload_images'], 9999);
        add_action('pre_get_posts', [__CLASS__, 'media_files']);
        add_action('user_register', [__CLASS__, 'set_profile_data'], 10, 1);
        add_filter('cmb2_init', [__CLASS__, 'fields']);
        add_filter('wp_count_attachments', [__CLASS__, 'recount_attachments']);
        add_filter('show_admin_bar', [__CLASS__, 'disable_admin_bar_for_subscribers']);
        add_filter('cmb2_sanitize_text', [__CLASS__, 'sanitize_text'], 10, 5);
    }

    /**
         * Get user full name.
         *
         * @param int $user_id
         *
         * @return string
         */
    public static function get_full_name($user_id)
    {
        $first_name = get_the_author_meta('first_name', $user_id);
        $last_name  = get_the_author_meta('last_name', $user_id);
        if (! empty($first_name) && ! empty($last_name)) {
            return "{$first_name} {$last_name}";
        }

        return get_the_author_meta('display_name', $user_id);
    }

    /**
         * Defines custom fields.
         */
    public static function fields()
    {
        $cmb = new_cmb2_box(
            [
            'id'           => INVENTOR_USER_PREFIX . 'profile',
            'object_types' => ['user'],
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true,
            ]
        );
        // General
        $cmb->add_field(
            [
            'id'   => INVENTOR_USER_PREFIX . 'general_title',
            'name' => __('General', 'inventor'),
            'type' => 'title',
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_USER_PREFIX . 'general_image',
            'name' => __('Image', 'inventor'),
            'type' => 'file',
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_USER_PREFIX . 'general_first_name',
            'name' => __('First name', 'inventor'),
            'type' => 'text',
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_USER_PREFIX . 'general_last_name',
            'name' => __('Last name', 'inventor'),
            'type' => 'text',
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_USER_PREFIX . 'general_email',
            'name' => __('E-mail', 'inventor'),
            'type' => 'text_unique_user_email',
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_USER_PREFIX . 'general_website',
            'name' => __('Website', 'inventor'),
            'type' => 'text',
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_USER_PREFIX . 'general_phone',
            'name' => __('Phone', 'inventor'),
            'type' => 'text',
            ]
        );
        // Address
        $cmb->add_field(
            [
            'id'   => INVENTOR_USER_PREFIX . 'address_title',
            'name' => __('Address', 'inventor'),
            'type' => 'title',
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_USER_PREFIX . 'address_country',
            'name' => __('Country', 'inventor'),
            'type' => 'text',
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_USER_PREFIX . 'address_county',
            'name' => __('State / County', 'inventor'),
            'type' => 'text',
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_USER_PREFIX . 'address_city',
            'name' => __('City', 'inventor'),
            'type' => 'text',
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_USER_PREFIX . 'address_street_and_number',
            'name' => __('Street and number', 'inventor'),
            'type' => 'text',
            ]
        );
        $cmb->add_field(
            [
            'id'   => INVENTOR_USER_PREFIX . 'address_postal_code',
            'name' => __('Postal code', 'inventor'),
            'type' => 'text',
            ]
        );
        // Social Connections
        $cmb->add_field(
            [
            'id'   => INVENTOR_USER_PREFIX . 'social_title',
            'name' => __('Social Connections', 'inventor'),
            'type' => 'title',
            ]
        );
        $social_networks = [ // TODO: inventor filter
            'facebook'   => 'Facebook',
            'twitter'    => 'Twitter',
            'google'     => 'Google+',
            'instagram'  => 'Instagram',
            'vimeo'      => 'Vimeo',
            'youtube'    => 'YouTube',
            'linkedin'   => 'LinkedIn',
            'dribbble'   => 'Dribbble',
            'skype'      => 'Skype',
            'foursquare' => 'Foursquare',
            'behance'    => 'Behance',
        ];
        foreach ($social_networks as $key => $title) {
            $cmb->add_field(
                [
                'id'   => INVENTOR_USER_PREFIX . 'social_' . $key,
                'name' => $title,
                'type' => 'text_medium',
                ]
            );
        }
    }

    /**
         * Sanitizes text field and updates default WP user model.
     *
         * @return string
         */
    public static function sanitize_text($override_value, $value, $object_id, $field_args, $sanitizer_object)
    {
        $object_type = $sanitizer_object->field->object_type;
        $field_id    = $sanitizer_object->field->args['id'];
        if ($object_type !== 'user') {
            return $value;
        }
        if ($field_id === INVENTOR_USER_PREFIX . 'general_first_name') {
            wp_update_user(['ID' => $object_id, 'first_name' => $value]);
        }
        if ($field_id === INVENTOR_USER_PREFIX . 'general_last_name') {
            wp_update_user(['ID' => $object_id, 'last_name' => $value]);
        }

        return $value;
    }

    /**
         * Process change profile form.
         */
    public static function process_profile_form()
    {
        if (! empty($_POST['submit-profile'])) {
            $cmb = cmb2_get_metabox(INVENTOR_USER_PREFIX . 'profile', get_current_user_id());
            $cmb->save_fields(get_current_user_id(), 'user', $_POST);
            $_SESSION['messages'][] = ['success', __('Profile has been successfully updated.', 'inventor')];
            wp_redirect($_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    /**
         * Process change password form.
         */
    public static function process_change_password_form()
    {
        if (! isset($_POST['change_password_form'])) {
            return;
        }
        $old_password    = $_POST['old_password'];
        $new_password    = $_POST['new_password'];
        $retype_password = $_POST['retype_password'];
        if (empty($old_password) || empty($new_password) || empty($retype_password)) {
            $_SESSION['messages'][] = ['warning', __('All fields are required.', 'inventor')];

            return;
        }
        if ($new_password !== $retype_password) {
            $_SESSION['messages'][] = ['warning', __('New and retyped password are not same.', 'inventor')];
        }
        $user = wp_get_current_user();
        if (! wp_check_password($old_password, $user->data->user_pass, $user->ID)) {
            $_SESSION['messages'][] = ['warning', __('Your old password is not correct.', 'inventor')];

            return;
        }
        wp_set_password($new_password, $user->ID);
        $_SESSION['messages'][] = ['success', __('Your password has been successfully changed.', 'inventor')];
    }

    /**
         * Process login form.
         */
    public static function process_login_form()
    {
        if (! isset($_POST['login_form'])) {
            return;
        }
        $redirect = site_url();
        if (! empty($_SERVER['HTTP_REFERER'])) {
            $redirect = $_SERVER['HTTP_REFERER'];
        }
        if (empty($_POST['login']) || empty($_POST['password'])) {
            $_SESSION['messages'][] = ['warning', __('Login and password are required.', 'inventor')];
            wp_redirect($redirect);
            exit();
        }
        $user = wp_signon(
            [
            'user_login'    => $_POST['login'],
            'user_password' => $_POST['password'],
            ], false
        );
        if (is_wp_error($user)) {
            $_SESSION['messages'][] = ['danger', $user->get_error_message()];
            wp_redirect($redirect);
            exit();
        }
        $_SESSION['messages'][] = ['success', __('You have been successfully logged in.', 'inventor')];
        // login page
        $login_required_page     = get_theme_mod('inventor_general_login_required_page');
        $login_required_page_url = $login_required_page ? get_permalink($login_required_page) : site_url();
        // after login page
        $after_login_page     = get_theme_mod('inventor_general_after_login_page');
        $after_login_page_url = $after_login_page ? get_permalink($after_login_page) : site_url();
        // if user logs in at login page, redirect him to after login page. Otherwise, redirect him back to previous URL.
        $protocol        = is_ssl() ? 'https://' : 'http://';
        $current_url     = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $after_login_url = $current_url === $login_required_page_url ? $after_login_page_url : $current_url;
        wp_redirect($after_login_url);
        exit();
    }

    /**
         * Process reset form.
         */
    public static function process_reset_password_form()
    {
        if (! isset($_POST['reset_form'])) {
            return;
        }
        $result = retrieve_password();
        if (is_wp_error($result)) {
            $_SESSION['messages'][] = ['danger', __('Unable to send an e-mail.', 'inventor')];
        } else {
            $_SESSION['messages'][] = ['success', __('Please check inbox for more information.', 'inventor')];
        }
        wp_redirect($_SERVER['HTTP_REFERER']);
        exit();
    }

    /**
         * Process register form.
         */
    public static function process_register_form()
    {
        if (! isset($_POST['register_form']) || ! get_option('users_can_register')) {
            return;
        }
        if (empty($_POST['name']) || empty($_POST['email'])) {
            $_SESSION['messages'][] = ['danger', __('Username and e-mail are required.', 'inventor')];
            wp_redirect($_SERVER['HTTP_REFERER']);
            exit();
        }
        $user_id = username_exists($_POST['name']);
        if (! empty($user_id)) {
            $_SESSION['messages'][] = ['danger', __('Username already exists.', 'inventor')];
            wp_redirect($_SERVER['HTTP_REFERER']);
            exit();
        }
        $user_id = email_exists($_POST['email']);
        if (! empty($user_id)) {
            $_SESSION['messages'][] = ['danger', __('Email already exists.', 'inventor')];
            wp_redirect($_SERVER['HTTP_REFERER']);
            exit();
        }
        if ($_POST['password'] !== $_POST['password_retype']) {
            $_SESSION['messages'][] = ['danger', __('Passwords must be same.', 'inventor')];
            wp_redirect($_SERVER['HTTP_REFERER']);
            exit();
        }
        $terms_id = get_theme_mod('inventor_general_terms_and_conditions_page', false);
        if ($terms_id && empty($_POST['agree_terms'])) {
            $_SESSION['messages'][] = ['danger', __('You must agree terms &amp; conditions.', 'inventor')];
            wp_redirect($_SERVER['HTTP_REFERER']);
            exit();
        }
        if ($_POST['password'] !== $_POST['password_retype']) {
            $_SESSION['messages'][] = ['danger', __('Passwords must be same.', 'inventor')];
            wp_redirect($_SERVER['HTTP_REFERER']);
            exit();
        }
        $user_login = $_POST['name'];
        $user_id    = wp_create_user($user_login, $_POST['password'], $_POST['email']);
        wp_new_user_notification($user_id, null, 'both');
        if (is_wp_error($user_id)) {
            $_SESSION['messages'][] = ['danger', $user_id->get_error_message()];
            wp_redirect(site_url());
            exit();
        }
        $_SESSION['messages'][]    = [
            'success',
            __('You have been successfully registered.', 'inventor'),
        ];
        $user                      = get_user_by('login', $user_login);
        $log_in_after_registration = get_theme_mod('inventor_log_in_after_registration', false);
        // automatic user log in
        if ($user && $log_in_after_registration) {
            wp_set_current_user($user->ID, $user_login);
            wp_set_auth_cookie($user->ID);
            do_action('wp_login', $user_login);
        }
        // registration page
        $registration_page     = get_theme_mod('inventor_general_registration_page');
        $registration_page_url = $registration_page ? get_permalink($registration_page) : site_url();
        // after register page
        $after_register_page     = get_theme_mod('inventor_general_after_register_page');
        $after_register_page_url = $after_register_page ? get_permalink($after_register_page) : site_url();
        // if user registers at registration page, redirect him to after register page. Otherwise, redirect him back to previous URL.
        $protocol           = is_ssl() ? 'https://' : 'http://';
        $current_url        = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $after_register_url = $current_url === $registration_page_url ? $after_register_page_url : $current_url;
        wp_redirect($after_register_url);
        exit();
    }

    /**
         * In media library display only current user's files.
         *
         * @param array $wp_query
         */
    public static function media_files($wp_query)
    {
        global $current_user;
        if (! current_user_can('manage_options') && (is_admin() && $wp_query->query['post_type'] === 'attachment')) {
            $wp_query->set('author', $current_user->ID);
        }
    }

    /**
         * Count of items in media library.
         *
         * @param $counts_in
         *
         * @return int
         */
    public static function recount_attachments($counts_in)
    {
        global $wpdb;
        global $current_user;
        $and    = wp_post_mime_type_where('');
        $count
                = $wpdb->get_results(
                    "SELECT post_mime_type, COUNT( * ) AS num_posts FROM $wpdb->posts WHERE post_type = 'attachment' AND post_status !== 'trash' AND post_author = {$current_user->ID} $and GROUP BY post_mime_type",
                    ARRAY_A
                );
        $counts = [];
        foreach ((array)$count as $row) {
            $counts[$row['post_mime_type']] = $row['num_posts'];
        }
        $counts['trash']
            = $wpdb->get_var("SELECT COUNT( * ) FROM $wpdb->posts WHERE post_type = 'attachment' AND post_author = {$current_user->ID} AND post_status = 'trash' $and");

        return $counts;
    }

    /**
         * Allow subscribers to upload images.
         */
    public static function allow_subscriber_to_upload_images()
    {
        $subscriber = get_role('subscriber');
        $subscriber->add_cap('upload_files');
        $subscriber->add_cap('edit_post');
    }

    /**
         * Disable admin bar for subscribers.
         *
         * @param string $content
         *
         * @return string
         */
    public static function disable_admin_bar_for_subscribers($content)
    {
        if (current_user_can('subscriber')) {
            return false;
        }

        return $content;
    }
}

    Inventor_Post_Type_User::init();

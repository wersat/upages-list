<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Shortcodes.
     *
     * @class  Inventor_Shortcodes
     * @author Pragmatic Mates
     */
class Inventor_Shortcodes
{
    /**
         * Initialize shortcodes.
         */
    public static function init()
    {
        add_action('wp', [__CLASS__, 'check_logout']);
        add_shortcode('inventor_breadcrumb', [__CLASS__, 'breadcrumb']);
        add_shortcode('inventor_logout', [__CLASS__, 'logout']);
        add_shortcode('inventor_login', [__CLASS__, 'login']);
        add_shortcode('inventor_reset_password', [__CLASS__, 'reset_password']);
        add_shortcode('inventor_register', [__CLASS__, 'register']);
        add_shortcode('inventor_password', [__CLASS__, 'password']);
        add_shortcode('inventor_payment', [__CLASS__, 'payment']);
        add_shortcode('inventor_profile', [__CLASS__, 'profile']);
        add_shortcode('inventor_transactions', [__CLASS__, 'transactions']);
        add_shortcode('inventor_report_form', [__CLASS__, 'report_form']);
        add_shortcode('inventor_submission', [__CLASS__, 'submission']);
        add_shortcode('inventor_submission_steps', [__CLASS__, 'submission_steps']);
        add_shortcode('inventor_submission_remove', [__CLASS__, 'submission_remove']);
        add_shortcode('inventor_submission_list', [__CLASS__, 'submission_list']);
    }

    /**
         * Logout checker.
         *
         * @param $wp
         */
    public static function check_logout($wp)
    {
        $post = get_post();
        if (is_object($post)) {
            if (strpos($post->post_content, '[inventor_logout]') !== false) {
                $_SESSION['messages'][] = ['success', __('You have been successfully logged out.', 'inventor')];
                wp_redirect(html_entity_decode(wp_logout_url(home_url('/'))));
                exit();
            }
        }
    }

    /**
         * Breadcrumb.
         *
         * @param $atts |array
         *
         * @return string
         */
    public static function breadcrumb($atts = [])
    {
        return Inventor_Template_Loader::load('misc/breadcrumb');
    }

    /**
         * Logout.
         *
         * @param $atts |array
         */
    public static function logout($atts = [])
    {
    }

    /**
         * Login.
         *
         * @param $atts |array
         *
         * @return string
         */
    public static function login($atts = [])
    {
        return Inventor_Template_Loader::load('accounts/login');
    }

    /**
         * Reset.
         *
         * @param $atts |array
         *
         * @return string
         */
    public static function reset_password($atts = [])
    {
        return Inventor_Template_Loader::load('accounts/reset');
    }

    /**
         * Register.
         *
         * @param $atts |array
         *
         * @return string
         */
    public static function register($atts = [])
    {
        return Inventor_Template_Loader::load('accounts/register');
    }

    /**
         * Submission steps.
         *
         * @param $atts
         * @param $atts |array
         *
         * @return string
         */
    public static function submission_steps($atts = [])
    {
        $post_type    = ! empty($_GET['type']) ? $_GET['type'] : null;
        $steps        = Inventor_Submission::get_submission_steps($post_type);
        $steps_count = count($steps);
        $first_step   = (is_array($steps) && $steps_count > 0) ? $steps[0]['id'] : null;
        $current_step = ! empty($_GET['step']) ? $_GET['step'] : $first_step;

        return Inventor_Template_Loader::load(
            'submissions/steps', [
            'steps'        => $steps,
            'post_type'    => $post_type,
            'current_step' => $current_step,
            ]
        );
    }

    /**
         * Submission.
         *
         * @param $atts |array
         *
         * @return string|null
         */
    public static function submission($atts = [])
    {
        if (! is_user_logged_in()) {
            echo Inventor_Template_Loader::load('misc/not-allowed');

            return;
        }
        $object_id = ! empty($_GET['id']) ? $_GET['id'] : false;
        if (empty($post_id) && ! empty($_POST['object_id'])) {
            $object_id = $_POST['object_id'];
        }
        if (empty($object_id) && ! Inventor_Submission::is_allowed_to_add_submission(get_current_user_id())) {
            echo Inventor_Template_Loader::load(
                'misc/not-allowed', [
                'message' => __('Check your package.', 'inventor'),
                // TODO: move to inventor-packages or use filter
                ]
            );

            return;
        }
        $post_type = ! empty($_GET['type']) ? $_GET['type'] : null;
        // Post type reference in URL not found
        if (empty($post_type)) {
            return Inventor_Template_Loader::load('submissions/type-not-found');
        }
        // if object_id is empty, user wants to submit new post
        if (empty($object_id)) {
            $object_id = 'fake-id';
        }
        $steps = Inventor_Submission::get_submission_steps($post_type);
        $steps_count = count($steps);
        // No steps defined for current post type
        if (is_array($steps) && $steps_count === 0) {
            return Inventor_Template_Loader::load('submissions/steps-not-found');
        }
        $current_step     = ! empty($_GET['step']) ? $_GET['step'] : $steps[0]['id'];
        $meta_box         = cmb2_get_metabox($current_step, $object_id);
        $post_type_object = get_post_type_object($post_type);
        $title            = Inventor_Template_Loader::load(
            'submissions/step-title', [
            'steps'              => $steps,
            'current_step'       => $current_step,
            'listing_type_title' => $post_type_object->labels->singular_name,
            ]
        );
        $save_button      = empty($_GET['id']) ? __('Proceed to next step', 'inventor') : __('Save', 'inventor');
        $action           = empty($_GET['id']) ? '' : '&action=save';

        return cmb2_get_metabox_form(
            $meta_box, $object_id, [
            'form_format' => '<form action="//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $action . '" class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"> ' . $title . '<input type="hidden" name="object_id" value="%2$s">%3$s<input type="submit" name="submit-submission" value="%4$s" class="button"></form>',
            'save_button' => $save_button,
            ]
        );
    }

    /**
         * Remove submission.
         *
         * @param $atts |array
         */
    public static function submission_remove($atts = [])
    {
        if (! is_user_logged_in() || empty($_GET['id'])) {
            echo Inventor_Template_Loader::load('misc/not-allowed');

            return;
        }
        $post = get_post($_GET['id']);
        if (empty($post)) {
            echo Inventor_Template_Loader::load('misc/object-does-not-exist');

            return;
        }
        $is_allowed = Inventor_Utilities::is_allowed_to_remove(get_current_user_id(), $_GET['id']);
        if (! $is_allowed) {
            echo Inventor_Template_Loader::load('misc/not-allowed');

            return;
        }
        $atts = [
            'listing' => Inventor_Post_Types::get_listing($_GET['id']),
        ];
        echo Inventor_Template_Loader::load('misc/remove-form', $atts);
    }

    /**
         * Submission index.
         *
         * @param $atts
         *
         * @return void|string
         */
    public static function submission_list($atts = [])
    {
        if (! is_user_logged_in()) {
            return Inventor_Template_Loader::load('misc/not-allowed');
        }

        return Inventor_Template_Loader::load('submissions/list');
    }

    /**
         * Submission payment.
         *
         * @param $atts
         *
         * @return string
         */
    public static function payment($atts = [])
    {
        if (! is_user_logged_in()) {
            return Inventor_Template_Loader::load('misc/not-allowed');
        }

        return Inventor_Template_Loader::load('payment/payment-form');
    }

    /**
         * Transactions.
         *
         * @param $atts
         *
         * @return string
         */
    public static function transactions($atts = [])
    {
        if (! is_user_logged_in()) {
            return Inventor_Template_Loader::load('misc/not-allowed');
        }

        return Inventor_Template_Loader::load('payment/transactions');
    }

    /**
         * Report form.
         *
         * @param $atts
         */
    public static function report_form($atts = [])
    {
        $atts = [
            'listing' => Inventor_Post_Types::get_listing($_GET['id']),
        ];
        echo Inventor_Template_Loader::load('misc/report-form', $atts);
    }

    /**
         * Change password.
         *
         * @param $atts
         *
         * @return string
         */
    public static function password($atts = [])
    {
        if (! is_user_logged_in()) {
            return Inventor_Template_Loader::load('misc/not-allowed');
        }

        return Inventor_Template_Loader::load('accounts/password');
    }

    /**
         * Change profile.
         *
         * @param $atts
         *
         * @return string
         */
    public static function profile($atts = [])
    {
        if (! is_user_logged_in()) {
            return Inventor_Template_Loader::load('misc/not-allowed');
        }
        $form = cmb2_get_metabox_form(
            INVENTOR_USER_PREFIX . 'profile', get_current_user_id(), [
            'form_format' => '<form action="//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<input type="submit" name="submit-profile" value="%4$s" class="button"></form>',
            'save_button' => __('Save profile', 'inventor'),
            ]
        );

        return Inventor_Template_Loader::load(
            'accounts/profile', [
            'form' => $form,
            ]
        );
    }
}

    Inventor_Shortcodes::init();

<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Field_Types_Unique_User_Email.
     */
class Inventor_Field_Types_Unique_User_Email
{
    /**
         * Initialize customizations.
         */
    public static function init()
    {
        add_action('cmb2_render_text_unique_user_email', [__CLASS__, 'render'], 10, 5);
        add_filter('cmb2_sanitize_text_unique_user_email', [__CLASS__, 'sanitize'], 10, 5);
    }

    /**
         * Adds new field type.
         *
         * @param $field
         * @param $value
         * @param $object_id
         * @param $object_tyoe
         * @param $field_type_object
         */
    public static function render($field, $escaped_value, $object_id, $object_type, $field_type_object)
    {
        echo $field_type_object->input(['type' => 'email']);
    }

    /**
         * Sanitizes the value.
         *
         * @param $override_value
         * @param $value
         * @param $object_id
         * @param $field_args
         *
         * @return mixed
         */
    public static function sanitize($override_value, $value, $object_id, $field_args, $sanitizer_object)
    {
        $old_value   = $sanitizer_object->field->value;
        $object_type = $sanitizer_object->field->object_type;
        if ($object_type !== 'user') {
            return $value;
        }
        // not an email?
        if (! is_email($value)) {
            $_SESSION['messages'][] = ['danger', __('Invalid E-mail value.', 'inventor')];

            return $old_value;
        }
        $user_with_email = email_exists($value);
        if ($user_with_email && $user_with_email !== $object_id) {
            // message
            $_SESSION['messages'][] = ['danger', __('E-mail already exists.', 'inventor')];

            return $old_value;
        }
        if ($object_type === 'user') {
            wp_update_user(['ID' => $object_id, 'user_email' => $value]);
        }

        return $value;
    }
}

    Inventor_Field_Types_Unique_User_Email::init();

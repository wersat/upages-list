<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Field_Types_Opening_Hours.
     */
class Inventor_Field_Types_Opening_Hours
{
    /**
         * Initialize customizations.
         */
    public static function init()
    {
        add_filter('cmb2_render_opening_hours', [__CLASS__, 'render'], 10, 5);
        add_filter('cmb2_sanitize_opening_hours', [__CLASS__, 'sanitize'], 12, 4);
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
    public static function render($field, $value, $object_id, $object_type, $field_type_object)
    {
        CMB2_JS::add_dependencies(['jquery-ui-core', 'jquery-ui-datepicker', 'jquery-ui-datetimepicker']);
        echo Inventor_Template_Loader::load(
            'controls/opening-hours', [
            'field'             => $field,
            'value'             => $value,
            'object_id'         => $object_id,
            'object_type'       => $object_type,
            'field_type_object' => $field_type_object,
            ]
        );
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
    public static function sanitize($override_value, $value, $object_id, $field_args)
    {
        return $value;
    }

    /**
         * Escapes the value.
         *
         * @param @value
         *
         * @return mixed
         */
    public static function escape($value)
    {
        return $value;
    }
}

    Inventor_Field_Types_Opening_Hours::init();

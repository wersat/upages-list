<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Field_Types.
     *
     * @class  Inventor_Field_Types
     * @author Pragmatic Mates
     */
class Inventor_Field_Types
{
    /**
         * Initialize listing types.
         */
    public static function init()
    {
        self::includes();
    }

    /**
         * Loads field types.
         */
    public static function includes()
    {
        include_once INVENTOR_FIELD_DIR . '/class-inventor-field-types-unique-user-email.php';
        include_once INVENTOR_FIELD_DIR . '/class-inventor-field-types-opening-hours.php';
        include_once INVENTOR_FIELD_DIR . '/class-inventor-field-types-taxonomy-select-hierarchy.php';
    }
}

    Inventor_Field_Types::init();

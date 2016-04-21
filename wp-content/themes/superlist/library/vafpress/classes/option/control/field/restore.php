<?php

    /**
     * Class VP_Option_Control_Field_Restore.
     */
    class VP_Option_Control_Field_Restore extends VP_Control_Field
    {
        /**
         * VP_Option_Control_Field_Restore constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * @return string
         *
         * @throws \Exception
         */
        public function render()
        {
            $this->_setup_data();

            return VP_View::instance()
                          ->load('option/restore', $this->get_data());
        }

/**
 * @param array $arr
 * @param null  $class_name
 *
 * @return \VP_Option_Control_Field_Restore
 */public static function withArray($arr = [], $class_name = null)
{
    $instance = null === $class_name ? new self() : new $class_name();
    $instance->_basic_make($arr);

    return $instance;
}
    }

    /*
     * EOF
     */

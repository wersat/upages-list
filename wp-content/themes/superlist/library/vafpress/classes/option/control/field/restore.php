<?php

class VP_Option_Control_Field_Restore extends VP_Control_Field
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render()
    {
        $this->_setup_data();

        return VP_View::instance()
                      ->load('option/restore', $this->get_data());
    }

    public static function withArray($arr = [], $class_name = null)
    {
        if (is_null($class_name)) {
            $instance = new self();
        } else {
            $instance = new $class_name();
        }
        $instance->_basic_make($arr);

        return $instance;
    }
}

    /*
     * EOF
     */

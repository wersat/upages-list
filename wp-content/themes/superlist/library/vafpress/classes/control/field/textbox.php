<?php

    /**
     * Class VP_Control_Field_TextBox.
     */
    class VP_Control_Field_TextBox extends VP_Control_Field
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function render($is_compact = false)
        {
            // Setup Data
            $this->_setup_data();
            $this->add_data('is_compact', $is_compact);

            return VP_View::instance()
                          ->load('control/textbox', $this->get_data());
        }

        public static function withArray($arr = [], $class_name = null)
        {
            $instance = null === $class_name ? new self() : new $class_name();
            $instance->_basic_make($arr);

            return $instance;
        }
    }

    /*
     * EOF
     */

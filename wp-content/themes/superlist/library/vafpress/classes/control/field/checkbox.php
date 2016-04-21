<?php

    /**
     * Class VP_Control_Field_CheckBox.
     */
    class VP_Control_Field_CheckBox extends VP_Control_FieldMulti implements VP_MultiSelectable
    {
        public function __construct()
        {
            parent::__construct();
            $this->_value = [];
            $this->add_container_extra_classes('vp-checked-field');
        }

        public function render($is_compact = false)
        {
            $this->_setup_data();
            $this->add_data('is_compact', $is_compact);

            return VP_View::instance()
                          ->load('control/checkbox', $this->get_data());
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

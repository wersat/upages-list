<?php

    /**
     * Class VP_Control_Field_MultiSelect
     */
    class VP_Control_Field_MultiSelect extends VP_Control_FieldMulti implements VP_MultiSelectable
    {
        /**
         * VP_Control_Field_MultiSelect constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->_value = [];
        }

        /**
         * @param bool $is_compact
         *
         * @return string
         * @throws \Exception
         */
        public function render($is_compact = false)
        {
            $this->_setup_data();
            $this->add_data('is_compact', $is_compact);

            return VP_View::instance()
                          ->load('control/multiselect', $this->get_data());
        }

        /**
         * @param array|null $arr
         * @param null       $class_name
         *
         * @return \VP_Control_Field_MultiSelect
         */
        public static function withArray(array $arr = null, $class_name = null)
        {
            $instance = null === $class_name ? new self() : new $class_name();
            $instance->_basic_make($arr);

            return $instance;
        }
    }

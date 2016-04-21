<?php

    /**
     * Class VP_Control_Field_TextArea
     */
    class VP_Control_Field_TextArea extends VP_Control_Field
    {
        /**
         * VP_Control_Field_TextArea constructor.
         */
        public function __construct()
        {
            parent::__construct();
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
                          ->load('control/textarea', $this->get_data());
        }

        /**
         * @param array|string $_value
         *
         * @return $this
         */
        public function set_value($_value)
        {
            $this->_value = $_value;

            return $this;
        }

        /**
         * @param array|null $arr
         * @param null       $class_name
         *
         * @return \VP_Control_Field_TextArea
         */
        public static function withArray(array $arr = null, $class_name = null)
        {
            $instance = null === $class_name ? new self() : new $class_name();
            $instance->_basic_make($arr);

            return $instance;
        }
    }

<?php

    class VP_Control_Field_Color extends VP_Control_Field
    {
        private $_format;

        public function __construct()
        {
            parent::__construct();
        }

        public static function withArray($arr = [], $class_name = null)
        {
            if (is_null($class_name)) {
                $instance = new self();
            } else {
                $instance = new $class_name();
            }
            $instance->set_format(isset($arr['format']) ? $arr['format'] : 'hex');
            $instance->_basic_make($arr);

            return $instance;
        }

        protected function _basic_make($arr)
        {
            parent::_basic_make($arr);
        }

        protected function _setup_data()
        {
            $opt = [
                'format' => $this->get_format(),
            ];
            $this->add_data('opt', VP_Util_Text::make_opt($opt));
            $this->add_data('opt_raw', $opt);
            parent::_setup_data();
        }

        public function render($is_compact = false)
        {
            $this->_setup_data();
            $this->add_data('is_compact', $is_compact);

            return VP_View::instance()
                          ->load('control/color', $this->get_data());
        }

        /**
         * Get the format value.
         *
         * @return string
         */
        public function get_format()
        {
            return $this->_format;
        }

        /**
         * Set the format value.
         *
         * @param string Color format
         */
        public function set_format($_format)
        {
            $this->_format = $_format;

            return $this;
        }
    }

    /*
     * EOF
     */

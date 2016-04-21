<?php

    /**
     * Class VP_Control_Field_Color
     */
    class VP_Control_Field_Color extends VP_Control_Field
    {
        /**
         * @type
         */
        private $_format;

        /**
         * VP_Control_Field_Color constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * @param array $arr
         * @param null  $class_name
         *
         * @return \VP_Control_Field_Color
         */
        public static function withArray(array $arr = null, $class_name = null)
        {
            $instance = null === $class_name ? new self() : new $class_name();
            $instance->set_format($arr['format'] ?? 'hex');
            $instance->_basic_make($arr);

            return $instance;
        }

        /**
         * @param array $arr
         */
        protected function _basic_make($arr)
        {
            parent::_basic_make($arr);
        }

        /**
         *
         */
        protected function _setup_data()
        {
            $opt = [
                'format' => $this->get_format()
            ];
            $this->add_data('opt', VP_Util_Text::make_opt($opt));
            $this->add_data('opt_raw', $opt);
            parent::_setup_data();
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
                          ->load('control/color', $this->get_data());
        }

        /**
         * Get the format value.
         * @return string
         */
        public function get_format()
        {
            return $this->_format;
        }

        /**
         * @param $_format
         *
         * @return $this
         */
        public function set_format($_format)
        {
            $this->_format = $_format;

            return $this;
        }
    }

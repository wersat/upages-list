<?php

    /**
     * Class VP_Control_Field_HTML
     */
    class VP_Control_Field_HTML extends VP_Control_Field
    {
        /**
         * @type
         */
        protected $_height;

        /**
         * VP_Control_Field_HTML constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * @param array|null $arr
         * @param null       $class_name
         *
         * @return \VP_Control_Field_HTML
         */
        public static function withArray(array $arr = null, $class_name = null)
        {
            $instance = null === $class_name ? new self() : new $class_name();
            $instance->_basic_make($arr);
            $instance->set_height($arr['height'] ?? 'auto');

            return $instance;
        }

        /**
         *
         */
        protected function _setup_data()
        {
            $this->add_data('height', $this->get_height());
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
                          ->load('control/html', $this->get_data());
        }

        /**
         * @param array|string $_value
         *
         * @return $this
         */
        public function set_value($_value)
        {
            if (is_string($_value)) {
                $_value = str_replace(["\r\n", "\r"], "\n", $_value);
            }
            $this->_value = $_value;

            return $this;
        }

        /**
         * @return mixed
         */
        public function get_height()
        {
            return $this->_height;
        }

        /**
         * @param $_height
         *
         * @return $this
         */
        public function set_height($_height)
        {
            $this->_height = $_height;

            return $this;
        }
    }

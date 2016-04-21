<?php

    /**
     * Class VP_Control_Field_Slider
     */
    class VP_Control_Field_Slider extends VP_Control_Field
    {
        /**
         * @type
         */
        private $_min;

        /**
         * @type
         */
        private $_max;

        /**
         * @type
         */
        private $_step;

        /**
         * VP_Control_Field_Slider constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * @param array|null $arr
         * @param null       $class_name
         *
         * @return \VP_Control_Field_Slider
         */
        public static function withArray(array $arr = null, $class_name = null)
        {
            $instance = null === $class_name ? new self() : new $class_name();
            $instance->set_min($arr['min'] ?? 0);
            $instance->set_max($arr['max'] ?? 100);
            $instance->set_step($arr['step'] ?? 1);
            $instance->_basic_make($arr);

            return $instance;
        }

        /**
         *
         */
        protected function _setup_data()
        {
            $opt = [
                'min'   => $this->get_min(),
                'max'   => $this->get_max(),
                'step'  => $this->get_step(),
                'value' => $this->get_value()
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
                          ->load('control/slider', $this->get_data());
        }

        /**
         * @param array $arr
         */
        protected function _basic_make($arr)
        {
            parent::_basic_make($arr);
            $default = $this->get_default();
            $default = $this->validate_value($default);
            $this->set_default($default);
        }

        /**
         * @param $_value
         *
         * @return mixed
         */
        protected function validate_value($_value)
        {
            $out_range = ((float)$_value < $this->get_min()) || ((float)$_value > $this->get_max());

            return null === $_value || $out_range ? $this->get_min() : $_value;
        }

        /**
         * @param array|string $_value
         */
        public function set_value($_value)
        {
            $_value = $this->validate_value($_value);
            parent::set_value($_value);
        }

        /**
         * @return mixed
         */
        public function get_min()
        {
            return $this->_min;
        }

        /**
         * @param $_min
         *
         * @return $this
         */
        public function set_min($_min)
        {
            $this->_min = $_min;

            return $this;
        }

        /**
         * @return mixed
         */
        public function get_max()
        {
            return $this->_max;
        }

        /**
         * @param $_max
         *
         * @return $this
         */
        public function set_max($_max)
        {
            $this->_max = $_max;

            return $this;
        }

        /**
         * @return mixed
         */
        public function get_step()
        {
            return $this->_step;
        }

        /**
         * @param $_step
         *
         * @return $this
         */
        public function set_step($_step)
        {
            $this->_step = $_step;

            return $this;
        }
    }

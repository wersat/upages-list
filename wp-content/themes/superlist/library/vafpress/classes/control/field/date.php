<?php

    /**
     * Class VP_Control_Field_Date
     */
    class VP_Control_Field_Date extends VP_Control_Field
    {
        /**
         * @type
         */
        private $_min_date;
        /**
         * @type
         */
        private $_max_date;
        /**
         * @type
         */
        private $_format;

        /**
         * VP_Control_Field_Date constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * @param array|null $arr
         * @param null       $class_name
         *
         * @return \VP_Control_Field_Date
         */
        public static function withArray(array $arr = null, $class_name = null)
        {
            $instance = null === $class_name ? new self() : new $class_name();
            $instance->_basic_make($arr);
            $instance->set_min_date($arr['min_date'] ?? '');
            $instance->set_max_date($arr['max_date'] ?? '');
            $instance->set_format($arr['format'] ?? 'yy-mm-dd');

            return $instance;
        }

        /**
         *
         */
        protected function _setup_data()
        {
            $opt = [
                'minDate'    => $this->get_min_date(),
                'maxDate'    => $this->get_max_date(),
                'dateFormat' => $this->get_format(),
                'value'      => $this->get_value()
            ];
            $this->add_data('opt', VP_Util_Text::make_opt($opt));
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
                          ->load('control/date', $this->get_data());
        }

        /**
         * @return mixed
         */
        public function get_min_date()
        {
            return $this->_min_date;
        }

        /**
         * @param $_min_date
         *
         * @return $this
         */
        public function set_min_date($_min_date)
        {
            $this->_min_date = $_min_date;

            return $this;
        }

        /**
         * @return mixed
         */
        public function get_max_date()
        {
            return $this->_max_date;
        }

        /**
         * @param $_max_date
         *
         * @return $this
         */
        public function set_max_date($_max_date)
        {
            $this->_max_date = $_max_date;

            return $this;
        }

        /**
         * @return mixed
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

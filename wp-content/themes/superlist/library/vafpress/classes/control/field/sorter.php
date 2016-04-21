<?php

    /**
     * Class VP_Control_Field_Sorter
     */
    class VP_Control_Field_Sorter extends VP_Control_FieldMulti implements VP_MultiSelectable
    {
        /**
         * @type
         */
        private $_max_selection;

        /**
         * VP_Control_Field_Sorter constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->_value = [];
        }

        /**
         * @param array|null $arr
         * @param null       $class_name
         *
         * @return \VP_Control_Field_Sorter
         */
        public static function withArray(array $arr = null, $class_name = null)
        {
            $instance = null === $class_name ? new self() : new $class_name();
            $instance->set_max_selection($arr['max_selection'] ?? false);
            $instance->_basic_make($arr);

            return $instance;
        }

        /**
         *
         */
        protected function _setup_data()
        {
            $opt = [
                'maximumSelectionSize' => $this->get_max_selection()
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
                          ->load('control/sorter', $this->get_data());
        }

        /**
         * @return mixed
         */
        public function get_max_selection()
        {
            return $this->_max_selection;
        }

        /**
         * @param $_max_selection
         *
         * @return $this
         */
        public function set_max_selection($_max_selection)
        {
            $this->_max_selection = $_max_selection;

            return $this;
        }
    }

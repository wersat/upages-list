<?php

    /**
     * Class VP_Control_Field_Upload.
     */
    class VP_Control_Field_Upload extends VP_Control_Field
    {
        /**
         * VP_Control_Field_Upload constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * @param array|null $arr
         * @param null       $class_name
         *
         * @return \VP_Control_Field_Upload
         */
        public static function withArray(array $arr = null, $class_name = null)
        {
            $instance = null === $class_name ? new self() : new $class_name();
            $instance->_basic_make($arr);

            return $instance;
        }

        /**
         *
         */
        public function _setup_data()
        {
            $preview = VP_Util_Res::get_preview_from_url($this->get_value());
            $this->add_data('preview', $preview);
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
                          ->load('control/upload', $this->get_data());
        }
    }

    /*
     * EOF
     */

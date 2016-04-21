<?php

    /**
     * Class VP_Control_Field_CheckImage.
     */
    class VP_Control_Field_CheckImage extends VP_Control_FieldMultiImage implements VP_MultiSelectable
    {
        /**
         * VP_Control_Field_CheckImage constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->_value = [];
            $this->add_container_extra_classes('vp-checked-field');
        }

        /**
         * @param bool $is_compact
         *
         * @return string
         *
         * @throws \Exception
         */
        public function render($is_compact = false)
        {
            $this->_setup_data();
            $this->add_data('is_compact', $is_compact);

            return VP_View::instance()
                          ->load('control/checkimage', $this->get_data());
        }

        /**
         * @param array $arr
         * @param null  $class_name
         *
         * @return \VP_Control_Field_CheckImage
         */
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

<?php

    /**
     * Class VP_Control_Field_RadioImage
     */
    class VP_Control_Field_RadioImage extends VP_Control_FieldMultiImage
    {
        /**
         * VP_Control_Field_RadioImage constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->add_container_extra_classes('vp-checked-field');
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
                          ->load('control/radioimage', $this->get_data());
        }

        /**
         * @param array|null $arr
         * @param null       $class_name
         *
         * @return \VP_Control_Field_RadioImage
         */
        public static function withArray(array $arr = null, $class_name = null)
        {
            $instance = null === $class_name ? new self() : new $class_name();
            $instance->_basic_make($arr);

            return $instance;
        }
    }

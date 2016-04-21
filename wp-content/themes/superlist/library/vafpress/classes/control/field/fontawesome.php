<?php

    /**
     * Class VP_Control_Field_Fontawesome
     */
    class VP_Control_Field_Fontawesome extends VP_Control_FieldMulti
    {
        /**
         * VP_Control_Field_Fontawesome constructor.
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
                          ->load('control/fontawesome', $this->get_data());
        }

        /**
         * @param array|null $arr
         * @param null       $class_name
         *
         * @return \VP_Control_Field_Fontawesome
         */
        public static function withArray(array $arr = null, $class_name = null)
        {
            $instance               = null === $class_name ? new self() : new $class_name();
            $arr['items']['data'][] = [
                'source' => 'function',
                'value'  => 'vp_get_fontawesome_icons',
            ];
            $instance->_basic_make($arr);

            return $instance;
        }
    }

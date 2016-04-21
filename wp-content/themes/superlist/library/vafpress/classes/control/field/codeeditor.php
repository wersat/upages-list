<?php

    /**
     * Class VP_Control_Field_CodeEditor
     */
    class VP_Control_Field_CodeEditor extends VP_Control_Field
    {

        /**
         * @type
         */
        protected $_mode;

        /**
         * @type
         */
        protected $_theme;

        /**
         * VP_Control_Field_CodeEditor constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * @param array|null $arr
         * @param null       $class_name
         *
         * @return \VP_Control_Field_CodeEditor
         */
        public static function withArray(array $arr = null, $class_name = null)
        {
            $instance = null === $class_name ? new self() : new $class_name();
            $instance->_basic_make($arr);
            $instance->set_editor_mode($arr['mode'] ?? '');
            $instance->set_editor_theme($arr['theme'] ?? 'textmate');

            return $instance;
        }

        /**
         *
         */
        protected function _setup_data()
        {
            $opt = [
                'mode'  => $this->get_editor_mode(),
                'theme' => $this->get_editor_theme()
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
                          ->load('control/codeeditor', $this->get_data());
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
        public function get_editor_mode()
        {
            return $this->_mode;
        }

        /**
         * @param $_mode
         *
         * @return $this
         */
        public function set_editor_mode($_mode)
        {
            $this->_mode = $_mode;

            return $this;
        }

        /**
         * @return mixed
         */
        public function get_editor_theme()
        {
            return $this->_theme;
        }

        /**
         * @param $_theme
         *
         * @return $this
         */
        public function set_editor_theme($_theme)
        {
            $this->_theme = $_theme;

            return $this;
        }
    }

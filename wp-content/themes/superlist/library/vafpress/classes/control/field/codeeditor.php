<?php

    /**
     * Class VP_Control_Field_CodeEditor
     */
    class VP_Control_Field_CodeEditor extends VP_Control_Field
    {
        /**
         * Editor's language mode
         * (javascript, css, html, php, json, xml, markdown).
         *
         * @var string
         */
        protected $_mode;

        /**
         * Editor's theme
         * (chaos, chrome, clouds, clouds_midnight, cobalt, crimson_editor, dawn, dreamweaver, eclipse,
         *  github, mono_industrial, monokai, solarized_dark, solarized_light, textmate, twilight).
         *
         * @var string
         */
        protected $_theme;

        public function __construct()
        {
            parent::__construct();
        }

        public static function withArray($arr = [], $class_name = null)
        {
            $instance = null === $class_name ? new self() : new $class_name();
            $instance->_basic_make($arr);
            $instance->set_editor_mode($arr['mode'] ?? '');
            $instance->set_editor_theme($arr['theme'] ?? 'textmate');

            return $instance;
        }

        protected function _setup_data()
        {
            $opt = [
                'mode' => $this->get_editor_mode(),
                'theme' => $this->get_editor_theme()
            ];
            $this->add_data('opt', VP_Util_Text::make_opt($opt));
            parent::_setup_data();
        }

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
            // normalize linebreak to \n for all saved data
            if (is_string($_value)) {
                $_value = str_replace(["\r\n", "\r"], "\n", $_value);
            }
            $this->_value = $_value;

            return $this;
        }

        /**
         * Get editor's language mode.
         *
         * @return string Language mode
         */
        public function get_editor_mode()
        {
            return $this->_mode;
        }

        /**
         * Set editor's language mode.
         *
         * @param string $_mode Language mode
         *
         * @return $this
         */
        public function set_editor_mode($_mode)
        {
            $this->_mode = $_mode;

            return $this;
        }

        /**
         * Get editor's theme.
         *
         * @return string Editor's theme
         */
        public function get_editor_theme()
        {
            return $this->_theme;
        }

        /**
         * Set editor's theme.
         *
         * @param string $_theme Editor's theme
         *
         * @return $this
         */
        public function set_editor_theme($_theme)
        {
            $this->_theme = $_theme;

            return $this;
        }
    }

    /*
     * EOF
     */

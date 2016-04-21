<?php

    /**
     * Class VP_Control_Field_NoteBox
     */
    class VP_Control_Field_NoteBox extends VP_Control_Field
    {
        /**
         * @type
         */
        protected $_status;

        /**
         * VP_Control_Field_NoteBox constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * @param array|null $arr
         * @param null       $class_name
         *
         * @return \VP_Control_Field_NoteBox
         */
        public static function withArray(array $arr = null, $class_name = null)
        {
            $instance = null === $class_name ? new self() : new $class_name();
            $instance->_basic_make($arr);

            return $instance;
        }

        /**
         * @param array $arr
         */
        protected function _basic_make($arr)
        {
            parent::_basic_make($arr);
            $this->set_status($arr['status'] ?? 'normal');
        }

        /**
         *
         */
        protected function _setup_data()
        {
            switch ($this->get_status()) {
                case 'normal':
                    $this->add_container_extra_classes('note-normal');
                    break;
                case 'info':
                    $this->add_container_extra_classes('note-info');
                    break;
                case 'warning':
                    $this->add_container_extra_classes('note-warning');
                    break;
                case 'error':
                    $this->add_container_extra_classes('note-error');
                    break;
                case 'success':
                    $this->add_container_extra_classes('note-success');
                    break;
                default:
                    $this->add_container_extra_classes('note-normal');
                    break;
            }
            $this->add_data('status', $this->get_status());
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
                          ->load('control/notebox', $this->get_data());
        }

        /**
         * @return mixed
         */
        public function get_status()
        {
            return $this->_status;
        }

        /**
         * @param $_status
         *
         * @return $this
         */
        public function set_status($_status)
        {
            $this->_status = $_status;

            return $this;
        }
    }

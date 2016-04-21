<?php

    abstract class VP_Option_Control_Group
    {
        protected $_name;

        protected $_title;

        protected $_description;

        protected $_data;

        /**
         * Extra Classes for the container.
         *
         * @var array
         */
        protected $_container_extra_classes;

        public function __construct()
        {
            $this->_container_extra_classes = [];
        }

        abstract public function render($extra = []);

        /**
         * Getter of $_name.
         *
         * @return string Group unique name
         */
        public function get_name()
        {
            return $this->_name;
        }

        /**
         * Setter of $_name.
         *
         * @param string $_name Group unique name
         */
        public function set_name($_name)
        {
            $this->_name = $_name;

            return $this;
        }

        /**
         * Getter of title.
         *
         * @return string Group title
         */
        public function get_title()
        {
            return $this->_title;
        }

        /**
         * Setter of title.
         *
         * @param string $_title Group title
         */
        public function set_title($_title)
        {
            $this->_title = $_title;

            return $this;
        }

        /**
         * Getter of $_description.
         *
         * @return string Group description
         */
        public function get_description()
        {
            return $this->_description;
        }

        /**
         * Setter of $_description.
         *
         * @param string $_description Group description
         */
        public function set_description($_description)
        {
            $this->_description = $_description;

            return $this;
        }

        /**
         * Add value to render data array.
         *
         * @param mixed $item Value to be added to render data arary
         */
        public function add_data($key, $value)
        {
            $this->_data[$key] = $value;
        }

        /**
         * Get render data.
         *
         * @return array Render data array
         */
        public function get_data()
        {
            return $this->_data;
        }

        /**
         * Set render data.
         *
         * @param array $_data Render data array
         */
        public function set_data($_data)
        {
            $this->_data = $_data;

            return $this;
        }

        /**
         * Getter of $_container_extra_classes.
         *
         * @return array of Extra Classes for the container
         */
        public function get_container_extra_classes()
        {
            return $this->_container_extra_classes;
        }

        /**
         * Setter of $_container_extra_classes.
         *
         * @param array $_container_extra_classes Extra Classes for the container
         */
        public function set_container_extra_classes($_container_extra_classes)
        {
            $this->_container_extra_classes = $_container_extra_classes;

            return $this;
        }

        public function add_container_extra_classes($class)
        {
            if (is_array($class)) {
                $this->_container_extra_classes = array_merge($this->_container_extra_classes, $class);
            } elseif (!in_array($class, $this->_container_extra_classes)) {
                $this->_container_extra_classes[] = $class;
            }

            return $this->_container_extra_classes;
        }

        protected function _setup_data()
        {
        }
    }

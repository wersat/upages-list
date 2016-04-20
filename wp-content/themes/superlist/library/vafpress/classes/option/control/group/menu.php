<?php

    class VP_Option_Control_Group_Menu extends VP_Option_Control_Group
    {
        /**
         * Collection of $_menu.
         *
         * @var VP_Option_Control_Group
         */
        private $_menus;

        /**
         * Collection of controls.
         *
         * @var VP_Control_Field
         */
        private $_controls;

        private $_icon;

        public function __construct()
        {
            parent::__construct();
            $this->_menus = [];
            $this->_controls = [];
        }

        public function render($extra = [])
        {
            // Setup data
            $this->_setup_data();
            $this->add_data('menu', $this);
            foreach ($extra as $key => $value) {
                $this->add_data($key, $value);
            }

            return VP_View::instance()
                          ->load('option/menu', $this->get_data());
        }

        public function add_menu($menu)
        {
            $this->_menus[] = $menu;
        }

        /**
         * Getter of $_menus.
         *
         * @return array Collection of menus object
         */
        public function get_menus()
        {
            return $this->_menus;
        }

        /**
         * Setter of $_menus.
         *
         * @param array $_menus Collection of menus object
         */
        public function set_menus($_menus)
        {
            $this->_menus = $_menus;

            return $this;
        }

        public function add_control($control)
        {
            $this->_controls[] = $control;
        }

        /**
         * Getter of controls.
         *
         * @return array Collection of controls object
         */
        public function get_controls()
        {
            return $this->_controls;
        }

        /**
         * Setter of controls.
         *
         * @param array $_controls Collection of controls object
         */
        public function set_controls($_controls)
        {
            $this->_controls = $_controls;

            return $this;
        }

        /**
         * Get menu icon.
         *
         * @return string Icon URL
         */
        public function get_icon()
        {
            return $this->_icon;
        }

        /**
         * Set menu icon.
         *
         * @param string $_icon Icon URL
         */
        public function set_icon($_icon)
        {
            $this->_icon = $_icon;

            return $this;
        }
    }
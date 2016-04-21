<?php

    /**
     * For singleton accessor, use VP_WP_MassEnqueuer class instead.
     */
    class VP_WP_Enqueuer
    {
        /**
         * @type array
         */
        private $_loaders = [];

        /**
         * @type string
         */
        private $_id;

        /**
         * VP_WP_Enqueuer constructor.
         */
        public function __construct()
        {
            $this->_id = spl_object_hash($this);
            $loader = new VP_WP_Loader();
            add_action('vp_loader_register_'.$this->_id, [$loader, 'register'], 10, 2);
        }

        /**
         * @param $loader
         */
        public function add_loader($loader)
        {
            $this->_loaders[] = $loader;
        }

        /**
         *
         */
        public function register()
        {
            add_action('admin_enqueue_scripts', [$this, 'register_caller']);
        }

        /**
         * @param $hook_suffix
         */
        public function register_caller($hook_suffix)
        {
            do_action('vp_loader_register_'.$this->_id, $this->_loaders, $hook_suffix);
        }
    }

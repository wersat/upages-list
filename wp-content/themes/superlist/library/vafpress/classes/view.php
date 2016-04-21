<?php

    /**
     * A Singleton class for loading view template.
     */
    class VP_View
    {
        /**
         * @var
         */
        private static $_instance;

        /**
         * @var array
         */
        private $_views;

        /**
         * VP_View constructor.
         */
        private function __construct()
        {
            $this->_views = [];
        }

        /**
         * @return \VP_View
         */
        public static function instance()
        {
            if (null === self::$_instance) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Load view file.
         *
         * @param string $field_view_file Name of the view file
         * @param array  $data            Array of data to be binded on the view
         *
         * @return string The result view
         *
         * @throws \Exception
         */
        public function load($field_view_file, array $data = [])
        {
            if (array_key_exists('field_view_file', $data)) {
                throw new Exception("Sorry 'field_view_file' variable name can't be used.");
            }
            $view_file = VP_FileSystem::instance()
                                      ->resolve_path('views', $field_view_file);
            if ($view_file === false) {
                throw new Exception('View file not found.');
            }
            extract($data);
            ob_start();
            include $view_file;

            return ob_get_clean();
        }
    }

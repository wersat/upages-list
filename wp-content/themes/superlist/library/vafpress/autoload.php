<?php

    VP_AutoLoader::add_namespaces(VP_NAMESPACE);
    VP_AutoLoader::add_directories(VP_CLASSES_DIR, VP_NAMESPACE);
    VP_AutoLoader::register();

    class VP_AutoLoader
    {
        /**
         * Indicates if VP_AutoLoader has been registered.
         *
         * @var bool
         */
        protected static $registered = false;

        /**
         * The registered directories.
         *
         * @var array
         */
        protected static $directories = [];

        /**
         * THe registered namespaces.
         *
         * @var array
         */
        protected static $namespaces = [];

        /**
         * Autoloading logic.
         *
         * @param string $class Class name
         *
         * @return bool Whether the loading succeded.
         */
        public static function load($class)
        {
            clearstatcache();
            // figure out namespace and halt process if not in our namespace
            $namespace = self::discover_namespace($class);
            if ($namespace === '') {
                return;
            }
            $class = self::normalize_class($class, $namespace);
            foreach (self::$directories[$namespace] as $dir) {
                $file = $dir.DIRECTORY_SEPARATOR.$class;
                // if( $dir === end(self::$directories) )
                // {
                // 	require $file;
                // 	return true;
                // }
                if (is_link($file)) {
                    $file = readlink($file);
                }
                // $real = realpath($file);
                // if($real) $file = $real;
                if (is_file($file)) {
                    require $file;

                    return true;
                }
            }
        }

        /**
         * Discover namespace from a string.
         *
         * @param string $key A class name or namespaced key
         *
         * @return string Namespace
         */
        public static function discover_namespace($key)
        {
            $namespace = '';
            foreach (self::$namespaces as $ns) {
                if (strpos($key, $ns) === 0) {
                    $namespace = $ns;
                    break;
                }
            }

            return $namespace;
        }

        /**
         * Normalize class to be loaded.
         *
         * @param string $class Class name
         *
         * @return string Normalized class name
         */
        public static function normalize_class($class, $namespace)
        {
            $class = ltrim($class, '\\');
            $class = str_replace($namespace, '', $class);
            $class = ltrim($class, '_');
            $class = strtolower($class);

            return str_replace('_', DIRECTORY_SEPARATOR, $class).'.php';
        }

        /**
         * Register autoloader.
         */
        public static function register()
        {
            if (self::$registered !== true) {
                spl_autoload_register(['VP_AutoLoader', 'load']);
            }
            self::$registered = true;
        }

        /**
         * Add a namespace.
         */
        public static function add_namespaces($namespaces)
        {
            self::$namespaces = array_merge(self::$namespaces, (array) $namespaces);
            self::$namespaces = array_unique(self::$namespaces);
            usort(self::$namespaces, ['self', 'sort']);
        }

        /**
         * Add directories to the autoloader, loading process will be run in orderly fashion
         * of directory addition.
         *
         * @param string|array $directories
         * @param string       $namespace
         */
        public static function add_directories($directories, $namespace)
        {
            if (in_array($namespace, self::$namespaces)) {
                if (!isset(self::$directories[$namespace])) {
                    self::$directories[$namespace] = [];
                }
                self::$directories[$namespace] = array_merge(self::$directories[$namespace], (array) $directories);
                self::$directories[$namespace] = array_unique(self::$directories[$namespace]);
            }
        }

        /**
         * Remove directories.
         *
         * @param string|array $directories
         */
        public static function remove_directories($directories = null, $namespace)
        {
            // check if namespace existed
            if (!in_array($namespace, self::$namespaces)) {
                return;
            }
            // annihilate everything if none / null passed
            if (null === $directories) {
                self::$directories[$namespace] = [];
            } else {
                // prepare directories to be filtered
                $directories = (array) $directories;
                // do the filtering
                foreach (self::$directories[$namespace] as $key => $dir) {
                    if (in_array($dir, $directories)) {
                        unset(self::$directories[$namespace][$key]);
                    }
                }
            }
        }

        /**
         * Get all directories.
         *
         * @return array
         */
        public static function get_directories()
        {
            return self::$directories;
        }

        /**
         * Sort by length.
         */
        private static function sort($a, $b)
        {
            return strlen($b) - strlen($a);
        }
    }

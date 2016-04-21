<?php

    /**
     * Class VP_Util_Text.
     */
    class VP_Util_Text
    {
        /**
         * @param $text
         *
         * @return string
         */
        public static function parse_md($text)
        {
            if (!class_exists('Parsedown')) {
                $path = VP_FileSystem::instance()
                                     ->resolve_path('includes', 'parsedown');
                require $path;
            }

            return parsedown::instance()
                            ->parse($text);
        }

        /**
         * @param $optArray
         *
         * @return string
         */
        public static function make_opt($optArray)
        {
            $optString = '';
            foreach ($optArray as $key => $value) {
                $optString .= '('.$key.':'.$value.')';
            }

            return $optString;
        }

        /**
         * @param $value
         * @param $format
         */
        public static function print_if_exists($value, $format)
        {
            if (!empty($value)) {
                if (is_array($value)) {
                    $value = implode($value, ', ');
                }
                call_user_func('printf', $format, $value);
            }
        }

        /**
         * @param $value
         * @param $format
         *
         * @return mixed|string
         */
        public static function return_if_exists($value, $format)
        {
            $result = '';
            if (!empty($value)) {
                if (is_array($value)) {
                    $value = implode($value, ', ');
                }
                $result = call_user_func('sprintf', $format, $value);
            }

            return $result;
        }

        /**
         * @param $string
         * @param $default
         */
        public static function out($string, $default)
        {
            if (empty($string)) {
                echo $default;
            } else {
                echo $string;
            }
        }

        /**
         * @param $item
         * @param $key
         * @param $prefix
         */
        public static function prefix(&$item, $key, $prefix)
        {
            $item = $prefix.$item;
        }

        /**
         * @param $array
         * @param $prefix
         *
         * @return mixed
         */
        public static function prefix_array($array, $prefix)
        {
            array_walk($array, 'VP_Util_Text::prefix', $prefix);

            return $array;
        }

        /**
         * @param        $haystack
         * @param        $left
         * @param string $right
         *
         * @return bool
         */
        public static function flanked_by($haystack, $left, $right = '')
        {
            if ($right == '') {
                $right = $left;
            }

            return self::starts_with($haystack, $left) and self::ends_with($haystack, $right);
        }

        /**
         * @param $haystack
         * @param $needle
         *
         * @return bool
         */
        public static function starts_with($haystack, $needle)
        {
            return !strncmp($haystack, $needle, strlen($needle));
        }

        /**
         * @param $haystack
         * @param $needle
         *
         * @return bool
         */
        public static function ends_with($haystack, $needle)
        {
            $length = strlen($needle);
            if ($length == 0) {
                return true;
            }

            return substr($haystack, -$length) === $needle;
        }
    }

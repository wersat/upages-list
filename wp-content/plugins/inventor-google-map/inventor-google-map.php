<?php
    /**
     * Plugin Name: Inventor Google Map
     * Version: 0.2.3
     * Description: Provides Google Map widget with advanced settings.
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor-google-map/
     * Text Domain: inventor-google-map
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html.
     */
    if ( ! class_exists('Inventor_Google_Map') && class_exists('Inventor')) {
        /**
         * Class Inventor_Google_Map.
         * @class  Inventor_Google_Map
         * @author Pragmatic Mates
         */
        final class Inventor_Google_Map
        {
            /**
             * Initialize Inventor_Google_Map plugin.
             */
            public function __construct()
            {
                $this->constants();
                $this->includes();
                $this->load_plugin_textdomain();
            }

            /**
             * Defines constants.
             */
            public function constants()
            {
                define('INVENTOR_GOOGLE_MAP_DIR', plugin_dir_path(__FILE__));
            }

            /**
             * Include classes.
             */
            public function includes()
            {
                require_once INVENTOR_GOOGLE_MAP_DIR . 'includes/class-inventor-google-map-ajax.php';
                require_once INVENTOR_GOOGLE_MAP_DIR . 'includes/class-inventor-google-map-scripts.php';
                require_once INVENTOR_GOOGLE_MAP_DIR . 'includes/class-inventor-google-map-styles.php';
                require_once INVENTOR_GOOGLE_MAP_DIR . 'includes/class-inventor-google-map-widgets.php';
            }

            /**
             * Loads localization files.
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('inventor-google-map', false, plugin_basename(__FILE__) . '/languages');
            }

            /**
             * Get filter params.
             * @return string
             */
            public static function get_current_filter_query_uri()
            {
                $queries = [];
                if ( ! empty($_GET)) {
                    foreach ($_GET as $key => $value) {
                        $parts = explode('-', $key);
                        if ('filter' == $parts[0]) {
                            if ( ! empty($value)) {
                                $queries[] = $key . '=' . $value;
                            }
                        }
                    }
                }

                return implode('&', $queries);
            }
        }

        new Inventor_Google_Map();
    }

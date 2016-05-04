<?php
    /**
     * Plugin Name: Inventor Watchdogs
     * Version: 0.1.7
     * Description: Allows user to watch search queries and be notified about changes.
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor-watchdogs/
     * Text Domain: inventor-watchdogs
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html.
     */
    if ( ! class_exists('Inventor_Watchdogs') && class_exists('Inventor')) {
        /**
         * Class Inventor_Watchdogs.
         * @class  Inventor_Watchdogs
         * @author Pragmatic Mates
         */
        final class Inventor_Watchdogs
        {
            /**
             * Initialize Inventor_Watchdogs plugin.
             */
            public function __construct()
            {
                $this->init();
                $this->constants();
                $this->includes();
                $this->load_plugin_textdomain();
            }

            /**
             * Initialize watchdogs functionality.
             */
            public static function init()
            {
            }

            /**
             * Defines constants.
             */
            public function constants()
            {
                define('INVENTOR_WATCHDOGS_DIR', plugin_dir_path(__FILE__));
                define('INVENTOR_WATCHDOG_PREFIX', 'watchdog_');
                define('INVENTOR_WATCHDOG_TYPE_SEARCH_QUERY', 'SEARCH_QUERY');
            }

            /**
             * Include classes.
             */
            public function includes()
            {
                require_once INVENTOR_WATCHDOGS_DIR . 'includes/class-inventor-watchdogs-customizations.php';
                require_once INVENTOR_WATCHDOGS_DIR . 'includes/class-inventor-watchdogs-post-types.php';
                require_once INVENTOR_WATCHDOGS_DIR . 'includes/class-inventor-watchdogs-shortcodes.php';
                require_once INVENTOR_WATCHDOGS_DIR . 'includes/class-inventor-watchdogs-logic.php';
            }

            /**
             * Loads localization files.
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('inventor-watchdogs', false, plugin_basename(dirname(__FILE__)) . '/languages');
            }
        }

        new Inventor_Watchdogs();
    }

<?php
    /**
     * Plugin Name: Inventor Currencies
     * Version: 0.1.1
     * Description: Adds multiple currencies support.
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor-currencies/
     * Text Domain: inventor-currencies
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html.
     */
    if ( ! class_exists('Inventor_Currencies') && class_exists('Inventor')) {
        /**
         * Class Inventor_Currencies.
         * @class  Inventor_Currencies
         * @author Pragmatic Mates
         */
        final class Inventor_Currencies
        {
            /**
             * Initialize Inventor_Currencies plugin.
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
                define('INVENTOR_CURRENCIES_DIR', plugin_dir_path(__FILE__));
                define('INVENTOR_CURRENCY_REFRESH', 24 * 60 * 60);  // 1 day
            }

            /**
             * Include classes.
             */
            public function includes()
            {
                require_once INVENTOR_CURRENCIES_DIR . 'includes/class-inventor-currencies-customizations.php';
                require_once INVENTOR_CURRENCIES_DIR . 'includes/class-inventor-currencies-shortcodes.php';
                require_once INVENTOR_CURRENCIES_DIR . 'includes/class-inventor-currencies-logic.php';
            }

            /**
             * Loads localization files.
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('inventor-currencies', false, plugin_basename(dirname(__FILE__)) . '/languages');
            }
        }

        new Inventor_Currencies();
    }

<?php
    /**
     * Plugin Name: Inventor Shop
     * Version: 0.2.1
     * Description: Listing purchasing support.
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor-shop/
     * Text Domain: inventor-shop
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html.
     */
    if ( ! class_exists('Inventor_Shop') && class_exists('Inventor')) {
        /**
         * Class Inventor_Shop.
         * @class   Inventor_Shop
         * @author  Pragmatic Mates
         */
        final class Inventor_Shop
        {
            /**
             * Initialize Inventor_Shop plugin.
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
                define('INVENTOR_SHOP_DIR', plugin_dir_path(__FILE__));
                define('INVENTOR_SHOP_PREFIX', 'shop_');
            }

            /**
             * Include classes.
             */
            public function includes()
            {
                require_once INVENTOR_SHOP_DIR . 'includes/class-inventor-shop-logic.php';
            }

            /**
             * Loads localization files.
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('inventor-shop', false, plugin_basename(dirname(__FILE__)) . '/languages');
            }
        }

        new Inventor_Shop();
    }

<?php
    /**
     * Plugin Name: Inventor PayPal
     * Version: 0.4.0
     * Description: Adds PayPal payment gateway.
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor-paypal/
     * Text Domain: inventor-paypal
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html
     */
    if ( ! class_exists('Inventor_PayPal') && class_exists('Inventor')) {
        /**
         * Class Inventor_PayPal
         * @class   Inventor_PayPal
         * @package Inventor_PayPal
         * @author  Pragmatic Mates
         */
        final class Inventor_PayPal
        {
            /**
             * Initialize Inventor_PayPal plugin
             */
            public function __construct()
            {
                $this->constants();
                $this->includes();
                $this->load_plugin_textdomain();
            }

            /**
             * Defines constants
             * @access public
             * @return void
             */
            public function constants()
            {
                define('INVENTOR_PAYPAL_DIR', plugin_dir_path(__FILE__));
            }

            /**
             * Include classes
             * @access public
             * @return void
             */
            public function includes()
            {
                require_once INVENTOR_PAYPAL_DIR . 'includes/class-inventor-paypal-customizations.php';
                require_once INVENTOR_PAYPAL_DIR . 'includes/class-inventor-paypal-logic.php';
            }

            /**
             * Loads localization files
             * @access public
             * @return void
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('inventor-paypal', false, plugin_basename(dirname(__FILE__)) . '/languages');
            }
        }

        new Inventor_PayPal();
    }

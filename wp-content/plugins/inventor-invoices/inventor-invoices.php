<?php
    /**
     * Plugin Name: Inventor Invoices
     * Version: 0.2.1
     * Description: Adds Invoice Post Type for billing system
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor-invoices/
     * Text Domain: inventor-invoices
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html.
     */
    if ( ! class_exists('Inventor_Invoices') && class_exists('Inventor')) {
        /**
         * Class Inventor_Invoices.
         * @class  Inventor_Invoices
         * @author Pragmatic Mates
         */
        final class Inventor_Invoices
        {
            /**
             * Initialize Inventor_Invoices plugin.
             */
            public function __construct()
            {
                $this->constants();
                $this->load_plugin_textdomain();
            }

            /**
             * Defines constants.
             */
            public function constants()
            {
                define('INVENTOR_INVOICES_DIR', __DIR__);
                define('INVENTOR_INVOICE_PREFIX', 'invoice_');
            }

            /**
             * Loads localization files.
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('inventor-invoices', false, plugin_basename(__FILE__) . '/languages');
            }
        }

        new Inventor_Invoices();
    }

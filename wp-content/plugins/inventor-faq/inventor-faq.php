<?php
    /**
     * Plugin Name: Inventor FAQ
     * Version: 0.1.2
     * Description: Provides custom post type for Frequently Asked Questions which could be displayed by widget.
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor-faq/
     * Text Domain: inventor-faq
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html.
     */
    if ( ! class_exists('Inventor_FAQ') && class_exists('Inventor')) {
        /**
         * Class Inventor_FAQ.
         * @class  Inventor_FAQ
         * @author Pragmatic Mates
         */
        final class Inventor_FAQ
        {
            /**
             * Initialize Inventor_FAQ plugin.
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
                define('INVENTOR_FAQ_DIR', plugin_dir_path(__FILE__));
                define('INVENTOR_FAQ_PREFIX', 'faq_');
            }

            /**
             * Include classes.
             */
            public function includes()
            {
                //require_once INVENTOR_FAQ_DIR . 'includes/class-inventor-faq-post-types.php';
                require_once INVENTOR_FAQ_DIR . 'includes/class-inventor-faq-widgets.php';
            }

            /**
             * Loads localization files.
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('inventor-faq', false, plugin_basename(__FILE__) . '/languages');
            }
        }

        new Inventor_FAQ();
    }

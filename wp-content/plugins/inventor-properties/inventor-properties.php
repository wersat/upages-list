<?php
    /**
     * Plugin Name: Inventor Properties
     * Version: 0.3.5
     * Description: Properties listing support.
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor-properties/
     * Text Domain: inventor-properties
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html.
     */
    if ( ! class_exists('Inventor_Properties') && class_exists('Inventor')) {
        /**
         * Class Inventor_Properties.
         * @class   Inventor_Properties
         * @author  Pragmatic Mates
         */
        final class Inventor_Properties
        {
            /**
             * Initialize Inventor_Properties plugin.
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
                define('INVENTOR_PROPERTIES_DIR', plugin_dir_path(__FILE__));
                define('INVENTOR_PROPERTY_PREFIX', 'property_');
            }

            /**
             * Include classes.
             */
            public function includes()
            {
                require_once INVENTOR_PROPERTIES_DIR . 'includes/class-inventor-properties-post-types.php';
                require_once INVENTOR_PROPERTIES_DIR . 'includes/class-inventor-properties-taxonomies.php';
                require_once INVENTOR_PROPERTIES_DIR . 'includes/class-inventor-properties-customizations.php';
                require_once INVENTOR_PROPERTIES_DIR . 'includes/class-inventor-properties-logic.php';
            }

            /**
             * Loads localization files.
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('inventor-properties', false, plugin_basename(dirname(__FILE__)) . '/languages');
            }
        }

        new Inventor_Properties();
    }

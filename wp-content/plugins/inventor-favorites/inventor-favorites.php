<?php
    /**
     * Plugin Name: Inventor Favorites
     * Version: 0.1.2
     * Description: Adds favorite listings.
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor-favorites/
     * Text Domain: inventor-favorites
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html.
     */
    if ( ! class_exists('Inventor_Favorites') && class_exists('Inventor')) {
        /**
         * Class Inventor_Favorites.
         * @class  Inventor_Favorites
         * @author Pragmatic Mates
         */
        final class Inventor_Favorites
        {
            /**
             * Initialize Inventor_Favorites plugin.
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
                define('INVENTOR_FAVORITES_DIR', plugin_dir_path(__FILE__));
            }

            /**
             * Include classes.
             */
            public function includes()
            {
                require_once INVENTOR_FAVORITES_DIR . 'includes/class-inventor-favorites-customizations.php';
                require_once INVENTOR_FAVORITES_DIR . 'includes/class-inventor-favorites-shortcodes.php';
                require_once INVENTOR_FAVORITES_DIR . 'includes/class-inventor-favorites-widgets.php';
                require_once INVENTOR_FAVORITES_DIR . 'includes/class-inventor-favorites-scripts.php';
                require_once INVENTOR_FAVORITES_DIR . 'includes/class-inventor-favorites-logic.php';
            }

            /**
             * Loads localization files.
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('inventor-favorites', false, plugin_basename(__FILE__) . '/languages');
            }
        }

        new Inventor_Favorites();
    }

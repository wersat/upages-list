<?php
    /**
     * Plugin Name: Inventor Listing Slider
     * Version: 0.1.1
     * Description: Adds listing slider widget which shows listings in slider format.
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor-listing-slider/
     * Text Domain: inventor-listing-slider
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html.
     */
    if ( ! class_exists('Inventor_Listing_Slider') && class_exists('Inventor')) {
        /**
         * Class Inventor_Listing_Slider.
         * @class  Inventor_Listing_Slider
         * @author Pragmatic Mates
         */
        final class Inventor_Listing_Slider
        {
            /**
             * Initialize Inventor_Listing_Slider plugin.
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
                define('INVENTOR_LISTING_SLIDER_DIR', plugin_dir_path(__FILE__));
            }

            /**
             * Include classes.
             */
            public function includes()
            {
                require_once INVENTOR_LISTING_SLIDER_DIR . 'includes/class-inventor-listing-slider-scripts.php';
                require_once INVENTOR_LISTING_SLIDER_DIR . 'includes/class-inventor-listing-slider-widgets.php';
                require_once INVENTOR_LISTING_SLIDER_DIR . 'includes/class-inventor-listing-slider-extend.php';
            }

            /**
             * Loads localization files.
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('inventor-listing-slider', false,
                    plugin_basename(__FILE__) . '/languages');
            }
        }

        new Inventor_Listing_Slider();
    }

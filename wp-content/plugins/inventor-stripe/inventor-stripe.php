<?php
    /**
     * Plugin Name: Inventor Stripe
     * Version: 0.3.0
     * Description: Adds Stripe payment gateway.
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor-stripe/
     * Text Domain: inventor-stripe
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html.
     */
    if (!class_exists('Inventor_Stripe') && class_exists('Inventor')) {
        /**
         * Class Inventor_Stripe.
         *
         * @class  Inventor_Stripe
         *
         * @author Pragmatic Mates
         */
        final class Inventor_Stripe
        {
            /**
             * Initialize Inventor_Stripe plugin.
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
                define('INVENTOR_STRIPE_DIR', plugin_dir_path(__FILE__));
            }

            /**
             * Include classes.
             */
            public function includes()
            {
                require_once INVENTOR_STRIPE_DIR.'includes/class-inventor-stripe-customizations.php';
                require_once INVENTOR_STRIPE_DIR.'includes/class-inventor-stripe-logic.php';
            }

            /**
             * Loads localization files.
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('inventor-stripe', false, plugin_basename(dirname(__FILE__)).'/languages');
            }
        }

        new Inventor_Stripe();
    }

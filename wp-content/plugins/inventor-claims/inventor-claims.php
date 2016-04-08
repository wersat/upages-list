<?php
    /**
     * Plugin Name: Inventor Claims
     * Version: 0.1.6
     * Description: Allows user to claim listing.
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor-claims/
     * Text Domain: inventor-claims
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html.
     */
    if ( ! class_exists('Inventor_Claims') && class_exists('Inventor')) {
        /**
         * Class Inventor_Claims.
         * @class  Inventor_Claims
         * @author Pragmatic Mates
         */
        final class Inventor_Claims
        {
            /**
             * Initialize Inventor_Claims plugin.
             */
            public function __construct()
            {
                static::init();
                $this->constants();
                $this->includes();
                $this->load_plugin_textdomain();
            }

            /**
             * Initialize claims functionality.
             */
            public static function init()
            {
            }

            /**
             * Defines constants.
             */
            public function constants()
            {
                define('INVENTOR_CLAIMS_DIR', plugin_dir_path(__FILE__));
                define('INVENTOR_CLAIM_PREFIX', 'claim_');
                define('INVENTOR_MAIL_ACTION_CLAIMED_LISTING', 'CLAIMED_LISTING');
                define('INVENTOR_MAIL_ACTION_CLAIM_APPROVED', 'CLAIM_APPROVED');
            }

            /**
             * Include classes.
             */
            public function includes()
            {
                require_once INVENTOR_CLAIMS_DIR . 'includes/class-inventor-claims-customizations.php';
                require_once INVENTOR_CLAIMS_DIR . 'includes/class-inventor-claims-post-types.php';
                require_once INVENTOR_CLAIMS_DIR . 'includes/class-inventor-claims-shortcodes.php';
                require_once INVENTOR_CLAIMS_DIR . 'includes/class-inventor-claims-scripts.php';
                require_once INVENTOR_CLAIMS_DIR . 'includes/class-inventor-claims-logic.php';
            }

            /**
             * Loads localization files.
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('inventor-claims', false, plugin_basename(dirname(__FILE__)) . '/languages');
            }
        }

        new Inventor_Claims();
    }

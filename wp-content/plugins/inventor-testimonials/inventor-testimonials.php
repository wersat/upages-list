<?php

/**
 * Plugin Name: Inventor Testimonials
 * Version: 0.1.3
 * Description: Provides custom post type for Testimonials which could be displayed by widget.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-testimonials/
 * Text Domain: inventor-testimonials
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! class_exists( 'Inventor_Testimonials' ) && class_exists( 'Inventor' ) ) {
	/**
	 * Class Inventor_Testimonials
	 *
	 * @class Inventor_Testimonials
	 * @package Inventor_Testimonials
	 * @author Pragmatic Mates
	 */
	final class Inventor_Testimonials {
		/**
		 * Initialize Inventor_Testimonials plugin
		 */
		public function __construct() {
			$this->constants();
			$this->includes();
            $this->load_plugin_textdomain();

            add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_frontend' ) );
		}

		/**
		 * Defines constants
		 *
		 * @access public
		 * @return void
		 */
		public function constants() {
			define( 'INVENTOR_TESTIMONIALS_DIR', plugin_dir_path( __FILE__ ) );
			define( 'INVENTOR_TESTIMONIALS_PREFIX', 'testimonials_' );
		}

		/**
		 * Include classes
		 *
		 * @access public
		 * @return void
		 */
		public function includes() {
			require_once INVENTOR_TESTIMONIALS_DIR . 'includes/class-inventor-testimonials-post-types.php';
			require_once INVENTOR_TESTIMONIALS_DIR . 'includes/class-inventor-testimonials-widgets.php';
		}

        /**
         * Loads frontend files
         *
         * @access public
         * @return void
         */
        public static function enqueue_frontend() {
            wp_register_script( 'inventor-testimonials', plugins_url( '/inventor-testimonials/assets/js/script.js' ), array( 'jquery' ), false, true );
            wp_enqueue_script( 'inventor-testimonials' );
        }

		/**
		 * Loads localization files
		 *
		 * @access public
		 * @return void
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'inventor-testimonials', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
		}
    }

	new Inventor_Testimonials();
}

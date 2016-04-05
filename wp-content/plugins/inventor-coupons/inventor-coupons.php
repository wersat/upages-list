<?php

/**
* Plugin Name: Inventor Coupons
 * Version: 0.1.6
 * Description: Coupons listing support.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-coupons/
 * Text Domain: inventor-coupons
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Coupons' ) && class_exists( 'Inventor' ) ) {
	/**
	 * Class Inventor_Coupons
	 *
	 * @class Inventor_Coupons
	 * @package Inventor_Coupons
	 * @author Pragmatic Mates
	 */
	final class Inventor_Coupons {
		/**
		 * Initialize Inventor_Coupons plugin
		 */
		public function __construct() {
			$this->constants();
			$this->includes();
			$this->load_plugin_textdomain();
		}

		/**
		 * Defines constants
		 *
		 * @access public
		 * @return void
		 */
		public function constants() {
			define( 'INVENTOR_COUPONS_DIR', plugin_dir_path( __FILE__ ) );
			define( 'INVENTOR_COUPON_PREFIX', INVENTOR_LISTING_PREFIX . 'coupon_' );
		}

		/**
		 * Include classes
		 *
		 * @access public
		 * @return void
		 */
		public function includes() {
			require_once INVENTOR_COUPONS_DIR . 'includes/class-inventor-coupons-ajax.php';
			require_once INVENTOR_COUPONS_DIR . 'includes/class-inventor-coupons-logic.php';
			require_once INVENTOR_COUPONS_DIR . 'includes/class-inventor-coupons-post-types.php';
			require_once INVENTOR_COUPONS_DIR . 'includes/class-inventor-coupons-metaboxes.php';
			require_once INVENTOR_COUPONS_DIR . 'includes/class-inventor-coupons-scripts.php';
			require_once INVENTOR_COUPONS_DIR . 'includes/class-inventor-coupons-widgets.php';
		}

		/**
		 * Loads localization files
		 *
		 * @access public
		 * @return void
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'inventor-coupons', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
		}
	}

	new Inventor_Coupons();
}

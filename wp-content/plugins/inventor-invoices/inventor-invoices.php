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

    add_action('plugins_loaded', 'myplugin_init');
    function myplugin_init() {
        load_plugin_textdomain('inventor-invoices', false, plugin_basename(__FILE__) . '/languages');
    }

<?php
    /**
     * Plugin Name: Inventor Partners
     * Version: 0.1.2
     * Description: Provides custom post type for partners which logos could be displayed by widget.
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor-partners/
     * Text Domain: inventor-partners
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html.
     */
    add_action('plugins_loaded', 'partners_init');
    function partners_init() {
        load_plugin_textdomain('inventor-partners', false, plugin_basename(__FILE__) . '/languages');
    }

<?php
    /**
     * Plugin Name: Inventor
     * Version: 0.8.1
     * Description: Directory plugin for all kinds of listings.
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor/
     * Text Domain: inventor
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html.
     */
    if ( ! class_exists('Inventor')) {
        /**
         * Class Inventor.
         * @class   Inventor
         * @author  Pragmatic Mates
         */
        final class inventor
        {
            /**
             * Initialize plugin.
             */
            public function __construct()
            {
                $this->constants();
                static::libraries();
                $this->includes();
                $this->load_plugin_textdomain();
                add_action('init', [__CLASS__, 'start_session'], 1);
                add_action('activated_plugin', [__CLASS__, 'plugin_order']);
            }

            /**
             * Defines constants.
             */
            public function constants()
            {
                define('INVENTOR_DIR', __DIR__);
                define('INVENTOR_INC_DIR', INVENTOR_DIR . '/includes');
                define('INVENTOR_ADM_DIR', INVENTOR_INC_DIR . '/admin');
                define('INVENTOR_CUSTOM_DIR', INVENTOR_INC_DIR . '/customizations');
                define('INVENTOR_FIELD_DIR', INVENTOR_INC_DIR . '/field-types');
                define('INVENTOR_POST_TYPES_DIR', INVENTOR_INC_DIR . '/post-types');
                define('INVENTOR_TAX_DIR', INVENTOR_INC_DIR . '/taxonomies');
                define('INVENTOR_WIDGETS_DIR', INVENTOR_INC_DIR . '/widgets');
                define('INVENTOR_LIB_DIR', INVENTOR_DIR . '/libraries');
                define('INVENTOR_TPL_DIR', INVENTOR_DIR . '/templates');
                define('INVENTOR_TPL_ACCOUNTS_DIR', INVENTOR_TPL_DIR . '/accounts');
                define('INVENTOR_TPL_ADMIN_DIR', INVENTOR_TPL_DIR . '/admin');
                define('INVENTOR_TPL_CONTROLS_DIR', INVENTOR_TPL_DIR . '/controls');
                define('INVENTOR_TPL_LISTINGS_DIR', INVENTOR_TPL_DIR . '/listings');
                define('INVENTOR_TPL_MAILS_DIR', INVENTOR_TPL_DIR . '/mails');
                define('INVENTOR_TPL_MISC_DIR', INVENTOR_TPL_DIR . '/misc');
                define('INVENTOR_TPL_NOTICES_DIR', INVENTOR_TPL_DIR . '/notices');
                define('INVENTOR_TPL_PAYMENT_DIR', INVENTOR_TPL_DIR . '/payment');
                define('INVENTOR_TPL_POST_TYPES_DIR', INVENTOR_TPL_DIR . '/post-types');
                define('INVENTOR_TPL_SUBMISSIONS_DIR', INVENTOR_TPL_DIR . '/submissions');
                define('INVENTOR_TPL_WIDGETS_DIR', INVENTOR_TPL_DIR . '/widgets');
                define('INVENTOR_LISTING_PREFIX', 'listing_');
                define('INVENTOR_TRANSACTION_PREFIX', 'transaction_');
                define('INVENTOR_REPORT_PREFIX', 'report_');
                define('INVENTOR_USER_PREFIX', 'user_');
                define('INVENTOR_MAIL_ACTION_REPORTED_LISTING', 'REPORTED_LISTING');
                if (defined('INVENTOR_API_DEBUG_URL')) {
                    define('INVENTOR_API_PLUGINS_URL', INVENTOR_API_DEBUG_URL . '/api/v1/plugins/');
                    define('INVENTOR_API_VERIFY_URL', INVENTOR_API_DEBUG_URL . '/api/v1/verify/');
                } else {
                    define('INVENTOR_API_PLUGINS_URL', 'http://inventorwp.com/api/v1/plugins/');
                    define('INVENTOR_API_VERIFY_URL', 'http://inventorwp.com/api/v1/verify/');
                }
            }

            /**
             * Include classes.
             */
            public function includes()
            {
                require_once INVENTOR_INC_DIR . '/class-inventor-scripts.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-template-loader.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-metaboxes.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-post-types.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-field-types.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-taxonomies.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-price.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-widgets.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-filter.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-utilities.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-query.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-shortcodes.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-submission.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-billing.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-wire-transfer.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-reports.php';
                require_once INVENTOR_INC_DIR . '/class-inventor-customizations.php';
                // Admin
                if (is_admin()) {
                    require_once INVENTOR_ADM_DIR . '/class-inventor-admin-menu.php';
                    require_once INVENTOR_ADM_DIR . '/class-inventor-admin-notices.php';
                }
            }

            /**
             * Loads third party libraries.
             */
            public static function libraries()
            {
                require_once INVENTOR_LIB_DIR . '/cmb_field_map/cmb-field-map.php';
                require_once INVENTOR_LIB_DIR . '/cmb_field_street_view/cmb-field-street-view.php';
                require_once INVENTOR_LIB_DIR . '/cmb_field_taxonomy_multicheck_hierarchy/cmb-field-taxonomy-multicheck-hierarchy.php';
                require_once INVENTOR_LIB_DIR . '/cmb_taxonomy_metadata/Taxonomy_MetaData_CMB2.php';
            }

            /**
             * Loads localization files.
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('inventor', false, plugin_basename(__FILE__) . '/languages');
            }

            /**
             * Start session.
             */
            public static function start_session()
            {
                if ( ! session_id()) {
                    session_start();
                }
            }

            /**
             * Loads this plugin first.
             */
            public static function plugin_order()
            {
                $wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR . '/$2', __FILE__);
                $this_plugin          = plugin_basename(trim($wp_path_to_this_file));
                $active_plugins       = get_option('active_plugins');
                $this_plugin_key      = array_search($this_plugin, $active_plugins);
                if ($this_plugin_key) {
                    array_splice($active_plugins, $this_plugin_key, 1);
                    array_unshift($active_plugins, $this_plugin);
                    update_option('active_plugins', $active_plugins);
                }
            }
        }

        new Inventor();
    }

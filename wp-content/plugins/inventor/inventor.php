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
if (! class_exists('Inventor')) {
    /**
         * Class Inventor.
     *
         * @class  Inventor
         * @author Pragmatic Mates
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
            include_once INVENTOR_INC_DIR . '/class-inventor-scripts.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-template-loader.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-metaboxes.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-post-types.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-field-types.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-taxonomies.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-price.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-widgets.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-filter.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-utilities.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-query.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-shortcodes.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-submission.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-billing.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-wire-transfer.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-reports.php';
            include_once INVENTOR_INC_DIR . '/class-inventor-customizations.php';
            // Admin
            if (is_admin()) {
                //require_once INVENTOR_ADM_DIR . '/class-inventor-admin-menu.php';
                include_once INVENTOR_ADM_DIR . '/class-inventor-admin-notices.php';
            }
        }

        /**
             * Loads third party libraries.
             */
        public static function libraries()
        {
            include_once INVENTOR_LIB_DIR . '/cmb_field_map/cmb-field-map.php';
            include_once INVENTOR_LIB_DIR . '/cmb_field_street_view/cmb-field-street-view.php';
            include_once INVENTOR_LIB_DIR . '/cmb_field_taxonomy_multicheck_hierarchy/cmb-field-taxonomy-multicheck-hierarchy.php';
            include_once INVENTOR_LIB_DIR . '/cmb_taxonomy_metadata/Taxonomy_MetaData_CMB2.php';
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
            if (! session_id()) {
                session_start();
            }
        }
    }

    new Inventor();
}

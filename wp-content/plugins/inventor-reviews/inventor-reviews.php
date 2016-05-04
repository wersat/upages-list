<?php
    /**
     * Plugin Name: Inventor Reviews
     * Version: 0.1.2
     * Description: Provides reviews for listings.
     * Author: Pragmatic Mates
     * Author URI: http://inventorwp.com
     * Plugin URI: http://inventorwp.com/plugins/inventor-reviews/
     * Text Domain: inventor-reviews
     * Domain Path: /languages/
     * License: GNU General Public License v3.0
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html.
     */
    if ( ! class_exists('Inventor_Reviews') && class_exists('Inventor')) {
        /**
         * Class Inventor_Reviews.
         * @class   Inventor_Reviews
         * @author  Pragmatic Mates
         */
        final class Inventor_Reviews
        {
            /**
             * Initialize Inventor_Reviews plugin.
             */
            public function __construct()
            {
                $this->constants();
                $this->includes();
                $this->load_plugin_textdomain();
                add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_frontend']);
                add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_backend']);
                add_action('init', [__CLASS__, 'set_capabilities']);
            }

            /**
             * Defines constants.
             */
            public function constants()
            {
                define('INVENTOR_REVIEWS_DIR', plugin_dir_path(__FILE__));
                define('INVENTOR_REVIEWS_TOTAL_RATING_META', 'inventor_reviews_post_total_rating');
            }

            /**
             * Include classes.
             */
            public function includes()
            {
                require_once INVENTOR_REVIEWS_DIR . 'includes/class-inventor-reviews-logic.php';
            }

            public static function set_capabilities()
            {
                $role = get_role('subscriber');
                $role->add_cap('upload_files');
            }

            /**
             * Loads frontend files.
             */
            public static function enqueue_frontend()
            {
                wp_register_script('inventor-reviews', plugins_url('/inventor-reviews/assets/script.js'), ['jquery'],
                    false, true);
                wp_enqueue_script('inventor-reviews');
                wp_register_style('inventor-reviews', plugins_url('/inventor-reviews/assets/style.css'));
                wp_enqueue_style('inventor-reviews');
                wp_register_script('raty', plugins_url('/inventor-reviews/libraries/raty/jquery.raty.js'), ['jquery'],
                    false, true);
                wp_enqueue_script('raty');
                wp_enqueue_media();
            }

            /**
             * Loads backend files.
             */
            public static function enqueue_backend()
            {
                wp_register_style('style-admin', plugins_url('/inventor-reviews/assets/style-admin.css'));
                wp_enqueue_style('style-admin');
                wp_register_script('raty-admin', plugins_url('/inventor-reviews/libraries/raty/jquery.raty.js'),
                    ['jquery'], false, true);
                wp_enqueue_script('raty-admin');
                wp_register_script('script', plugins_url('/inventor-reviews/assets/script-admin.js'), ['jquery'], false,
                    true);
                wp_enqueue_script('script');
            }

            /**
             * Loads localization files.
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('inventor-reviews', false, plugin_basename(dirname(__FILE__)) . '/languages');
            }
        }

        new Inventor_Reviews();
    }

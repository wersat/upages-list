<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Statistics_Scripts.
     * @class  Inventor_Statistics_Scripts
     * @author Pragmatic Mates
     */
    class Inventor_Statistics_Scripts
    {
        /**
         * Initialize scripts.
         */
        public static function init()
        {
            add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_backend']);
        }

        /**
         * Loads backend files.
         */
        public static function enqueue_backend()
        {
            wp_register_script('d3', plugins_url('/inventor-statistics/libraries/d3/d3.v3.js'), ['jquery'], false,
                true);
            wp_enqueue_script('d3');
            wp_register_script('nvd3', plugins_url('/inventor-statistics/libraries/nvd3/nv.d3.min.js'), ['jquery'],
                false, true);
            wp_enqueue_script('nvd3');
            wp_register_style('nvd3', plugins_url('/inventor-statistics/libraries/nvd3/nv.d3.min.css'));
            wp_enqueue_style('nvd3');
            wp_register_script('inventor-statistics-charts',
                plugins_url('/inventor-statistics/assets/js/inventor-statistics.js'), ['jquery'], false, true);
            wp_enqueue_script('inventor-statistics-charts');
            wp_register_style('inventor-statistics',
                plugins_url('/inventor-statistics/assets/css/inventor-statistics.css'));
            wp_enqueue_style('inventor-statistics');
        }
    }

    Inventor_Statistics_Scripts::init();

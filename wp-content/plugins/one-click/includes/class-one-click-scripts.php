<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class One_Click_Scripts.
     * @class  One_Click_Scripts
     * @author Pragmatic Mates
     */
    class One_Click_Scripts
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
            wp_register_script('one-click', plugins_url('/one-click/assets/js/one-click.js'), ['jquery'], false, true);
            wp_enqueue_script('one-click');
            wp_register_style('one-click', plugins_url('/one-click/assets/css/one-click.css'));
            wp_enqueue_style('one-click');
        }
    }

    One_Click_Scripts::init();

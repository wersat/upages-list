<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_FAQ_Widgets.
     * @class  Inventor_FAQ_Widgets
     * @author Pragmatic Mates
     */
    class Inventor_FAQ_Widgets
    {
        /**
         * Initialize widgets.
         */
        public static function init()
        {
            self::includes();
            add_action('widgets_init', [__CLASS__, 'register']);
        }

        /**
         * Include widget classes.
         */
        public static function includes()
        {
            require_once INVENTOR_FAQ_DIR . 'includes/widgets/class-inventor-faq-widget-faq.php';
        }

        /**
         * Register widgets.
         */
        public static function register()
        {
            register_widget('Inventor_FAQ_Widget_FAQ');
        }
    }

    Inventor_FAQ_Widgets::init();

<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Partners_Widgets.
     * @class  Inventor_Partners_Widgets
     * @author Pragmatic Mates
     */
    class Inventor_Partners_Widgets
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
            require_once INVENTOR_PARTNERS_DIR . 'includes/widgets/class-inventor-partners-widget-partners.php';
        }

        /**
         * Register widgets.
         */
        public static function register()
        {
            register_widget('Inventor_Partners_Widget_Partners');
        }
    }

    Inventor_Partners_Widgets::init();

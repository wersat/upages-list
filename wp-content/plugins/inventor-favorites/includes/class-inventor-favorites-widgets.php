<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Favorites_Widgets.
     * @class  Inventor_Favorites_Widgets
     * @author Pragmatic Mates
     */
    class Inventor_Favorites_Widgets
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
            require_once INVENTOR_FAVORITES_DIR . 'includes/widgets/class-inventor-favorites-widget-favorites.php';
        }

        /**
         * Register widgets.
         */
        public static function register()
        {
            register_widget('Inventor_Favorites_Widget_Favorites');
        }
    }

    Inventor_Favorites_Widgets::init();

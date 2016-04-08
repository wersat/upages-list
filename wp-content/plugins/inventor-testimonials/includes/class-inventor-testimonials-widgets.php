<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Testimonials_Widgets.
     * @class  Inventor_Testimonials_Widgets
     * @author Pragmatic Mates
     */
    class Inventor_Testimonials_Widgets
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
            require_once INVENTOR_TESTIMONIALS_DIR . 'includes/widgets/class-inventor-testimonials-widget-testimonials.php';
        }

        /**
         * Register widgets.
         */
        public static function register()
        {
            register_widget('Inventor_Testimonials_Widget_Testimonials');
        }
    }

    Inventor_Testimonials_Widgets::init();

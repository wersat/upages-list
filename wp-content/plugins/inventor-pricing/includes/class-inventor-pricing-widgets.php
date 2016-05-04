<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Pricing_Widgets.
     * @class  Inventor_Pricing_Widgets
     * @author Pragmatic Mates
     */
    class Inventor_Pricing_Widgets
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
            require_once INVENTOR_PRICING_DIR . 'includes/widgets/class-inventor-pricing-widget-pricing-tables.php';
        }

        /**
         * Register widgets.
         */
        public static function register()
        {
            register_widget('Inventor_Pricing_Widget_Pricing_Tables');
        }
    }

    Inventor_Pricing_Widgets::init();

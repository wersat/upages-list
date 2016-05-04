<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Widgets.
     *
     * @class  Inventor_Widgets
     * @author Pragmatic Mates
     */
class Inventor_Widgets
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
        include_once INVENTOR_WIDGETS_DIR . '/class-inventor-widget-filter.php';
        include_once INVENTOR_WIDGETS_DIR . '/class-inventor-widget-listings.php';
        include_once INVENTOR_WIDGETS_DIR . '/class-inventor-widget-listing-author.php';
        include_once INVENTOR_WIDGETS_DIR . '/class-inventor-widget-listing-categories.php';
        include_once INVENTOR_WIDGETS_DIR . '/class-inventor-widget-listing-categories-boxes.php';
        include_once INVENTOR_WIDGETS_DIR . '/class-inventor-widget-listing-details.php';
        include_once INVENTOR_WIDGETS_DIR . '/class-inventor-widget-listing-inquire.php';
        include_once INVENTOR_WIDGETS_DIR . '/class-inventor-widget-opening-hours.php';
    }

    /**
         * Register widgets.
         */
    public static function register()
    {
        register_widget('Inventor_Widget_Filter');
        register_widget('Inventor_Widget_Listings');
        register_widget('Inventor_Widget_Listing_Author');
        register_widget('Inventor_Widget_Listing_Categories');
        register_widget('Inventor_Widget_Listing_Categories_Boxes');
        register_widget('Inventor_Widget_Listing_Details');
        register_widget('Inventor_Widget_Listing_Inquire');
        register_widget('Inventor_Widget_Opening_Hours');
    }
}

    Inventor_Widgets::init();

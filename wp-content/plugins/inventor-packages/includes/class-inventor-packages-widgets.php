<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Inventor_Packages_Widgets.
 *
 * @class Inventor_Packages_Widgets
 *
 * @author Pragmatic Mates
 */
class Inventor_Packages_Widgets
{
    /**
     * Initialize widgets.
     */
    public static function init()
    {
        self::includes();
        add_action('widgets_init', array(__CLASS__, 'register'));
    }

    /**
     * Include widget classes.
     */
    public static function includes()
    {
        require_once INVENTOR_DIR.'includes/widgets/class-inventor-packages-widget-packages.php';
    }

    /**
     * Register widgets.
     */
    public static function register()
    {
        register_widget('Inventor_Packages_Widget_Packages');
    }
}

Inventor_Packages_Widgets::init();

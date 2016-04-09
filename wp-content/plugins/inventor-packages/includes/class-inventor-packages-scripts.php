<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Inventor_Packages_Scripts.
 *
 * @class Inventor_Scripts
 *
 * @author Pragmatic Mates
 */
class Inventor_Packages_Scripts
{
    /**
     * Initialize scripts.
     */
    public static function init()
    {
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_backend'));
    }

    /**
     * Loads backend files.
     */
    public static function enqueue_backend($hook)
    {
        wp_register_script('inventor-packages-admin', plugins_url('/inventor-packages/assets/js/inventor-packages-admin.js'), array('jquery'), false, true);
        wp_enqueue_script('inventor-packages-admin');
    }
}

Inventor_Packages_Scripts::init();

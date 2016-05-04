<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Scripts.
     *
     * @class  Inventor_Scripts
     * @author Pragmatic Mates
     */
class Inventor_Scripts
{
    /**
         * Initialize scripts.
         */
    public static function init()
    {
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_frontend']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_backend']);
    }

    /**
         * Loads frontend files.
         */
    public static function enqueue_frontend()
    {
        wp_register_script('inventor', plugins_url('/inventor/assets/js/inventor.js'), ['jquery'], false, true);
        wp_enqueue_script('inventor');
        wp_register_style('inventor-poi', plugins_url('/inventor/assets/fonts/inventor-poi/style.css'));
        wp_enqueue_style('inventor-poi');
        wp_register_script(
            'masonry', plugins_url('/inventor-testimonials/assets/libraries/masonry.min.js'),
            ['jquery'], false, true
        );
        wp_enqueue_script('masonry');
    }

    /**
         * Loads backend files.
         */
    public static function enqueue_backend($hook)
    {
        wp_register_style('inventor-basic', plugins_url('/inventor/assets/fonts/inventor-basic/style.css'));
        wp_enqueue_style('inventor-basic');
        wp_register_style('inventor-admin', plugins_url('/inventor/assets/css/inventor-admin.css'));
        wp_enqueue_style('inventor-admin');
        wp_register_script(
            'inventor-admin', plugins_url('/inventor/assets/js/inventor-admin.js'), ['jquery'],
            false, true
        );
        wp_enqueue_script('inventor-admin');
        $browser_key = get_theme_mod('inventor_general_google_browser_key');
        $key         = empty($browser_key) ? '' : 'key=' . $browser_key . '&';
        wp_enqueue_script(
            'google-maps',
            '//maps.googleapis.com/maps/api/js?' . $key . 'libraries=weather,geometry,visualization,places,drawing'
        );
        if ('widgets.php' === $hook) {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');
        }
        wp_register_style('inventor-poi', plugins_url('/inventor/assets/fonts/inventor-poi/style.css'));
        wp_enqueue_style('inventor-poi');
    }
}

    Inventor_Scripts::init();

<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class One_Click_Menu.
     * @class  One_Click_Menu
     * @author Pragmatic Mates
     */
    class One_Click_Menu
    {
        /**
         * Initialize scripts.
         */
        public static function init()
        {
            add_action('admin_menu', [__CLASS__, 'admin_menu']);
        }

        /**
         * Add one click installation menu link.
         */
        public static function admin_menu()
        {
            add_submenu_page('tools.php', __('One Click Installation', 'one-click'),
                __('One Click Installation', 'one-click'), 'manage_options', 'one-click',
                ['One_Click_Launcher', 'template']);
        }
    }

    One_Click_Menu::init();

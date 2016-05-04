<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Admin_Notices.
     *
     * @class  Inventor_Admin_Notices
     * @author Pragmatic Mates
     */
class Inventor_Admin_Notices
{
    /**
         * List of notices defined in format identifier => template.
         */
    private static $notices
    = [
        'welcome' => 'notices/welcome',
    ];

    /**
         * Initialize.
         */
    public static function init()
    {
        add_action('admin_notices', [__CLASS__, 'show']);
        add_action('wp_loaded', [__CLASS__, 'hide']);
    }

    /**
         * Show all not hidden notices.
         */
    public static function show()
    {
        $hidden_notices = get_option('inventor_admin_hidden_notices', []);
        foreach (self::$notices as $id => $template) {
            if (! in_array($id, $hidden_notices)) {
                echo Inventor_Template_Loader::load($template);
            }
        }
    }

    /**
         * Hide notice.
         */
    public static function hide()
    {
        if (! empty($_GET['inventor-hide-notice'])) {
            if (! wp_verify_nonce($_GET['_inventor_notice_nonce'], 'inventor_hide_notices_nonce')) {
                wp_die(__('Please refresh the page and retry action.', 'inventor'));
            }
            $notices   = get_option('inventor_admin_hidden_notices', []);
            $notices[] = $_GET['inventor-hide-notice'];
            $notices   = Inventor_Utilities::array_unique_multidimensional($notices);
            update_option('inventor_admin_hidden_notices', $notices);
        }
    }

    /**
         * Count number of columns in plugins table.
     *
         * @return int
         */
    public static function plugins_table_cols_count()
    {
        $table = _get_list_table('WP_Plugins_List_Table');

        return $table->get_column_count();
    }
}

    Inventor_Admin_Notices::init();

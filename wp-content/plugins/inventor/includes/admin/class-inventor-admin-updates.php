<?php

    /**
     * Class Inventor_Admin_Updates.
     * @class  Inventor_Admin_Updates
     * @author Pragmatic Mates
     */
    class Inventor_Admin_Updates
    {
        public static $plugins = [];

        /**
         * Initialize.
         */
        public static function init()
        {
            //add_filter('pre_set_site_transient_update_plugins', [__CLASS__, 'check_update']);
            $is_inventor = ! empty($_GET['action']) && strpos($_GET['action'], 'inventor', 0);
            if (defined('DOING_AJAX') && false === $is_inventor) {
                add_action('site_transient_update_plugins', [__CLASS__, 'check_update']);
            }
            add_action('wp', [__CLASS__, 'check_purchase_code']);
            add_action('wp_ajax_inventor_verify_purchase_code', [__CLASS__, 'verify_purchase_code']);
        }

        /**
         * Check for updates.
         *
         * @param $transient
         */
        public static function check_update($transient)
        {
            $purchase_code = get_theme_mod('inventor_purchase_code', null);
            if (count(self::$plugins) === 0) {
                if ( ! empty($purchase_code)) {
                    $response = wp_remote_get(INVENTOR_API_PLUGINS_URL . '?purchase-code=' . $purchase_code);
                } else {
                    $response = wp_remote_get(INVENTOR_API_PLUGINS_URL);
                }
                if ($response instanceof WP_Error) {
                    return $transient;
                }
                self::$plugins = json_decode($response['body']);
            }
            if (is_array(self::$plugins)) {
                foreach (self::$plugins as $plugin) {
                    $plugin_name = sprintf('%s/%s.php', $plugin->slug, $plugin->slug);
                    if ( ! file_exists(WP_PLUGIN_DIR . '/' . $plugin_name)) {
                        continue;
                    }
                    if (empty($plugin->current_version)) {
                        continue;
                    }
                    $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin_name);
                    $version     = version_compare($plugin_data['Version'], $plugin->current_version, '<');
                    if ($version) {
                        $obj                 = new stdClass();
                        $obj->id             = 0;
                        $obj->slug           = $plugin->slug;
                        $obj->plugin         = $plugin_name;
                        $obj->new_version    = $plugin->current_version;
                        $obj->upgrade_notice = '';
                        // Purchase code is valid so the package is available
                        if ( ! empty($plugin->package) && ! empty($purchase_code)) {
                            $obj->package = sprintf('%s?purchase-code=%s', $plugin->package, $purchase_code);
                        }
                        $transient->response[$plugin_name] = $obj;
                    }
                }
            }

            return $transient;
        }

        public static function check_purchase_code()
        {
            $transient     = get_site_transient('update_plugins');
            $purchase_code = get_theme_mod('inventor_purchase_code', null);
            if (empty($purchase_code)) {
                if (is_array($transient->no_update)) {
                    foreach ($transient->no_update as $key => $value) {
                        if (substr($key, 0, strlen('inventor')) === 'inventor') {
                            if ( ! empty($value['package'])) {
                                $transient->no_update[$value]['package'];
                            }
                        }
                    }
                }
            }
            set_site_transient('update_plugins', $transient);
        }

        /**
         * Verify purchase code.
         */
        public static function verify_purchase_code()
        {
            header('HTTP/1.0 200 OK');
            header('Content-Type: application/json');
            // Missing purchase code
            if (empty($_GET['purchase-code'])) {
                echo json_encode([
                    'valid' => false,
                ]);
                exit;
            }
            // Check the purchase code on server
            $response = wp_remote_get(INVENTOR_API_VERIFY_URL . '?purchase-code=' . $_GET['purchase-code']);
            // Server is not responding or an error occurred
            if ($response instanceof WP_Error) {
                echo json_encode([
                    'valid' => false,
                    //				'error' => true,
                ]);
                exit();
            }
            $result = json_decode($response['body']);
            // Purchase code is valid
            if ('1' === $result->valid) {
                set_theme_mod('inventor_purchase_code', $_GET['purchase-code']);
                echo json_encode([
                    'valid' => true,
                ]);
                exit();
            }
            echo json_encode([
                'valid' => false,
            ]);
            exit();
        }
    }

    Inventor_Admin_Updates::init();

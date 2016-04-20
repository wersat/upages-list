<?php

    class VP_WP_Util
    {
        public static function kses_html($html)
        {
            if (function_exists('wp_kses_allowed_html')) {
                $allowed_post_html = wp_kses_allowed_html('post');
            } else {
                global $allowedposttags;
                $allowed_post_html = $allowedposttags;
            }
            $allow = array_merge($allowed_post_html, [
                'link' => [
                    'href' => true,
                    'rel' => true,
                    'type' => true,
                ],
                'style' => [
                    'type' => true,
                ],
            ]);

            return wp_kses($html, $allow);
        }

        public static function admin_notice($message, $is_error = false)
        {
            if ($is_error) {
                echo '<div class="error">';
            } else {
                echo '<div class="updated">';
            }
            echo "<p><strong>$message</strong></p></div>";
        }
    }

<?php

    /**
     * Class VP_WP_Admin
     */
    class VP_WP_Admin
    {
        /**
         * [taken from WPAlchemy Class by Dimas Begunoff]
         * Used to check if creating or editing a post or page.
         * @static
         * @return string "post" or "page"
         */
        public static function is_post_or_page()
        {
            $post_or_page = '';
            $post_type = self::get_current_post_type();
            if (isset($post_type)) {
                $post_or_page = 'page' == $post_type ? 'page' : 'post';
            }

            return $post_or_page;
        }

        /**
         * [taken from WPAlchemy Class by Dimas Begunoff]
         * Used to check for the current post type, works when creating or editing a
         * new post, page or custom post type.
         * @static
         * @return string [custom_post_type], page or post
         */
        public static function get_current_post_type()
        {
            if ( ! class_exists('WPAlchemy_MetaBox')) {
                require_once VP_FileSystem::instance()
                                          ->resolve_path('includes', 'wpalchemy/MetaBox');
            }
            $uri = $_SERVER['REQUEST_URI'] ?? null;
            if (isset($uri)) {
                $uri_parts = parse_url($uri);
                $file      = basename($uri_parts['path']);
                if ($uri and in_array($file, ['post.php', 'post-new.php'])) {
                    $post_id   = WPAlchemy_MetaBox::_get_post_id();
                    $post_type = $_GET['post_type'] ?? null;
                    $post_type = $post_id ? get_post_type($post_id) : $post_type;
                    if (isset($post_type)) {
                        return $post_type;
                    } else {
                        // because of the 'post.php' and 'post-new.php' checks above, we can default to 'post'
                        return 'post';
                    }
                }
            }

            return;
        }
    }

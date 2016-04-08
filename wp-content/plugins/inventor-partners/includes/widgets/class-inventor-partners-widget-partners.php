<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Partners_Widget_Partners.
     * @class  Inventor_Partners_Widget_Partners
     * @author Pragmatic Mates
     */
    class Inventor_Partners_Widget_Partners extends WP_Widget
    {
        /**
         * Initialize widget.
         */
        public function __construct()
        {
            parent::__construct('partners', __('Partners', 'inventor-partners'), [
                    'description' => __('Displays partners widget', 'inventor-partners'),
                ]);
        }

        /**
         * Frontend.
         *
         * @param array $args
         * @param array $instance
         */
        public function widget($args, $instance)
        {
            $query = [
                'post_type'      => 'partner',
                'posts_per_page' => ! empty($instance['count']) ? $instance['count'] : 3,
            ];
            if ( ! empty($instance['ids'])) {
                $ids               = explode(',', $instance['ids']);
                $query['post__in'] = $ids;
            }
            query_posts($query);
            include Inventor_Template_Loader::locate('widgets/partners', INVENTOR_PARTNERS_DIR);
            wp_reset_query();
        }

        /**
         * Update.
         *
         * @param array $new_instance
         * @param array $old_instance
         *
         * @return array
         */
        public function update($new_instance, $old_instance)
        {
            return $new_instance;
        }

        /**
         * Backend.
         *
         * @param array $instance
         */
        public function form($instance)
        {
            include Inventor_Template_Loader::locate('widgets/partners-admin', INVENTOR_PARTNERS_DIR);
            include Inventor_Template_Loader::locate('widgets/advanced-options-admin');
        }
    }

<?php
    /**
     * Widget definition file.
     */
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Superlist_Widget_Cover.
     * @class  Superlist_Widget_Cover
     * @author Pragmatic Mates
     */
    class Superlist_Widget_Video_Cover extends WP_Widget
    {
        /**
         * Initialize widget.
         */
        public function __construct()
        {
            parent::__construct('video_cover', __('Video Cover', 'superlist'), [
                'description' => __('Displays small filter with video or image background.', 'superlist'),
            ]);
        }

        /**
         * Backend.
         *
         * @param array $instance Current widget instance.
         */
        public function form($instance)
        {
            include WIDGETS_TPL_DIR . '/widget-video-cover-admin.php';
        }

        /**
         * Update.
         *
         * @param array $new_instance New widget instance.
         * @param array $old_instance Old widget instance.
         *
         * @return array
         */
        public function update($new_instance, $old_instance)
        {
            return $new_instance;
        }

        /**
         * Frontend.
         *
         * @param array $args     Widget arguments.
         * @param array $instance Current widget instance.
         */
        public function widget($args, $instance)
        {
            include WIDGETS_TPL_DIR . '/widget-video-cover.php';
        }
    }

<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Testimonials_Widget_Testimonials.
     * @class  Inventor_Testimonials_Widget_Testimonials
     * @author Pragmatic Mates
     */
    class Inventor_Testimonials_Widget_Testimonials extends WP_Widget
    {
        /**
         * Initialize widget.
         */
        public function __construct()
        {
            parent::__construct('testimonials', __('Testimonials', 'inventor-testimonials'), [
                'description' => __('Displays Testimonials.', 'inventor-testimonials'),
            ]);
        }

        /**
         * Backend.
         *
         * @param array $instance
         */
        public function form($instance)
        {
            include Inventor_Template_Loader::locate('widgets/testimonials-admin', INVENTOR_TESTIMONIALS_DIR);
            include Inventor_Template_Loader::locate('widgets/advanced-options-admin');
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
         * Frontend.
         *
         * @param array $args
         * @param array $instance
         */
        public function widget($args, $instance)
        {
            query_posts([
                'post_type'      => 'testimonial',
                'posts_per_page' => ! empty($instance['count']) ? $instance['count'] : 4,
            ]);
            include Inventor_Template_Loader::locate('widgets/testimonials', INVENTOR_TESTIMONIALS_DIR);
            wp_reset_query();
        }
    }

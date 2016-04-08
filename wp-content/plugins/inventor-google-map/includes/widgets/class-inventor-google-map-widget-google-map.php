<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Google_Map_Widget_Google_Map.
     * @class  Inventor_Google_Map_Widget_Google_Map
     * @author Pragmatic Mates
     */
    class Inventor_Google_Map_Widget_Google_Map extends WP_Widget
    {
        /**
         * Initialize widget.
         */
        public function __construct()
        {
            parent::__construct('google-map', __('Google Map', 'inventor-google-map'), [
                    'description' => __('Displays listings in the google map.', 'inventor-google-map'),
                ]);
            add_action('body_class', [__CLASS__, 'add_body_class']);
            add_action('inventor_google_map_infobox_image', [__CLASS__, 'render_favorite_button'], 0, 1);
        }

        /**
         * Adds classes to body.
         *
         * @param $classes array
         *
         * @return array
         */
        public static function add_body_class($classes)
        {
            $settings = get_option('widget_google-map');
            if (is_array($settings)) {
                foreach ($settings as $key => $value) {
                    if (is_active_widget(false, 'google-map-' . $key, 'google-map')) {
                        if ( ! empty($value['body_classes'])) {
                            $parts   = explode(',', $value['body_classes']);
                            $classes = array_merge($classes, $parts);
                        }
                    }
                }
            }

            return $classes;
        }

        /**
         * Backend.
         *
         * @param array $instance
         */
        public function form($instance)
        {
            include Inventor_Template_Loader::locate('widgets/google-map-admin', INVENTOR_GOOGLE_MAP_DIR);
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
            include Inventor_Template_Loader::locate('widgets/google-map', INVENTOR_GOOGLE_MAP_DIR);
        }

        /**
         * Renders favorite button.
         *
         * @param int $listing_id
         */
        public static function render_favorite_button($listing_id)
        {
            if (class_exists('Inventor_Favorites')) {
                Inventor_Favorites_Logic::render_favorite_button($listing_id);
            }
        }
    }

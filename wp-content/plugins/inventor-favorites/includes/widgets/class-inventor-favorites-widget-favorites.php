<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Favorites_Widget_Favorites.
     * @class  Inventor_Widget_Favorites
     * @author Pragmatic Mates
     */
    class Inventor_Favorites_Widget_Favorites extends WP_Widget
    {
        /**
         * Initialize widget.
         */
        public function __construct()
        {
            parent::__construct('favorites_widget', __('Favorite listings', 'inventor-favorites'), [
                'description' => __('Favorite listings.', 'inventor-favorites'),
            ]);
        }

        /**
         * Backend.
         *
         * @param array $instance
         */
        public function form($instance)
        {
            include Inventor_Template_Loader::locate('widgets/favorites-admin', $plugin_dir = INVENTOR_FAVORITES_DIR);
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
            Inventor_Favorites_Logic::loop_my_favorites();
            include Inventor_Template_Loader::locate('widgets/favorites', $plugin_dir = INVENTOR_FAVORITES_DIR);
            wp_reset_query();
        }
    }

<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Widget_Listing_Categories_Boxes.
     *
     * @class  Inventor_Widget_Listing_Categories_Boxes
     * @author Pragmatic Mates
     */
class Inventor_Widget_Listing_Categories_Boxes extends WP_Widget
{
    /**
         * Initialize widget.
         */
    public function __construct()
    {
        parent::__construct(
            'listing_categories_boxes', __('Listing Categories Boxes', 'inventor'), [
            'description' => __('Displays listing categories in boxes.', 'inventor'),
            ]
        );
    }

    /**
         * Backend.
         *
         * @param array $instance
         */
    public function form($instance)
    {
        include Inventor_Template_Loader::locate('widgets/listing-categories-boxes-admin');
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
        $data = [
            'hide_empty' => false,
            'parent'     => 0,
        ];
        $listing_categories_count = count($instance['listing_categories']);

        if (! empty($instance['listing_categories']) && is_array($instance['listing_categories']) && $listing_categories_count > 0) {
            $data['include'] = implode(',', $instance['listing_categories']);
        }
        $terms = get_terms('listing_categories', $data);
        include Inventor_Template_Loader::locate('widgets/listing-categories-boxes');
        wp_reset_query();
    }
}

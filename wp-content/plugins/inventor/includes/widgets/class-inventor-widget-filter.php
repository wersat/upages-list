<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Widget_Filter.
     *
     * @class  Inventor_Widget_Filter
     * @author Pragmatic Mates
     */
class Inventor_Widget_Filter extends WP_Widget
{
    /**
         * Initialize widget.
         */
    public function __construct()
    {
        parent::__construct(
            'filter', __('Filter', 'inventor'), [
            'description' => __('Filter for filtering listings.', 'inventor'),
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
        include Inventor_Template_Loader::locate('widgets/filter-admin');
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
        include Inventor_Template_Loader::locate('widgets/filter');
    }
}

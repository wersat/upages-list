<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Inventor_Packages_Widget_Packages.
 *
 * @class Inventor_Packages_Widget_Packages
 *
 * @author Pragmatic Mates
 */
class Inventor_Packages_Widget_Packages extends WP_Widget
{
    /**
     * Initialize widget.
     */
    public function Inventor_Packages_Widget_Packages()
    {
        parent::__construct(
            'packages',
            __('Packages', 'inventor-packages'),
            array(
                'description' => __('Displays available packages.', 'inventor-packages'),
            )
        );
    }

    /**
     * Frontend.
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        query_posts(array(
            'post_type' => 'package',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ));

        include Inventor_Template_Loader::locate('widgets/packages', INVENTOR_PACKAGES_DIR);

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
        include Inventor_Template_Loader::locate('widgets/packages-admin', INVENTOR_PACKAGES_DIR);
        include Inventor_Template_Loader::locate('widgets/advanced-options-admin');
    }
}

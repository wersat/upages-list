<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Listing_Slider_Extend.
     * @class  Inventor_Listing_Slider_Extend
     * @author Pragmatic Mates
     */
    class Inventor_Listing_Slider_Extend
    {
        /**
         * Initialize scripts.
         */
        public static function init()
        {
            add_action('cmb2_init', [__CLASS__, 'add_image_slider_field'], 9999);
        }

        public static function add_image_slider_field($metaboxes)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . '_listing_slider',
                'title'        => __('Listing Slider', 'inventor-listing-slider'),
                'object_types' => Inventor_Post_Types::get_listing_post_types(),
                'context'      => 'normal',
                'priority'     => 'high',
                'skip'         => true,
            ]);
            $cmb->add_field([
                'name' => __('Image', 'inventor'),
                'id'   => INVENTOR_LISTING_PREFIX . 'listing_slider_image',
                'type' => 'file',
            ]);
        }
    }

    Inventor_Listing_Slider_Extend::init();

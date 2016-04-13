<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Metaboxes.
     * @class  Inventor_Metaboxes
     * @author Pragmatic Mates
     */
    class Inventor_Metaboxes
    {
        /**
         * Set default data for field.
         *
         * @param $data
         * @param $object_id
         * @param $a
         * @param $field
         *
         * @return mixed
         */
        public static function set_default_value($data, $object_id, $a, $field)
        {
            if ( ! empty($field->args['custom_value'])) {
                return $field->args['custom_value'];
            }

            return $data;
        }

        /**
         * Returns metabox key from its id by removing listing and post type prefixes.
         *
         * @param string $metabox_id
         * @param string $post_type
         *
         * @return string
         */
        public static function get_metabox_key($metabox_id, $post_type)
        {
            $parts = explode('_', $metabox_id);
            if (strpos($metabox_id, $post_type) === strlen($parts[0]) + 1) {
                unset($parts[0]); // unset listing
                unset($parts[1]); // unset post type
                $metabox_key = implode('_', $parts); // the rest is metabox key
                return $metabox_key;
            }

            return $metabox_id;
        }

        /**
         * General fields.
         *
         * @param $post_type
         */
        public static function metabox_general($post_type)
        {
            if (is_admin()) {
                return;
            }
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_general',
                'title'        => __('General', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
                'skip'         => true,
            ]);
            $cmb->add_field([
                'name'       => __('Title', 'inventor'),
                'id'         => INVENTOR_LISTING_PREFIX . 'title',
                'type'       => 'text',
                'attributes' => [
                    'required' => 'required',
                ],
                'default'    => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_general',
                    INVENTOR_LISTING_PREFIX . 'title'),
            ]);
            $cmb->add_field([
                'name'    => __('Description', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'description',
                'type'    => 'wysiwyg',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_general',
                    INVENTOR_LISTING_PREFIX . 'description'),
                'options' => [
                    'textarea_rows' => 10,
                    'media_buttons' => false,
                ],
            ]);
            $cmb->add_field([
                'name'    => __('Featured Image', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'featured_image',
                'type'    => 'file',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_general',
                    INVENTOR_LISTING_PREFIX . 'featured_image'),
            ]);
        }

        /**
         * FAQ.
         * @return array
         */
        public static function metabox_faq($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_faq',
                'title'        => __('FAQ', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
                'skip'         => true,
            ]);
            if ( ! is_admin()) {
                add_filter('cmb2_override_listing_faq_group_meta_value', [__CLASS__, 'set_default_value'], 0, 4);
            }
            $default = Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_faq',
                INVENTOR_LISTING_PREFIX . 'faq');
            $group = $cmb->add_field([
                'id'           => INVENTOR_LISTING_PREFIX . 'faq',
                'type'         => 'group',
                'post_type'    => $post_type,
                'repeatable'   => true,
                'custom_value' => $default,
                'options'      => [
                    'group_title'   => __('FAQ', 'inventor'),
                    'add_button'    => __('Add Another FAQ', 'inventor'),
                    'remove_button' => __('Remove FAQ', 'inventor'),
                ],
            ]);
            $cmb->add_group_field($group, [
                'id'           => INVENTOR_LISTING_PREFIX . 'question',
                'name'         => __('Question', 'inventor'),
                'type'         => 'text',
                'custom_value' => $default,
            ]);
            $cmb->add_group_field($group, [
                'id'           => INVENTOR_LISTING_PREFIX . 'answer',
                'name'         => __('Answer', 'inventor'),
                'type'         => 'textarea',
                'custom_value' => $default,
            ]);
        }

        /**
         * Branding.
         * @return array
         */
        public static function metabox_branding($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_branding',
                'title'        => __('Branding', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $cmb->add_field([
                'name'    => __('Slogan', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'slogan',
                'type'    => 'text',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_branding',
                    INVENTOR_LISTING_PREFIX . 'slogan'),
            ]);
            $cmb->add_field([
                'name'    => __('Brand color', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'brand_color',
                'type'    => 'colorpicker',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_branding',
                    INVENTOR_LISTING_PREFIX . 'brand_color'),
            ]);
            $cmb->add_field([
                'name'    => __('Logo', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'logo',
                'type'    => 'file',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_branding',
                    INVENTOR_LISTING_PREFIX . 'logo'),
                'skip'    => true,
            ]);
        }

        /**
         * Banner.
         *
         * @param $post_type
         */
        public static function metabox_banner($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_banner',
                'title'        => __('Banner', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
                'skip'         => true,
            ]);
            $options = [
                'banner_featured_image' => __('Featured Image', 'inventor'),
                'banner_image'          => __('Custom Image', 'inventor'),
                'banner_video'          => __('Video', 'inventor'),
            ];
            if (class_exists('Inventor_Google_Map')) {
                $options['banner_map'] = __('Google Map', 'inventor');
                // TODO: check if street/inside view is enabled
                $options['banner_street_view'] = __('Google Street View', 'inventor');
                $options['banner_inside_view'] = __('Google Inside View', 'inventor');
            }
            // Banner Type
            $default_type
                = Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_banner',
                INVENTOR_LISTING_PREFIX . 'banner');
            $cmb->add_field([
                'name'        => __('Banner Type', 'inventor'),
                'id'          => INVENTOR_LISTING_PREFIX . 'banner',
                'type'        => 'radio',
                'default'     => ! empty($default_type) ? $default_type : 'banner_featured_image',
                'skip'        => true,
                'options'     => $options,
                'row_classes' => 'cmb-row-banner banner-type',
                'description' => "<span class='banner-map'>" . __('To set map position go to section <strong>Location</strong>.',
                        'inventor') . "</span>
			                        <span class='banner-street-view'>" . __('To set Street View go to section <strong>Location</strong>. Do not forget to <strong>enable</strong> Street View.',
                        'inventor') . "</span>
			                        <span class='banner-inside-view'>" . __('To set Inside View go to section <strong>Location</strong>. Do not forget to <strong>enable</strong> Inside View.',
                        'inventor') . '</span>',
            ]);
            // Custom Image
            $cmb->add_field([
                'name'        => __('Custom Image', 'inventor'),
                'id'          => INVENTOR_LISTING_PREFIX . 'banner_image',
                'type'        => 'file',
                'desc'        => __('Upload an image.', 'inventor'),
                'default'     => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_banner',
                    INVENTOR_LISTING_PREFIX . 'banner_image'),
                'row_classes' => 'cmb-row-banner banner-image',
            ]);
            // Video
            $cmb->add_field([
                'name'        => __('Video', 'inventor'),
                'id'          => INVENTOR_LISTING_PREFIX . 'banner_video',
                'type'        => 'file',
                'desc'        => __('Upload video file in .mp4 format.', 'inventor'),
                'default'     => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_banner',
                    INVENTOR_LISTING_PREFIX . 'banner_video'),
                'row_classes' => 'cmb-row-banner banner-video',
            ]);
            $cmb->add_field([
                'name'        => __('Loop', 'inventor'),
                'id'          => INVENTOR_LISTING_PREFIX . 'banner_video_loop',
                'type'        => 'checkbox',
                'desc'        => __('Check to loop video', 'inventor'),
                'default'     => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_banner',
                    INVENTOR_LISTING_PREFIX . 'banner_video_loop'),
                'row_classes' => 'cmb-row-banner banner-video',
            ]);
            // Google Map
            $default_zoom
                = Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_banner',
                INVENTOR_LISTING_PREFIX . 'zoom');
            $cmb->add_field([
                'name'        => __('Zoom', 'inventor'),
                'id'          => INVENTOR_LISTING_PREFIX . 'banner_map_zoom',
                'type'        => 'text_small',
                'default'     => ! empty($default_zoom) ? $default_zoom : 12,
                'description' => __('Minimum value of zoom is 0. Maximum value depends on location (12-25).',
                    'inventor'),
                'row_classes' => 'cmb-row-banner banner-map',
                'attributes'  => [
                    'type' => 'number',
                    'min'  => 0,
                    'max'  => 25,
                ],
            ]);
            $default_map_type
                = Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_banner',
                INVENTOR_LISTING_PREFIX . 'map_type');
            $cmb->add_field([
                'name'        => __('Map Type', 'inventor'),
                'id'          => INVENTOR_LISTING_PREFIX . 'banner_map_type',
                'type'        => 'select',
                'options'     => [
                    'ROADMAP'   => __('Roadmap', 'inventor'),
                    'SATELLITE' => __('Satellite', 'inventor'),
                    'HYBRID'    => __('Hybrid', 'inventor'),
                ],
                'default'     => ! empty($default_map_type) ? $default_map_type : 'SATELLITE',
                'row_classes' => 'cmb-row-banner banner-map',
            ]);
            $cmb->add_field([
                'name'        => __('Marker', 'inventor'),
                'id'          => INVENTOR_LISTING_PREFIX . 'banner_map_marker',
                'type'        => 'checkbox',
                'default'     => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_banner',
                    INVENTOR_LISTING_PREFIX . 'marker'),
                'description' => __('Check to show marker.', 'inventor'),
                'row_classes' => 'cmb-row-banner banner-map',
            ]);
        }

        /**
         * Gallery meta box.
         *
         * @param $post_type
         */
        public static function metabox_gallery($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_gallery',
                'title'        => __('Gallery', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
                'skip'         => true,
            ]);
            $cmb->add_field([
                'name'    => __('Gallery', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'gallery',
                'type'    => 'file_list',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_gallery',
                    INVENTOR_LISTING_PREFIX . 'gallery'),
            ]);
        }

        /**
         * Color meta box.
         *
         * @param $post_type
         */
        public static function metabox_color($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_color',
                'title'        => __('Color', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $cmb->add_field([
                'name'     => __('Color', 'inventor'),
                'id'       => INVENTOR_LISTING_PREFIX . 'color',
                'type'     => 'taxonomy_multicheck_hierarchy',
                'taxonomy' => 'colors',
                'default'  => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_color',
                    INVENTOR_LISTING_PREFIX . 'color'),
            ]);
        }

        /**
         * Video meta box.
         *
         * @param $post_type
         */
        public static function metabox_video($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_video',
                'title'        => __('Video', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
                'skip'         => true,
            ]);
            $cmb->add_field([
                'name'        => __('URL', 'inventor'),
                'id'          => INVENTOR_LISTING_PREFIX . 'video',
                'type'        => 'text_url',
                'description' => __('For more information about embeding videos and video links support please read this <a href="http://codex.wordpress.org/Embeds">article</a>.',
                    'inventor'),
                'default'     => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_video',
                    INVENTOR_LISTING_PREFIX . 'video'),
            ]);
        }

        /**
         * Listing category meta box.
         *
         * @param $post_type
         */
        public static function metabox_listing_category($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_listing_category',
                'title'        => __('Listing categories', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $cmb->add_field([
                'name'     => __('Listing categories', 'inventor'),
                'id'       => INVENTOR_LISTING_PREFIX . 'listing_category',
                'type'     => 'taxonomy_multicheck_hierarchy',
                'taxonomy' => 'listing_categories',
                'default'  => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_listing_category',
                    INVENTOR_LISTING_PREFIX . 'listing_category'),
            ]);
        }

        /**
         * Opening hours meta box.
         *
         * @param $post_type
         */
        public static function metabox_opening_hours($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_opening_hours',
                'title'        => __('Opening Hours', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
                'skip'         => true,
            ]);
            $cmb->add_field([
                'id'          => INVENTOR_LISTING_PREFIX . 'opening_hours',
                'type'        => 'opening_hours',
                'time_format' => 'H:i',
                'post_type'   => $post_type,
                'escape_cb'   => ['Inventor_Field_Types_Opening_Hours', 'escape'],
                'default'     => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_opening_hours',
                    INVENTOR_LISTING_PREFIX . 'opening_hours'),
            ]);
        }

        /**
         * Contact meta box.
         *
         * @param $post_type
         */
        public static function metabox_contact($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_contact',
                'title'        => __('Contact', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
                'skip'         => true,
            ]);
            $cmb->add_field([
                'id'      => INVENTOR_LISTING_PREFIX . 'email',
                'name'    => __('E-mail', 'inventor'),
                'type'    => 'text_email',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_contact',
                    INVENTOR_LISTING_PREFIX . 'email'),
            ]);
            $cmb->add_field([
                'id'      => INVENTOR_LISTING_PREFIX . 'phone',
                'name'    => __('Phone', 'inventor'),
                'type'    => 'text',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_contact',
                    INVENTOR_LISTING_PREFIX . 'phone'),
            ]);
            $cmb->add_field([
                'id'      => INVENTOR_LISTING_PREFIX . 'website',
                'name'    => __('Website', 'inventor'),
                'type'    => 'text_url',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_contact',
                    INVENTOR_LISTING_PREFIX . 'website'),
            ]);
            $cmb->add_field([
                'id'      => INVENTOR_LISTING_PREFIX . 'address',
                'name'    => __('Address', 'inventor'),
                'type'    => 'textarea',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_contact',
                    INVENTOR_LISTING_PREFIX . 'address'),
            ]);
        }

        /**
         * Social meta box.
         *
         * @param $post_type
         */
        public static function metabox_social($post_type)
        {
            $social = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_social',
                'title'        => __('Social', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
                'skip'         => true,
            ]);
            $social_networks = [ // TODO: inventor filter
                'facebook'   => 'Facebook',
                'twitter'    => 'Twitter',
                'google'     => 'Google+',
                'instagram'  => 'Instagram',
                'vimeo'      => 'Vimeo',
                'youtube'    => 'YouTube',
                'linkedin'   => 'LinkedIn',
                'dribbble'   => 'Dribbble',
                'skype'      => 'Skype',
                'foursquare' => 'Foursquare',
                'behance'    => 'Behance',
            ];
            foreach ($social_networks as $key => $title) {
                $social->add_field([
                    'id'      => INVENTOR_LISTING_PREFIX . $key,
                    'name'    => $title,
                    'type'    => 'text_medium',
                    'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_social',
                        INVENTOR_LISTING_PREFIX . $key),
                ]);
            }
        }

        /**
         * Price meta box.
         *
         * @param $post_type
         */
        public static function metabox_price($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_price',
                'title'        => __('Price', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
                'skip'         => true,
            ]);
            $cmb->add_field([
                'id'              => INVENTOR_LISTING_PREFIX . 'price',
                'name'            => __('Price', 'inventor'),
                'type'            => 'text_money',
                'before_field'    => Inventor_Price::default_currency_symbol(),
                'description'     => sprintf(__('In %s.', 'inventor'), Inventor_Price::default_currency_code()),
                'default'         => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_price',
                    INVENTOR_LISTING_PREFIX . 'price'),
                'sanitization_cb' => false,
                'attributes'      => [
                    'type'    => 'number',
                    'step'    => 'any',
                    'min'     => 0,
                    'pattern' => '\d*(\.\d*)?',
                ],
            ]);
            $cmb->add_field([
                'id'          => INVENTOR_LISTING_PREFIX . 'price_prefix',
                'name'        => __('Prefix', 'inventor'),
                'type'        => 'text_small',
                'description' => __('Any text shown before price (for example "from").', 'inventor'),
                'default'     => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_price',
                    INVENTOR_LISTING_PREFIX . 'price_prefix'),
            ]);
            $cmb->add_field([
                'id'          => INVENTOR_LISTING_PREFIX . 'price_suffix',
                'name'        => __('Suffix', 'inventor'),
                'type'        => 'text_small',
                'description' => __('Any text shown after price (for example "per night").', 'inventor'),
                'default'     => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_price',
                    INVENTOR_LISTING_PREFIX . 'price_suffix'),
            ]);
            $cmb->add_field([
                'id'          => INVENTOR_LISTING_PREFIX . 'price_custom',
                'name'        => __('Custom', 'inventor'),
                'type'        => 'text_medium',
                'description' => __('Any text instead of numeric price (for example "by agreement"). Prefix and Suffix will be ignored.',
                    'inventor'),
                'default'     => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_price',
                    INVENTOR_LISTING_PREFIX . 'price_custom'),
            ]);
        }

        /**
         * Flags meta box.
         *
         * @param $post_type
         */
        public static function metabox_flags($post_type)
        {
            if ( ! is_admin()) {
                return;
            }
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_flags',
                'title'        => __('Flags', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $cmb->add_field([
                'name'    => __('Featured', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'featured',
                'type'    => 'checkbox',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_flags',
                    INVENTOR_LISTING_PREFIX . 'featured'),
            ]);
            $cmb->add_field([
                'name'    => __('Reduced', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'reduced',
                'type'    => 'checkbox',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_flags',
                    INVENTOR_LISTING_PREFIX . 'reduced'),
            ]);
        }

        /**
         * Date meta box.
         *
         * @param $post_type
         */
        public static function metabox_date($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_date',
                'title'        => __('Date', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $cmb->add_field([
                'name'    => __('Date', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'date',
                'type'    => 'text_date_timestamp',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_date',
                    INVENTOR_LISTING_PREFIX . 'date'),
            ]);
        }

        /**
         * Date meta box.
         *
         * @param $post_type
         */
        public static function metabox_time($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_time',
                'title'        => __('Time', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $cmb->add_field([
                'name'    => __('Time', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'time',
                'type'    => 'text_time',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_time',
                    INVENTOR_LISTING_PREFIX . 'time'),
            ]);
        }

        /**
         * Date interval meta box.
         *
         * @param $post_type
         */
        public static function metabox_date_interval($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_date_interval',
                'title'        => __('Date interval', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $cmb->add_field([
                'name'    => __('Date from', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'date_from',
                'type'    => 'text_date_timestamp',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_date_interval',
                    INVENTOR_LISTING_PREFIX . 'date_from'),
            ]);
            $cmb->add_field([
                'name'    => __('Date to', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'date_to',
                'type'    => 'text_date_timestamp',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_date_interval',
                    INVENTOR_LISTING_PREFIX . 'date_to'),
            ]);
        }

        /**
         * Datetime interval meta box.
         *
         * @param $post_type
         */
        public static function metabox_datetime_interval($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_datetime_interval',
                'title'        => __('Date and time interval', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $cmb->add_field([
                'name'    => __('Date and time from', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'datetime_from',
                'type'    => 'text_datetime_timestamp',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_datetime_interval',
                    INVENTOR_LISTING_PREFIX . 'datetime_from'),
            ]);
            $cmb->add_field([
                'name'    => __('Date and time to', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'datetime_to',
                'type'    => 'text_datetime_timestamp',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_datetime_interval',
                    INVENTOR_LISTING_PREFIX . 'datetime_to'),
            ]);
        }

        /**
         * Time interval meta box.
         *
         * @param $post_type
         */
        public static function metabox_time_interval($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_time_interval',
                'title'        => __('Time interval', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $cmb->add_field([
                'name'    => __('Time from', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'time_from',
                'type'    => 'text_time',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_time_interval',
                    INVENTOR_LISTING_PREFIX . 'time_from'),
            ]);
            $cmb->add_field([
                'name'    => __('Time to', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'time_to',
                'type'    => 'text_time',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_time_interval',
                    INVENTOR_LISTING_PREFIX . 'time_to'),
            ]);
        }

        /**
         * Date and time interval meta box.
         *
         * @param $post_type
         */
        public static function metabox_date_and_time_interval($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_date_and_time_interval',
                'title'        => __('Date and time interval', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $cmb->add_field([
                'name'    => __('Date', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'date',
                'type'    => 'text_date_timestamp',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_date_and_time_interval',
                    INVENTOR_LISTING_PREFIX . 'date'),
            ]);
            $cmb->add_field([
                'name'    => __('Time from', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'time_from',
                'type'    => 'text_time',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_date_and_time_interval',
                    INVENTOR_LISTING_PREFIX . 'time_from'),
            ]);
            $cmb->add_field([
                'name'    => __('Time to', 'inventor'),
                'id'      => INVENTOR_LISTING_PREFIX . 'time_to',
                'type'    => 'text_time',
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_date_and_time_interval',
                    INVENTOR_LISTING_PREFIX . 'time_to'),
            ]);
        }

        /**
         * Location meta box.
         *
         * @param $post_type
         */
        public static function metabox_location($post_type)
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . $post_type . '_location',
                'title'        => __('Location', 'inventor'),
                'object_types' => [$post_type],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            // Google Map
            $cmb->add_field([
                'id'              => INVENTOR_LISTING_PREFIX . 'map_location',
                'name'            => __('Map Location', 'inventor'),
                'type'            => 'pw_map',
                'sanitization_cb' => 'pw_map_sanitise',
                'split_values'    => true,
                'default'         => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_location',
                    INVENTOR_LISTING_PREFIX . 'map_location'),
                'skip'            => true,
            ]);
            if (apply_filters('inventor_metabox_location_polygon_enabled', true, $post_type)) {
                // Google Map Polygon
                $cmb->add_field([
                    'id'          => INVENTOR_LISTING_PREFIX . 'map_location_polygon',
                    'name'        => __('Map Location Polygon', 'inventor'),
                    //			'description'       => __( 'Enter encoded path. It can be constructed using <a href="https://developers.google.com/maps/documentation/utilities/polylineutility" target="_blank">Interactive Polyline Encoder Utility</a>.', 'inventor' ),
                    'description' => __('Enter encoded path. It can be constructed using <a href="https://google-developers.appspot.com/maps/documentation/utilities/polylineutility_6dfa1f29011ecf2cf389dba27e343637.frame?hl=en&redesign=true" target="_blank">Interactive Polyline Encoder Utility</a>.',
                        'inventor'),
                    'type'        => 'text',
                    'default'     => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_location',
                        INVENTOR_LISTING_PREFIX . 'map_location_polygon'),
                    'skip'        => true,
                ]);
            }
            if (apply_filters('inventor_metabox_location_street_view_enabled', true, $post_type)) {
                // Google Street View
                $cmb->add_field([
                    'name'    => __('Street View', 'inventor'),
                    'id'      => INVENTOR_LISTING_PREFIX . 'street_view',
                    'type'    => 'checkbox',
                    'desc'    => __('Check to enable Street View', 'inventor'),
                    'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_location',
                        INVENTOR_LISTING_PREFIX . 'street_view'),
                    'skip'    => 'true',
                ]);
                $cmb->add_field([
                    'id'              => INVENTOR_LISTING_PREFIX . 'street_view_location',
                    'name'            => __('Street View Location', 'inventor'),
                    'type'            => 'street_view',
                    'sanitization_cb' => 'street_view_sanitise',
                    'split_values'    => true,
                    'default'         => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_location',
                        INVENTOR_LISTING_PREFIX . 'street_view_location'),
                    'skip'            => 'true',
                ]);
            }
            if (apply_filters('inventor_metabox_location_inside_view_enabled', true, $post_type)) {
                // Inside View
                $cmb->add_field([
                    'name'    => __('Inside View', 'inventor'),
                    'id'      => INVENTOR_LISTING_PREFIX . 'inside_view',
                    'type'    => 'checkbox',
                    'desc'    => __('Check to enable Inside View', 'inventor'),
                    'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_location',
                        INVENTOR_LISTING_PREFIX . 'inside_view'),
                    'skip'    => 'true',
                ]);
                $cmb->add_field([
                    'id'              => INVENTOR_LISTING_PREFIX . 'inside_view_location',
                    'name'            => __('Inside View Location', 'inventor'),
                    'type'            => 'street_view',
                    'sanitization_cb' => 'street_view_sanitise',
                    'split_values'    => true,
                    'default'         => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_location',
                        INVENTOR_LISTING_PREFIX . 'inside_view_location'),
                    'skip'            => 'true',
                ]);
            }
            // Location
            $cmb->add_field([
                'name'     => __('Location', 'inventor'),
                'id'       => INVENTOR_LISTING_PREFIX . 'locations',
                'type'     => 'taxonomy_select_hierarchy',
                'taxonomy' => 'locations',
                'default'  => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . $post_type . '_location',
                    INVENTOR_LISTING_PREFIX . 'locations'),
            ]);
        }
    }

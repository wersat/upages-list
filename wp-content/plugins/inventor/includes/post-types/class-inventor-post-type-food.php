<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Post_Type_Food.
     * @class  Inventor_Post_Type_Food
     * @author Pragmatic Mates
     */
    class Inventor_Post_Type_Food
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            add_action('cmb2_init', [__CLASS__, 'fields']);
            add_filter('inventor_claims_allowed_listing_post_types', [__CLASS__, 'allowed_claiming']);
        }

        /**
         * Defines if post type can be claimed.
         *
         * @param array $post_types
         *
         * @return array
         */
        public static function allowed_claiming($post_types)
        {
            $post_types[] = 'food';

            return $post_types;
        }

        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name'               => __('Food & Drinks', 'inventor'),
                'singular_name'      => __('Food & Drink', 'inventor'),
                'add_new'            => __('Add New Food & Drink', 'inventor'),
                'add_new_item'       => __('Add New Food & Drink', 'inventor'),
                'edit_item'          => __('Edit Food & Drink', 'inventor'),
                'new_item'           => __('New Food & Drink', 'inventor'),
                'all_items'          => __('Food & Drinks', 'inventor'),
                'view_item'          => __('View Food & Drink', 'inventor'),
                'search_items'       => __('Search Food & Drink', 'inventor'),
                'not_found'          => __('No Food & Drinks found', 'inventor'),
                'not_found_in_trash' => __('No Food & Drinks Found in Trash', 'inventor'),
                'parent_item_colon'  => '',
                'menu_name'          => __('Food & Drinks', 'inventor'),
            ];
            register_post_type('food', [
                'labels'       => $labels,
                'show_in_menu' => 'listings',
                'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
                'has_archive'  => true,
                'rewrite'      => ['slug' => _x('foods', 'URL slug', 'inventor')],
                'public'       => true,
                'show_ui'      => true,
                'categories'   => [],
            ]);
        }

        /**
         * Defines custom fields.
         * @return array
         */
        public static function fields()
        {
            Inventor_Post_Types::add_metabox('food', ['general']);
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . 'food_details',
                'title'        => __('Details', 'inventor'),
                'object_types' => ['food'],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $cmb->add_field([
                'name'     => __('Food kind', 'inventor'),
                'id'       => INVENTOR_LISTING_PREFIX . 'food_kind',
                'type'     => 'taxonomy_select',
                'taxonomy' => 'food_kinds',
            ]);
            $cmb   = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . 'food_menu',
                'title'        => __('Meals and drinks menu', 'inventor'),
                'object_types' => ['food'],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $group = $cmb->add_field([
                'id'      => INVENTOR_LISTING_PREFIX . 'food_menu_group',
                'type'    => 'group',
                'options' => [
                    'group_title'   => __('Item', 'inventor'),
                    'add_button'    => __('Add Another', 'inventor'),
                    'remove_button' => __('Remove', 'inventor'),
                ],
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . 'food_menu',
                    INVENTOR_LISTING_PREFIX . 'food_menu_group'),
            ]);
            $cmb->add_group_field($group, [
                'id'   => INVENTOR_LISTING_PREFIX . 'food_menu_title',
                'name' => __('Title', 'inventor'),
                'type' => 'text',
            ]);
            $cmb->add_group_field($group, [
                'id'   => INVENTOR_LISTING_PREFIX . 'food_menu_description',
                'name' => __('Description', 'inventor'),
                'type' => 'text',
            ]);
            $cmb->add_group_field($group, [
                'id'              => INVENTOR_LISTING_PREFIX . 'food_menu_price',
                'name'            => __('Price', 'inventor'),
                'type'            => 'text_money',
                'sanitization_cb' => false,
                'before_field'    => Inventor_Price::default_currency_symbol(),
                'description'     => sprintf(__('In %s.', 'inventor'), Inventor_Price::default_currency_code()),
            ]);
            $cmb->add_group_field($group, [
                'id'          => INVENTOR_LISTING_PREFIX . 'food_menu_serving',
                'name'        => __('Serving day', 'inventor'),
                'type'        => 'text_date_timestamp',
                'description' => __('Leave blank if it is not daily menu', 'inventor'),
            ]);
            $cmb->add_group_field($group, [
                'id'   => INVENTOR_LISTING_PREFIX . 'food_menu_speciality',
                'name' => __('Speciality', 'inventor'),
                'type' => 'checkbox',
            ]);
            $cmb->add_group_field($group, [
                'name' => __('Photo', 'inventor'),
                'id'   => INVENTOR_LISTING_PREFIX . 'food_menu_photo',
                'type' => 'file',
            ]);
            Inventor_Post_Types::add_metabox('food', [
                'gallery',
                'banner',
                'video',
                'price',
                'flags',
                'location',
                'opening_hours',
                'contact',
                'social',
                'listing_category',
            ]);
        }

        /**
         * Gets menu groups.
         *
         * @param null $post_id
         *
         * @return array
         */
        public static function get_menu_groups($post_id = null)
        {
            if (empty($post_id)) {
                $post_id = get_the_ID();
            }
            $groups = ['menu' => [], 'daily_menu' => []];
            $meals  = get_post_meta($post_id, INVENTOR_LISTING_PREFIX . 'food_menu_group', true);
            if (is_array($meals)) {
                foreach ($meals as $meal) {
                    if (empty($meal[INVENTOR_LISTING_PREFIX . 'food_menu_serving'])) {
                        $groups['menu'][] = $meal;
                    } else {
                        $groups['daily_menu'][] = $meal;
                    }
                }
            }

            return $groups;
        }
    }

    Inventor_Post_Type_Food::init();

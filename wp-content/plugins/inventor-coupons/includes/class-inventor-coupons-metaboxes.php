<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Coupons_Metaboxes.
     * @class  Inventor_Coupons/Metaboxes
     * @author Pragmatic Mates
     */
    class Inventor_Coupons_Metaboxes
    {
        /**
         * General fields.
         */
        public static function metabox_details()
        {
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_COUPON_PREFIX . 'details',
                'title'        => __('Coupon details', 'inventor-coupons'),
                'object_types' => ['coupon'],
                'context'      => 'normal',
                'priority'     => 'high',
                'show_names'   => true,
                'skip'         => true,
            ]);
            $cmb->add_field([
                'id'          => INVENTOR_COUPON_PREFIX . 'discount',
                'name'        => __('Discount', 'inventor-coupons'),
                'type'        => 'text',
                'description' => __('Insert integer number like: 30. It will be outputted as 30%.', 'inventor-coupons'),
            ]);
            $cmb->add_field([
                'id'      => INVENTOR_COUPON_PREFIX . 'variant',
                'name'    => __('Variant', 'inventor-coupons'),
                'type'    => 'radio',
                'default' => 'image',
                'options' => [
                    'image'          => __('Image', 'inventor-coupons'),
                    'code'           => __('Code', 'inventor-coupons'),
                    'code_generated' => __('Generated code', 'inventor-coupons'),
                ],
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_COUPON_PREFIX . 'image',
                'name' => __('Image', 'inventor-coupons'),
                'type' => 'file',
            ]);
            $cmb->add_field([
                'id'          => INVENTOR_COUPON_PREFIX . 'count',
                'name'        => __('Max. number', 'inventor-coupons'),
                'type'        => 'text',
                'description' => __('Insert integer for max. number of codes which can be generated.',
                    'inventor-coupons'),
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_COUPON_PREFIX . 'code',
                'name' => __('Coupon code', 'inventor-coupons'),
                'type' => 'text',
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_COUPON_PREFIX . 'valid',
                'name' => __('Coupon Valid', 'inventor-coupons'),
                'type' => 'text',
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_COUPON_PREFIX . 'conditions',
                'name' => __('Conditions', 'inventor-coupons'),
                'type' => 'textarea',
            ]);
        }

        /**
         * Codes.
         */
        public static function metabox_codes()
        {
            // codes
            $cmb   = new_cmb2_box([
                'id'           => INVENTOR_COUPON_PREFIX . 'codes',
                'title'        => __('Generated Code', 'inventor-coupons'),
                'object_types' => ['coupon'],
                'context'      => 'normal',
                'priority'     => 'high',
                'skip'         => true,
            ]);
            $group = $cmb->add_field([
                'id'         => INVENTOR_COUPON_PREFIX . 'codes',
                'type'       => 'group',
                'post_type'  => 'coupon',
                'repeatable' => true,
                'options'    => [
                    'group_title'   => __('Generated Codes', 'inventor-coupons'),
                    'add_button'    => __('Add Another Code', 'inventor-coupons'),
                    'remove_button' => __('Remove Code', 'inventor-coupons'),
                ],
            ]);
            $cmb->add_group_field($group, [
                'id'   => INVENTOR_COUPON_PREFIX . 'user_id',
                'name' => __('User ID', 'inventor-coupon'),
                'type' => 'text',
            ]);
            $cmb->add_group_field($group, [
                'id'   => INVENTOR_COUPON_PREFIX . 'code_generated',
                'name' => __('Code', 'inventor-coupon'),
                'type' => 'text',
            ]);
        }
    }

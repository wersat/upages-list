<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Billing.
     *
     * @class  Inventor_Billing
     *
     * @author Pragmatic Mates
     */
    class Inventor_Billing
    {
        /**
         * Initialize billing.
         */
        public static function init()
        {
            add_filter('cmb2_init', [__CLASS__, 'user_fields'], 11);
            add_filter('inventor_billing_fields', [__CLASS__, 'billing_fields']);
        }

        /**
         * Returns all billing fields with their key and title.
         *
         * @param array $billing_fields
         *
         * @return array
         */
        public static function billing_fields($billing_fields)
        {
            $defaults = [
                'billing_name' => __('Name', 'inventor'),
                'billing_registration_number' => __('Reg. No.', 'inventor'),
                'billing_vat_number' => __('VAT No.', 'inventor'),
                'billing_street_and_number' => __('Street and number', 'inventor'),
                'billing_country' => __('Country', 'inventor'),
                'billing_county' => __('State / County', 'inventor'),
                'billing_city' => __('City', 'inventor'),
                'billing_postal_code' => __('Postal code', 'inventor'),
            ];

            return array_merge($defaults, $billing_fields);
        }

        /**
         * Searches for billing details in given context.
         *
         * @param array $context
         *
         * @return array
         */
        public static function get_billing_details_from_context($context)
        {
            $billing_details_keys = array_keys(apply_filters('inventor_billing_fields', []));
            $billing_details = [];
            foreach ($billing_details_keys as $key) {
                $billing_details[$key] = !empty($context[$key]) ? $context[$key] : null;
            }

            return $billing_details;
        }

        /**
         * Defines user billing fields.
         */
        public static function user_fields()
        {
            $cmb = CMB2_Boxes::get(INVENTOR_USER_PREFIX.'profile');
            $billing_fields = apply_filters('inventor_billing_fields', []);
            // Billing details
            $cmb->add_field([
                'id' => INVENTOR_USER_PREFIX.'billing_title',
                'name' => __('Billing details', 'inventor'),
                'type' => 'title',
            ]);
            foreach ($billing_fields as $key => $title) {
                $cmb->add_field([
                    'id' => INVENTOR_USER_PREFIX.$key,
                    'name' => $title,
                    'type' => 'text',
                ]);
            }
        }
    }

    Inventor_Billing::init();

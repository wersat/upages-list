<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Wire_Transfer.
     *
     * @class  Inventor_Wire_Transfer
     *
     * @author Pragmatic Mates
     */
    class Inventor_Wire_Transfer
    {
        /**
         * Initialize wire transfer gateway.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'process_payment'], 9999);
            add_filter('inventor_payment_gateways', [__CLASS__, 'payment_gateways']);
        }

        /**
         * Defines default payment gateways.
         *
         * @return array
         */
        public static function payment_gateways($gateways)
        {
            if (self::is_wire_transfer_active()) {
                $wire_gateway = [
                    'id' => 'wire-transfer',
                    'title' => __('Wire Transfer', 'inventor'),
                    'proceed' => apply_filters('inventor_payment_proceed_gateway', false, 'wire-transfer'),
                    'content' => Inventor_Template_Loader::load('payment/gateways/wire-transfer'),
                ];
                $gateways[] = $wire_gateway;
            }

            return $gateways;
        }

        /**
         * Checks if Wire Transfer is active.
         *
         * @return bool
         */
        public static function is_wire_transfer_active()
        {
            $account_number = get_theme_mod('inventor_wire_transfer_account_number', null);
            $swift = get_theme_mod('inventor_wire_transfer_swift', null);
            $full_name = get_theme_mod('inventor_wire_transfer_full_name', null);
            $country = get_theme_mod('inventor_wire_transfer_country', null);

            return !empty($account_number) && !empty($swift) && !empty($full_name) && !empty($country);
        }

        /**
         * Process payment form.
         */
        public static function process_payment()
        {
            if (!isset($_POST['process-payment'])) {
                return;
            }
            $gateway = empty($_POST['payment_gateway']) ? null : $_POST['payment_gateway'];
            if ($gateway !== 'wire-transfer') {
                return;
            }
            // if required param is missing, payment is not valid
            $required_params = ['payment_gateway', 'payment_type', 'object_id'];
            $success = true;
            foreach ($required_params as $required_param) {
                if (empty($_POST[$required_param])) {
                    $success = false;
                    break;
                }
            }
            if (!$success) {
                $_SESSION['messages'][] = ['danger', __('Missing payment data.', 'inventor')];
            }
            $terms = get_theme_mod('inventor_general_terms_and_conditions_page', false);
            if ($terms && empty($_POST['agree_terms'])) {
                $_SESSION['messages'][] = ['danger', __('You must agree terms &amp; conditions.', 'inventor')];

                return;
            }
            $gateway = $_POST['payment_gateway'];
            $payment_id = null;
            $object_id = $_POST['object_id'];
            $payment_type = $_POST['payment_type'];
            $user_id = get_current_user_id();
            if (!in_array($payment_type, apply_filters('inventor_payment_types', []))) {
                return;
            }
            $payment_data = apply_filters('inventor_prepare_payment', [], $payment_type, $object_id);
            $price = $payment_data['price'];
            $currency_code = Inventor_Price::default_currency_code();
            // billing_details
            $billing_details = Inventor_Billing::get_billing_details_from_context($_POST);
            // hook inventor action
            do_action('inventor_payment_processed', $success, $gateway, $payment_type, $payment_id, $object_id, $price,
                $currency_code, $user_id, $billing_details);
            // after payment page
            $after_payment_page = get_theme_mod('inventor_general_after_payment_page');
            $redirect_url = $after_payment_page ? get_permalink($after_payment_page) : site_url();
            wp_redirect($redirect_url);
            exit();
        }
    }

    Inventor_Wire_Transfer::init();

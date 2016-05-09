<?php
  namespace Upages_Post_Type;

  use Upages_Objects\Custom_Post_Type;
  
  require_once STRIPE_DIR.'libraries/stripe-php-3.4.0/init.php';
  use Stripe\Stripe;

  /**
   * Class Invoice_Post_Type
   *
   * @package Upages_Post_Type
   */
class Stripe_Post_Type
{
    /**
     * @type
     */
    public $post_type;
    /**
     * @type string
     */
    public $post_type_name = 'Stripe';
    /**
     * @type string
     */
    public $post_type_slug;
    /**
     * @type string
     */
    public $post_type_prefix;

    /**
     * @type array
     */
	         
	 
	             /**
             * Initialize Inventor_Stripe plugin.
             */
            public function __construct()
            {
                $this->constants();
                $this->includes();
                $this->load_plugin_textdomain();
            }
			/**
         * Initialize customization type.
         */
        public function init()
        {
            add_action('customize_register', [__CLASS__, 'customizations']);
        }

        /**
         * Customizations.
         *
         * @param object $wp_customize
         */
        public function customizations($wp_customize)
        {
            $wp_customize->add_section('inventor_stripe', [
                'title' => __('Inventor Stripe', 'inventor-stripe'),
                'priority' => 1,
            ]);
            // Stripe Secret Key
            $wp_customize->add_setting('inventor_stripe_secret_key', [
                'default' => null,
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_stripe_secret_key', [
                'label' => __('Secret Key', 'inventor-stripe'),
                'section' => 'inventor_stripe',
                'settings' => 'inventor_stripe_secret_key',
            ]);
            // Stripe Publishable Key
            $wp_customize->add_setting('inventor_stripe_publishable_key', [
                'default' => null,
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control('inventor_stripe_publishable_key', [
                'label' => __('Publishable Key', 'inventor-stripe'),
                'section' => 'inventor_stripe',
                'settings' => 'inventor_stripe_publishable_key',
            ]);
        }
		/**
         * Initialize Stripe functionality.
         */
        public function init()
        {
            add_action('init', [__CLASS__, 'process_payment'], 9999);
            add_filter('inventor_payment_gateways', [__CLASS__, 'payment_gateways']);
        }

        /**
         * Adds payments gateways.
         *
         * @param array $gateways
         *
         * @return array
         */
        public function payment_gateways($gateways)
        {
            if (self::is_active()) {
                $gateways[] = [
                    'id' => 'stripe-checkout',
                    'title' => __('Stripe Checkout', 'inventor-stripe'),
                    'proceed' => false,
                    'content' => Inventor_Template_Loader::load('stripe/checkout', [], INVENTOR_STRIPE_DIR),
                ];
            }

            return $gateways;
        }

        /**
         * Checks if Stripe is active.
         *
         * @return bool
         */
        public function is_active()
        {
            $config = self::get_stripe_config();

            return !empty($config) && is_array($config);
        }

        /**
         * Gets Stripe config.
         *
         * @return array|bool
         */
        public function get_stripe_config()
        {
            $secret_key = get_theme_mod('inventor_stripe_secret_key', null);
            $publishable_key = get_theme_mod('inventor_stripe_publishable_key', null);
            if (empty($secret_key) || empty($publishable_key)) {
                return false;
            }
            $stripe_config = [
                'secret_key' => $secret_key,
                'publishable_key' => $publishable_key,
            ];

            return $stripe_config;
        }

        /**
         * Process payment form.
         */
        public function process_payment()
        {
            $config = self::get_stripe_config();
            if (!isset($_POST['stripeToken'])) {
                return;
            }
            Stripe::setApiKey($config['secret_key']);
            $token = !empty($_POST['stripeToken']) ? $_POST['stripeToken'] : null;
            $token_type = !empty($_POST['stripeTokenType']) ? $_POST['stripeTokenType'] : null;
            $email = !empty($_POST['stripeEmail']) ? $_POST['stripeEmail'] : null;
            $settings = [
                'payment_type' => !empty($_POST['payment_type']) ? $_POST['payment_type'] : '',
                'object_id' => !empty($_POST['object_id']) ? $_POST['object_id'] : '',
                'currency' => !empty($_POST['currency']) ? $_POST['currency'] : '',
                'price' => !empty($_POST['price']) ? $_POST['price'] : '',
            ];
            // billing details
            $settings['billing_details'] = Inventor_Billing::get_billing_details_from_context($_POST);
            try {
                $customer = \Stripe\Customer::create([
                    'email' => $email,
                    'card' => $token,
                ]);
                $charge = \Stripe\Charge::create([
                    'customer' => $customer->id,
                    'amount' => Inventor_Price::get_price_in_cents($settings['price']),
                    'currency' => $settings['currency'],
                ]);
                // process successful result
                self::process_result(true, $settings, $charge->id, $token);
                // redirect to transactions or homepage
                $transactions_page = get_theme_mod('inventor_general_transactions_page', null);
                $redirect_url = empty($transactions_page) ? site_url() : get_permalink($transactions_page);
                echo wp_redirect($redirect_url);
                exit();
            } catch (\Stripe\Error\Card $e) {
                // The card has been declined
                $_SESSION['messages'][] = ['danger', __('The card has been declined.', 'inventor-stripe')];
            } catch (\Stripe\Error\InvalidRequest $e) {
                // The card has been declined or token was used than once
                $_SESSION['messages'][] = ['danger', $e->__toString()];
            }
            // process error result
            self::process_result(false, $settings, null, $token);
        }

        /**
         * Process payment result.
         */
        public function process_result($success, $settings, $payment_id, $token)
        {
            $gateway = 'stripe-checkout';
            $post = get_post($settings['object_id']);
            $user_id = get_current_user_id();
            // validate payment
            $is_valid = true;
            if ($success) {
                $is_valid = !Inventor_Post_Type_Transaction::does_transaction_exist(['stripe-checkout'], $payment_id);
                // if params are present, validate them
                if ($is_valid) {
                    $is_valid = self::is_stripe_payment_valid($payment_id);
                }
                // if payment is invalid, it is not successful transaction
                $success = $is_valid;
            }
            // prepare transaction data
            $data = [
                'success' => $success,
                'price' => $settings['price'],
                'price_formatted' => Inventor_Price::format_price($settings['price']),
                'currency_code' => $settings['currency'],
                'currency_sign' => '',
                'token' => $token,
                'paymentId' => $payment_id,
            ];
            // create transaction
            Inventor_Post_Type_Transaction::create_transaction($gateway, $success, $user_id, $settings['payment_type'],
                $payment_id, $settings['object_id'], $settings['price'], $settings['currency'], $data);
            // hook inventor action
            do_action('inventor_payment_processed', $success, $gateway, $settings['payment_type'], $payment_id,
                $settings['object_id'], $settings['price'], $settings['currency'], $user_id,
                $settings['billing_details']);
            // handle payment
            if ($success) {
                if (!$is_valid) {
                    $_SESSION['messages'][] = ['danger', __('Payment is invalid.', 'inventor-stripe')];
                } elseif (!in_array($settings['payment_type'], apply_filters('inventor_payment_types', []))) {
                    $_SESSION['messages'][] = ['danger', __('Undefined payment type.', 'inventor-stripe')];
                } else {
                    $_SESSION['messages'][] = ['success', __('Payment has been successful.', 'inventor-stripe')];
                }
            } else {
                $_SESSION['messages'][] = ['danger', __('Payment failed, canceled or is invalid.', 'inventor-stripe')];
            }
            wp_redirect(site_url());
            exit();
        }

        /**
         * Checks if Stripe payment is valid.
         *
         * @param string $payment_id
         * @param string $token
         *
         * @return bool
         */
        public function is_stripe_payment_valid($payment_id)
        {
            $config = self::get_stripe_config();
            try {
                Stripe::setApiKey($config['secret_key']);
                $charge = \Stripe\Charge::retrieve($payment_id);
                if ($charge->id != $payment_id) {
                    return false;
                }
            } catch (Exception $ex) {
                return false;
            }

            return true;
        }

        /**
         * Prepares payment data.
         *
         * @param $payment_type
         * @param $object_id
         *
         * @return array|bool
         */
        public function get_data($payment_type, $object_id)
        {
            if (empty($payment_type) || empty($object_id)) {
                return false;
            }
            if (!in_array($payment_type, apply_filters('inventor_payment_types', []))) {
                return false;
            }
            $payment_data = apply_filters('inventor_prepare_payment', [], $payment_type, $object_id);
            $config = self::get_stripe_config();
            $publishable_key = $config['publishable_key'];
            //        $blog_title = get_bloginfo('name');
            //        $title = get_the_title( $object_id );
            return [
                'key' => $publishable_key,
                'name' => $payment_data['action_title'],
                'description' => $payment_data['description'],
                'amount' => Inventor_Price::get_price_in_cents($payment_data['price']),
                'currency' => Inventor_Price::default_currency_code(),
                'locale' => 'auto',
            ];
        }

        /**
         * Returns supported currencies by Stripe listed here:.
         *
         * @param string $payment
         *
         * @see https://support.stripe.com/questions/which-currencies-does-stripe-support
         *
         * @return array
         */
        public function get_supported_currencies($payment)
        {
            $currency_group_1 = [
                'AED',
                'ALL',
                'ANG',
                'ARS',
                'AUD',
                'AWG',
                'BBD',
                'BDT',
                'BIF',
                'BMD',
                'BND',
                'BOB',
                'BRL',
                'BSD',
                'BWP',
                'BZD',
                'CAD',
                'CHF',
                'CLP',
                'CNY',
                'COP',
                'CRC',
                'CVE',
                'CZK',
                'DJF',
                'DKK',
                'DOP',
                'DZD',
                'EGP',
                'ETB',
                'EUR',
                'FJD',
                'FKP',
                'GBP',
                'GIP',
                'GMD',
                'GNF',
                'GTQ',
                'GYD',
                'HKD',
                'HNL',
                'HRK',
                'HTG',
                'HUF',
                'IDR',
                'ILS',
                'INR',
                'ISK',
                'JMD',
                'JPY',
                'KES',
                'KHR',
                'KMF',
                'KRW',
                'KYD',
                'KZT',
                'LAK',
                'LBP',
                'LKR',
                'LRD',
                'MAD',
                'MDL',
                'MNT',
                'MOP',
                'MRO',
                'MUR',
                'MVR',
                'MWK',
                'MXN',
                'MYR',
                'NAD',
                'NGN',
                'NIO',
                'NOK',
                'NPR',
                'NZD',
                'PAB',
                'PEN',
                'PGK',
                'PHP',
                'PKR',
                'PLN',
                'PYG',
                'QAR',
                'RUB',
                'SAR',
                'SBD',
                'SCR',
                'SEK',
                'SGD',
                'SHP',
                'SLL',
                'SOS',
                'STD',
                'SVC',
                'SZL',
                'THB',
                'TOP',
                'TTD',
                'TWD',
                'TZS',
                'UAH',
                'UGX',
                'USD',
                'UYU',
                'UZS',
                'VND',
                'VUV',
                'WST',
                'XAF',
                'XOF',
                'XPF',
                'YER',
                'ZAR',
            ];
            $currency_group_2 = [
                'AFN',
                'AMD',
                'AOA',
                'AZN',
                'BAM',
                'BGN',
                'GEL',
                'CDF',
                'KGS',
                'LSL',
                'MGA',
                'MKD',
                'MZN',
                'RON',
                'RSD',
                'SRD',
                'TJS',
                'TRY',
                'XCD',
                'ZMW',
            ];

            return array_merge($currency_group_1, $currency_group_2);
        }

 }

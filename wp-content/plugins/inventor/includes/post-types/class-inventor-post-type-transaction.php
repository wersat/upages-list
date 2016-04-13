<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Post_Type_Transaction.
     * @class  Inventor_Post_Type_Transaction
     * @author Pragmatic Mates
     */
    class Inventor_Post_Type_Transaction
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            add_filter('cmb2_init', [__CLASS__, 'fields']);
            add_filter('manage_edit-transaction_columns', [__CLASS__, 'custom_columns']);
            add_action('manage_transaction_posts_custom_column', [__CLASS__, 'custom_columns_manage']);
        }

        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name'               => __('Transactions', 'inventor'),
                'singular_name'      => __('Transaction', 'inventor'),
                'add_new'            => __('Add New Transaction', 'inventor'),
                'add_new_item'       => __('Add New Transaction', 'inventor'),
                'edit_item'          => __('Edit Transaction', 'inventor'),
                'new_item'           => __('New Transaction', 'inventor'),
                'all_items'          => __('Transactions', 'inventor'),
                'view_item'          => __('View Transaction', 'inventor'),
                'search_items'       => __('Search Transaction', 'inventor'),
                'not_found'          => __('No Transactions found', 'inventor'),
                'not_found_in_trash' => __('No Transactions Found in Trash', 'inventor'),
                'parent_item_colon'  => '',
                'menu_name'          => __('Transactions', 'inventor'),
            ];
            register_post_type('transaction', [
                'labels'       => $labels,
                'show_in_menu' => 'inventor',
                'supports'     => [null],
                'public'       => false,
                'has_archive'  => false,
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
            $cmb = new_cmb2_box([
                'id'           => INVENTOR_TRANSACTION_PREFIX . 'general',
                'title'        => __('General', 'inventor'),
                'object_types' => ['transaction'],
                'context'      => 'normal',
                'priority'     => 'high',
                'show_names'   => true,
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_TRANSACTION_PREFIX . 'payment_type',
                'name' => __('Payment type', 'inventor'),
                'type' => 'text',
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_TRANSACTION_PREFIX . 'gateway',
                'name' => __('Gateway', 'inventor'),
                'type' => 'text',
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_TRANSACTION_PREFIX . 'object_id',
                'name' => __('Object ID', 'inventor'),
                'type' => 'text',
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_TRANSACTION_PREFIX . 'payment_id',
                'name' => __('Payment ID', 'inventor'),
                'type' => 'text',
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_TRANSACTION_PREFIX . 'price',
                'name' => __('Price', 'inventor'),
                'type' => 'text_small',
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_TRANSACTION_PREFIX . 'currency',
                'name' => __('Currency', 'inventor'),
                'type' => 'text_small',
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_TRANSACTION_PREFIX . 'success',
                'name' => __('Success', 'inventor'),
                'type' => 'checkbox',
            ]);
            $cmb->add_field([
                'id'   => INVENTOR_TRANSACTION_PREFIX . 'data',
                'name' => __('Data', 'inventor'),
                'type' => 'textarea',
            ]);
        }

        /**
         * Custom admin columns.
         * @return array
         */
        public static function custom_columns()
        {
            $fields = [
                'cb'           => '<input type="checkbox" />',
                'payment_id'   => __('Payment ID', 'inventor'),
                'payment_type' => __('Payment type', 'inventor'),
                'gateway'      => __('Gateway', 'inventor'),
                'price'        => __('Price', 'inventor'),
                'object'       => __('Object', 'inventor'),
                'success'      => __('Success', 'inventor'),
                'author'       => __('Author', 'inventor'),
                'date'         => __('Date', 'inventor'),
            ];

            return $fields;
        }

        /**
         * Custom admin columns implementation.
         *
         * @param string $column
         *
         * @return array
         */
        public static function custom_columns_manage($column)
        {
            switch ($column) {
                case 'payment_id':
                    $payment_id = get_post_meta(get_the_ID(), INVENTOR_TRANSACTION_PREFIX . 'payment_id', true);
                    echo $payment_id;
                    break;
                case 'price':
                    $data            = get_post_meta(get_the_ID(), INVENTOR_TRANSACTION_PREFIX . 'data', true);
                    $data            = unserialize($data);
                    $price_formatted = empty($data['price_formatted']) ? '' : $data['price_formatted'];
                    if ( ! empty($price_formatted)) {
                        echo $price_formatted;
                        break;
                    }
                    $price    = get_post_meta(get_the_ID(), INVENTOR_TRANSACTION_PREFIX . 'price', true);
                    $currency = get_post_meta(get_the_ID(), INVENTOR_TRANSACTION_PREFIX . 'currency', true);
                    if (empty($price)) {
                        echo '-';
                        break;
                    }
                    if ( ! empty($currency)) {
                        echo wp_kses($price . ' ' . $currency, wp_kses_allowed_html('post'));
                    } else {
                        echo '-';
                    }
                    break;
                case 'gateway':
                    $gateway = get_post_meta(get_the_ID(), INVENTOR_TRANSACTION_PREFIX . 'gateway', true);
                    echo $gateway;
                    break;
                case 'payment_type':
                    $payment_type = get_post_meta(get_the_ID(), INVENTOR_TRANSACTION_PREFIX . 'payment_type', true);
                    echo $payment_type;
                    break;
                case 'object':
                    $object_id = get_post_meta(get_the_ID(), INVENTOR_TRANSACTION_PREFIX . 'object_id', true);
                    echo get_the_title(get_post($object_id));
                    break;
                case 'success':
                    $is_successful = self::is_successful(get_the_ID());
                    if ($is_successful) {
                        echo '<div class="dashicons-before dashicons-yes green"></div>';
                    } else {
                        echo '<div class="dashicons-before dashicons-no red"></div>';
                    }
                    break;
            }
        }

        /**
         * Checks if transaction was successful.
         * @return bool
         */
        public static function is_successful($transaction_id)
        {
            // field
            $success = get_post_meta($transaction_id, INVENTOR_TRANSACTION_PREFIX . 'success', true);
            if ( ! empty($success)) {
                return $success;
            }
            // object
            $data = get_post_meta($transaction_id, INVENTOR_TRANSACTION_PREFIX . 'data', true);
            if (empty($data)) {
                return false;
            }
            $data = unserialize($data);

            return empty($data['success']) ? false : $data['success'];
        }

        /**
         * Create transaction.
         *
         * @param string $gateway
         * @param bool   $success
         * @param int    $user_id
         * @param string $payment_type
         * @param int    $object_id
         * @param float  $price
         * @param string $currency_code
         * @param array  $params
         *
         * @return int $transaction_id
         */
        public static function create_transaction(
            $gateway,
            $success,
            $user_id,
            $payment_type,
            $payment_id,
            $object_id,
            $price,
            $currency_code,
            $params = []
        ) {
            $transaction_id = wp_insert_post([
                'post_type'   => 'transaction',
                'post_title'  => date(get_option('date_format'), strtotime('today')),
                'post_status' => 'publish',
                'post_author' => $user_id,
            ]);
            $data           = [
                'success' => $success,
            ];
            foreach ($params as $key => $value) {
                $data[$key] = $value;
            }
            update_post_meta($transaction_id, INVENTOR_TRANSACTION_PREFIX . 'success', $success);
            update_post_meta($transaction_id, INVENTOR_TRANSACTION_PREFIX . 'price', $price);
            update_post_meta($transaction_id, INVENTOR_TRANSACTION_PREFIX . 'currency', $currency_code);
            update_post_meta($transaction_id, INVENTOR_TRANSACTION_PREFIX . 'data', serialize($data));
            update_post_meta($transaction_id, INVENTOR_TRANSACTION_PREFIX . 'object_id', $object_id);
            update_post_meta($transaction_id, INVENTOR_TRANSACTION_PREFIX . 'payment_type', $payment_type);
            update_post_meta($transaction_id, INVENTOR_TRANSACTION_PREFIX . 'payment_id', $payment_id);
            update_post_meta($transaction_id, INVENTOR_TRANSACTION_PREFIX . 'gateway', $gateway);

            return $transaction_id;
        }

        /**
         * Checks if transaction with such payment ID and gateway exists.
         *
         * @param array  $gateways
         * @param string $payment_id
         *
         * @return bool
         */
        public static function does_transaction_exist($gateways, $payment_id)
        {
            $query = new WP_Query([
                'post_type'      => 'transaction',
                'posts_per_page' => -1,
                'post_status'    => 'any',
                'meta_query'     => [
                    [
                        'key'     => INVENTOR_TRANSACTION_PREFIX . 'gateway',
                        'value'   => $gateways,
                        'compare' => 'IN',
                    ],
                    [
                        'key'   => INVENTOR_TRANSACTION_PREFIX . 'payment_id',
                        'value' => $payment_id,
                    ],
                ],
            ]);

            return count($query->posts) > 0;
        }
    }

    Inventor_Post_Type_Transaction::init();

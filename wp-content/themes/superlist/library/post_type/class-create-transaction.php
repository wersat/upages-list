<?php
    /**
     * Created by PhpStorm.
     * User: jazzman
     * Date: 23.04.16
     * Time: 11:47
     */
    namespace Upages_Post_Type;
    
class Create_Transaction
{
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
        $transaction_id = wp_insert_post(
            [
            'post_type'   => 'transaction',
            'post_title'  => date(get_option('date_format'), strtotime('today')),
            'post_status' => 'publish',
            'post_author' => $user_id,
            ]
        );
        $data           = [
            'success' => $success,
        ];
        foreach ($params as $key => $value) {
            $data[$key] = $value;
        }
        update_post_meta($transaction_id, 'transaction_success', $success);
        update_post_meta($transaction_id, 'transaction_price', $price);
        update_post_meta($transaction_id, 'transaction_currency', $currency_code);
        update_post_meta($transaction_id, 'transaction_data', serialize($data));
        update_post_meta($transaction_id, 'transaction_object_id', $object_id);
        update_post_meta($transaction_id, 'transaction_payment_type', $payment_type);
        update_post_meta($transaction_id, 'transaction_payment_id', $payment_id);
        update_post_meta($transaction_id, 'transaction_gateway', $gateway);

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
        $query = new \WP_Query(
            [
            'post_type'      => 'transaction',
            'posts_per_page' => -1,
            'post_status'    => 'any',
            'meta_query'     => [
                [
                    'key'     => 'transaction_gateway',
                    'value'   => $gateways,
                    'compare' => 'IN',
                ],
                [
                    'key'   => 'transaction_payment_id',
                    'value' => $payment_id,
                ],
            ],
            ]
        );

        return count($query->posts) > 0;
    }
}

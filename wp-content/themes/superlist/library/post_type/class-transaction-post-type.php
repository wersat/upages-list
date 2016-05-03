<?php
    /**
     * Created by PhpStorm.
     * User: jazzman
     * Date: 23.04.16
     * Time: 9:41
     */
    namespace Upages_Post_Type;
    
    use Upages_Objects\Custom_Post_Type;

    /**
     * Class Transaction_Post_Type
     *
     * @package Upages_Post_Type
     */
class Transaction_Post_Type
{
    /**
         * @type
         */
    public $post_type;
    /**
         * @type string
         */
    public $post_type_name = 'Transaction New';
    /**
         * @type string
         */
    public $post_type_prefix;
    /**
         * @type string
         */
    public $post_type_slug;
    public $post_type_option
    = [
        'show_in_menu' => 'inventor',
        'supports'     => [null],
        'public'       => false,
        'has_archive'  => false,
        'show_ui'      => true,
        'categories'   => []
    ];

    /**
         * Transaction_Post_Type constructor.
         */
    public function __construct()
    {
        $this->post_type_slug   = sanitize_title($this->post_type_name);
        $this->post_type_prefix = sanitize_title($this->post_type_name) . '_';
        $this->setPostType();
        add_filter('cmb2_init', [$this, 'fields']);
    }

    public function setPostType()
    {
        $this->post_type = new Custom_Post_Type(
            [
            'post_type_name' => $this->post_type_slug,
            'singular'       => $this->post_type_name,
            'plural'         => $this->post_type_name,
            'slug'           => $this->post_type_slug
            ], $this->post_type_option
        );
        $this->post_type->columns(
            [
            'cb'           => '<input type="checkbox" />',
            'payment_id'   => __('Payment ID', 'inventor'),
            'payment_type' => __('Payment type', 'inventor'),
            'gateway'      => __('Gateway', 'inventor'),
            'price'        => __('Price', 'inventor'),
            'object'       => __('Object', 'inventor'),
            'success'      => __('Success', 'inventor'),
            'author'       => __('Author', 'inventor'),
            'date'         => __('Date', 'inventor')
            ]
        );
        $this->post_type->sortable(
            [
            'payment_id'   => ['payment_id', true],
            'payment_type' => ['payment_type', true],
            'gateway'      => ['gateway', true],
            'price'        => ['price', true],
            'object'       => ['object', true],
            'success'      => ['success', true],
            'author'       => ['author', true],
            'date'         => ['date', true]
            ]
        );
        $this->post_type->populate_column(
            'payment_id', function ($column, $post) {
                echo get_post_meta(get_the_ID(), $this->post_type_prefix . 'payment_id', true);
            }
        );
            $this->post_type->populate_column(
                'payment_type', function ($column, $post) {
                    echo get_post_meta(get_the_ID(), $this->post_type_prefix . 'payment_type', true);
                }
            );
            $this->post_type->populate_column(
                'gateway', function ($column, $post) {
                    echo get_post_meta(get_the_ID(), $this->post_type_prefix . 'gateway', true);
                }
            );
            $this->post_type->populate_column(
                'price', function ($column, $post) {
                    $data            = get_post_meta(get_the_ID(), $this->post_type_prefix . 'data', true);
                    $price_formatted = empty($data['price_formatted']) ? '' : $data['price_formatted'];
                    if (! empty($price_formatted)) {
                        echo $price_formatted;
                    }
                    $price    = get_post_meta(get_the_ID(), $this->post_type_prefix . 'price', true);
                    $currency = get_post_meta(get_the_ID(), $this->post_type_prefix . 'currency', true);
                    if (empty($price)) {
                        echo '-';
                    }
                    if (! empty($currency)) {
                        echo wp_kses($price . ' ' . $currency, wp_kses_allowed_html('post'));
                    } else {
                        echo '-';
                    }
                }
            );
            $this->post_type->populate_column(
                'object', function ($column, $post) {
                    $object_id = get_post_meta(get_the_ID(), $this->post_type_prefix . 'object_id', true);
                    echo get_the_title(get_post($object_id));
                }
            );
            $this->post_type->populate_column(
                'success', function ($column, $post) {
                    $is_successful = $this->is_successful(get_the_ID());
                    if ($is_successful) {
                        echo '<div class="dashicons-before dashicons-yes green"></div>';
                    } else {
                        echo '<div class="dashicons-before dashicons-no red"></div>';
                    }
                }
            );
    }

    /**
         * @param $transaction_id
         *
         * @return bool|mixed
         */
    public function is_successful($transaction_id)
    {
        $success = get_post_meta($transaction_id, $this->post_type_prefix . 'success', true);
        if (! empty($success)) {
            return $success;
        }
        $data = get_post_meta($transaction_id, $this->post_type_prefix . 'data', true);
        if (empty($data)) {
            return false;
        }
        $data = unserialize($data);

        return empty($data['success']) ? false : $data['success'];
    }

    public function fields()
    {
        $cmb = new_cmb2_box(
            [
            'id'           => $this->post_type_prefix . 'general',
            'title'        => __('General', 'inventor'),
            'object_types' => [$this->post_type_slug],
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true
            ]
        );
        $cmb->add_field(
            [
            'id'   => $this->post_type_prefix . 'payment_type',
            'name' => __('Payment type', 'inventor'),
            'type' => 'text'
            ]
        );
        $cmb->add_field(
            [
            'id'   => $this->post_type_prefix . 'gateway',
            'name' => __('Gateway', 'inventor'),
            'type' => 'text'
            ]
        );
        $cmb->add_field(
            [
            'id'   => $this->post_type_prefix . 'object_id',
            'name' => __('Object ID', 'inventor'),
            'type' => 'text'
            ]
        );
        $cmb->add_field(
            [
            'id'   => $this->post_type_prefix . 'payment_id',
            'name' => __('Payment ID', 'inventor'),
            'type' => 'text'
            ]
        );
        $cmb->add_field(
            [
            'id'   => $this->post_type_prefix . 'price',
            'name' => __('Price', 'inventor'),
            'type' => 'text_small'
            ]
        );
        $cmb->add_field(
            [
            'id'   => $this->post_type_prefix . 'currency',
            'name' => __('Currency', 'inventor'),
            'type' => 'text_small'
            ]
        );
        $cmb->add_field(
            [
            'id'   => $this->post_type_prefix . 'success',
            'name' => __('Success', 'inventor'),
            'type' => 'checkbox'
            ]
        );
        $cmb->add_field(
            [
            'id'   => $this->post_type_prefix . 'data',
            'name' => __('Data', 'inventor'),
            'type' => 'textarea'
            ]
        );
    }
}

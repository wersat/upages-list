<?php
  namespace Upages_Post_Type;

  use Upages_Objects\Custom_Post_Type;

  /**
   * Class Invoice_Post_Type
   * @package Upages_Post_Type
   */
  class Invoice_Post_Type
  {
    /**
     * @type
     */
    public $post_type;
    /**
     * @type string
     */
    public $post_type_name = 'Invoice';
    /**
     * @type string
     */
    public $post_type_slug;
    /**
     * @type string
     */
    public $invoice_prefix = 'invoice_';

    /**
     * @type array
     */
    public $post_type_option
      = [
        'supports'            => ['title', 'author'],
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'show_in_nav_menus'   => false,
        'show_ui'             => true,
        'show_in_menu'        => 'inventor'
      ];

    /**
     * Invoice_Post_Type constructor.
     */
    public function __construct()
    {
      $this->post_type_slug = sanitize_title($this->post_type_name);
      $this->setPostType();
      add_action('customize_register', [$this, 'customizations']);
      add_filter('cmb2_init', [$this, 'fields']);
      add_action('manage_invoice_posts_custom_column', [$this, 'custom_columns_manage']);
      add_action('pre_get_posts', [$this, 'restrict_user_on_archive']);
      add_action('wp', [$this, 'restrict_user_on_detail']);
      add_action('inventor_payment_processed', [$this, 'catch_payment'], 10, 9);
      add_filter('inventor_invoices_types', [$this, 'default_types'], 10, 1);
      add_filter('inventor_payment_proceed_gateway', [$this, 'proceed_payment_gateway'], 10, 2);
      add_filter('single_template', [$this, 'invoice_template']);
      add_shortcode('inventor_invoices', [$this, 'invoices']);
    }

    /**
     *
     */
    public function setPostType()
    {
      $this->post_type = new Custom_Post_Type([
        'post_type_name' => $this->post_type_slug,
        'singular'       => $this->post_type_name,
        'plural'         => $this->post_type_name,
        'slug'           => $this->post_type_slug
      ], $this->post_type_option);
      $this->post_type->columns([
        'cb'         => '<input type="checkbox" />',
        'title'      => __('Number', 'inventor'),
        'type'       => __('Type', 'inventor'),
        'customer'   => __('Customer', 'inventor'),
        'total'      => __('Total', 'inventor'),
        'currency'   => __('Currency', 'inventor'),
        'issue_date' => __('Issue date', 'inventor')
      ]);
      $this->post_type->sortable([
        'title'      => ['title', true],
        'type'       => ['type', true],
        'customer'   => ['customer', true],
        'total'      => ['total', true],
        'currency'   => ['currency', true],
        'issue_date' => ['issue_date', true]
      ]);

    }

    /**
     *
     */
    public function fields()
    {
      $general = new_cmb2_box([
        'id'           => $this->invoice_prefix . 'general',
        'title'        => __('General information', 'inventor-invoices'),
        'object_types' => [$this->post_type_slug],
        'context'      => 'normal',
        'priority'     => 'high'
      ]);
      $general->add_field([
        'name'    => __('Type', 'inventor-invoices'),
        'id'      => $this->invoice_prefix . 'type',
        'type'    => 'radio',
        'options' => apply_filters('inventor_invoices_types', [])
      ]);
      $payment = new_cmb2_box([
        'id'           => $this->invoice_prefix . 'payment',
        'title'        => __('Payment information', 'inventor-invoices'),
        'object_types' => [$this->post_type_slug],
        'context'      => 'normal',
        'priority'     => 'high'
      ]);
      $payment->add_field([
        'name' => __('Currency code', 'inventor-invoices'),
        'id'   => $this->invoice_prefix . 'currency_code',
        'type' => 'text_small'
      ]);
      $payment->add_field([
        'name' => __('Reference', 'inventor-invoices'),
        'id'   => $this->invoice_prefix . 'reference',
        'type' => 'text'
      ]);
      $payment->add_field([
        'name'        => __('Payment term', 'inventor-invoices'),
        'id'          => $this->invoice_prefix . 'payment_term',
        'type'        => 'text_small',
        'description' => __('days', 'inventor-invoices'),
        'attributes'  => [
          'type'    => 'number',
          'pattern' => '\d*'
        ]
      ]);
      $payment->add_field([
        'name' => __('Details / Instructions', 'inventor-invoices'),
        'id'   => $this->invoice_prefix . 'details',
        'type' => 'textarea'
      ]);
      $supplier = new_cmb2_box([
        'id'           => $this->invoice_prefix . 'supplier',
        'title'        => __('Supplier', 'inventor-invoices'),
        'object_types' => [$this->post_type_slug],
        'context'      => 'normal',
        'priority'     => 'high'
      ]);
      $supplier->add_field([
        'name' => __('Name', 'inventor-invoices'),
        'id'   => $this->invoice_prefix . 'supplier_name',
        'type' => 'text'
      ]);
      $supplier->add_field([
        'name' => __('Registration No.', 'inventor-invoices'),
        'id'   => $this->invoice_prefix . 'supplier_registration_number',
        'type' => 'text_medium'
      ]);
      $supplier->add_field([
        'name' => __('VAT No.', 'inventor-invoices'),
        'id'   => $this->invoice_prefix . 'supplier_vat_number',
        'type' => 'text_medium'
      ]);
      $supplier->add_field([
        'name'        => __('Details', 'inventor-invoices'),
        'description' => __('for example address or any additional information', 'inventor-invoices'),
        'id'          => $this->invoice_prefix . 'supplier_details',
        'type'        => 'textarea'
      ]);
      $supplier = new_cmb2_box([
        'id'           => $this->invoice_prefix . 'customer',
        'title'        => __('Customer', 'inventor-invoices'),
        'object_types' => [$this->post_type_slug],
        'context'      => 'normal',
        'priority'     => 'high'
      ]);
      $supplier->add_field([
        'name' => __('Name', 'inventor-invoices'),
        'id'   => $this->invoice_prefix . 'customer_name',
        'type' => 'text'
      ]);
      $supplier->add_field([
        'name' => __('Registration No.', 'inventor-invoices'),
        'id'   => $this->invoice_prefix . 'customer_registration_number',
        'type' => 'text_medium'
      ]);
      $supplier->add_field([
        'name' => __('VAT No.', 'inventor-invoices'),
        'id'   => $this->invoice_prefix . 'customer_vat_number',
        'type' => 'text_medium'
      ]);
      $supplier->add_field([
        'name'        => __('Details', 'inventor-invoices'),
        'description' => __('for example address or any additional information', 'inventor-invoices'),
        'id'          => $this->invoice_prefix . 'customer_details',
        'type'        => 'textarea'
      ]);
      $cmb   = new_cmb2_box([
        'id'           => $this->invoice_prefix . 'items',
        'title'        => __('Items', 'inventor-invoices'),
        'object_types' => [$this->post_type_slug],
        'context'      => 'normal',
        'priority'     => 'high'
      ]);
      $group = $cmb->add_field([
        'id'         => $this->invoice_prefix . 'item',
        'type'       => 'group',
        'post_type'  => $this->post_type_slug,
        'repeatable' => true,
        'options'    => [
          'group_title'   => __('Item', 'inventor-invoices'),
          'add_button'    => __('Add Another Item', 'inventor-invoices'),
          'remove_button' => __('Remove Item', 'inventor-invoices')
        ]
      ]);
      $cmb->add_group_field($group, [
        'id'   => $this->invoice_prefix . 'item_title',
        'name' => __('Title', 'inventor'),
        'type' => 'text'
      ]);
      $cmb->add_group_field($group, [
        'id'         => $this->invoice_prefix . 'item_quantity',
        'name'       => __('Quantity', 'inventor-invoices'),
        'type'       => 'text_small',
        'attributes' => [
          'pattern' => '\\d*\\.?\\d+'
        ]
      ]);
      $cmb->add_group_field($group, [
        'id'         => $this->invoice_prefix . 'item_unit_price',
        'name'       => __('Unit price', 'inventor-invoices'),
        'type'       => 'text_small',
        'attributes' => [
          'pattern' => '\\d*\\.?\\d+'
        ]
      ]);
      $cmb->add_group_field($group, [
        'id'          => $this->invoice_prefix . 'item_tax_rate',
        'name'        => __('Tax rate', 'inventor-invoices'),
        'description' => '%',
        'type'        => 'text_small',
        'attributes'  => [
          'pattern' => '\\d*\\.?\\d+'
        ]
      ]);

    }

    /**
     * @param $wp_customize
     */
    public function customizations($wp_customize)
    {
      $wp_customize->add_section('inventor_invoices', [
        'title'    => __('Inventor Invoices', 'inventor-invoices'),
        'priority' => 1
      ]);
      $pages = $this->get_pages();
      $wp_customize->add_setting('inventor_invoices_page', [
        'default'           => null,
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
      ]);
      $wp_customize->add_control('inventor_invoices_page', [
        'type'     => 'select',
        'label'    => __('Invoices', 'inventor-invoices'),
        'section'  => 'inventor_pages',
        'settings' => 'inventor_invoices_page',
        'choices'  => $pages
      ]);
      $wp_customize->add_setting('inventor_invoices_payment_term', [
        'default'           => 15,
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
      ]);
      $wp_customize->add_control('inventor_invoices_payment_term', [
        'label'       => __('Payment term', 'inventor-invoices'),
        'section'     => 'inventor_invoices',
        'settings'    => 'inventor_invoices_payment_term',
        'description' => __('In days', 'inventor-invoices')
      ]);
      $wp_customize->add_setting('inventor_invoices_tax_rate', [
        'default'           => 0,
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
      ]);
      $wp_customize->add_control('inventor_invoices_tax_rate', [
        'label'       => __('Tax rate', 'inventor-invoices'),
        'section'     => 'inventor_invoices',
        'settings'    => 'inventor_invoices_tax_rate',
        'description' => __('In %', 'inventor-invoices')
      ]);
      $wp_customize->add_setting('inventor_invoices_billing_name', [
        'default'           => null,
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
      ]);
      $wp_customize->add_control('inventor_invoices_billing_name', [
        'label'    => __('Billing name', 'inventor-invoices'),
        'section'  => 'inventor_invoices',
        'settings' => 'inventor_invoices_billing_name'
      ]);
      $wp_customize->add_setting('inventor_invoices_billing_registration_number', [
        'default'           => null,
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
      ]);
      $wp_customize->add_control('inventor_invoices_billing_registration_number', [
        'label'    => __('Reg. No.', 'inventor-invoices'),
        'section'  => 'inventor_invoices',
        'settings' => 'inventor_invoices_billing_registration_number'
      ]);
      $wp_customize->add_setting('inventor_invoices_billing_vat_number', [
        'default'           => null,
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
      ]);
      $wp_customize->add_control('inventor_invoices_billing_vat_number', [
        'label'    => __('VAT No.', 'inventor-invoices'),
        'section'  => 'inventor_invoices',
        'settings' => 'inventor_invoices_billing_vat_number'
      ]);
      $wp_customize->add_setting('inventor_invoices_billing_details', [
        'default'           => null,
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => ['Inventor_Utilities', 'sanitize_textarea']
      ]);
      $wp_customize->add_control('inventor_invoices_billing_details', [
        'label'    => __('Billing details', 'inventor-invoices'),
        'section'  => 'inventor_invoices',
        'settings' => 'inventor_invoices_billing_details',
        'type'     => 'textarea'
      ]);
    }

    /**
     * @return array
     */
    public function get_pages()
    {
      $pages   = [];
      $pages[] = __('Not set', 'inventor');
      foreach ((array)get_pages() as $page) {
        $pages[$page->ID] = $page->post_title;
      }

      return $pages;
    }

    /**
     * @param $column
     */
    public function custom_columns_manage($column)
    {
      switch ($column) {
        case 'type':
          $type  = get_post_meta(get_the_ID(), $this->invoice_prefix . 'type', true);
          $types = apply_filters('inventor_invoices_types', []);
          echo empty($types[$type]) ? $type : $types[$type];
          break;
        case 'customer':
          $customer_name = get_post_meta(get_the_ID(), $this->invoice_prefix . 'customer_name', true);
          echo $customer_name;
          break;
        case 'total':
          $total = $this->get_invoice_total(get_the_ID());
          echo $total;
          break;
        case 'currency':
          $currency_code = get_post_meta(get_the_ID(), $this->invoice_prefix . 'currency_code', true);
          echo $currency_code;
          break;
        case 'issue_date':
          echo get_the_date('Y-m-d');
          break;
      }
    }

    /**
     * @param $invoice_id
     *
     * @return float|int
     */
    public function get_invoice_total($invoice_id)
    {
      $items = get_post_meta($invoice_id, $this->invoice_prefix . 'item', true);
      $total = 0;
      if ( ! is_array($items)) {
        return $total;
      }
      foreach ((array)$items as $item) {
        $item_price = $this->get_invoice_item_subtotal($item);
        $total += $item_price;
      }

      return round($total, 2);
    }

    /**
     * @param $item
     *
     * @return float
     */
    public function get_invoice_item_subtotal($item)
    {
      $unit_price_key = $this->invoice_prefix . 'item_unit_price';
      $unit_price     = ( ! empty($item[$unit_price_key])) ? (float)$item[$unit_price_key] : 0;
      $quantity_key   = $this->invoice_prefix . 'item_quantity';
      $quantity       = ( ! empty($item[$quantity_key])) ? (float)$item[$quantity_key] : 0;
      $tax_rate_key   = $this->invoice_prefix . 'item_tax_rate';
      $tax_rate       = ( ! empty($item[$tax_rate_key])) ? (float)$item[$tax_rate_key] : 0;
      $rate           = (float)(100 + $tax_rate) / 100;
      $subtotal       = $unit_price * $quantity * $rate;

      return round($subtotal, 2);
    }

    /**
     * @param $query
     */
    public function restrict_user_on_archive($query)
    {
      if ((get_query_var('post_type') == 'invoice' || is_post_type_archive('invoice')) && $query->is_main_query() && ! is_admin()) {
        $query->set('author', get_current_user_id());
      }
    }

    public function restrict_user_on_detail()
    {
      if (is_singular('invoice') && ! is_admin()) {
        $invoice          = get_post();
        $invoice_customer = $invoice->post_author;
        $current_user     = get_current_user_id();
        if ($current_user != $invoice_customer) {
          $_SESSION['messages'][] = ['danger', __('It is not your invoice.', 'inventor-invoices')];
          echo wp_redirect(site_url());
          exit();
        }
      }
    }

    /**
     * @param $success
     * @param $gateway
     * @param $payment_type
     * @param $payment_id
     * @param $object_id
     * @param $price
     * @param $currency_code
     * @param $user_id
     * @param $billing_details
     */
    public function catch_payment(
      $success,
      $gateway,
      $payment_type,
      $payment_id,
      $object_id,
      $price,
      $currency_code,
      $user_id,
      $billing_details
    ) {
      if ( ! $success) {
        return;
      }
      $invoice_number               = $this->get_next_invoice_number();
      $invoice_id                   = wp_insert_post([
        'post_type'   => 'invoice',
        'post_title'  => $invoice_number,
        'post_status' => 'publish',
        'post_author' => $user_id
      ]);
      $type                         = 'INVOICE';
      $reference                    = empty($payment_id) ? $invoice_number : $payment_id;
      $payment_term                 = get_theme_mod('inventor_invoices_payment_term', 15);
      $supplier_name                = get_theme_mod('inventor_invoices_billing_name', '');
      $supplier_registration_number = get_theme_mod('inventor_invoices_billing_registration_number', '');
      $supplier_vat_number          = get_theme_mod('inventor_invoices_billing_vat_number', '');
      $supplier_details             = get_theme_mod('inventor_invoices_billing_details', '');
      $customer_name                = ! empty($billing_details['billing_name']) ? $billing_details['billing_name']
        : null;
      $customer_registration_number = ! empty($billing_details['billing_registration_number'])
        ? $billing_details['billing_registration_number'] : null;
      $customer_vat_number          = ! empty($billing_details['billing_vat_number'])
        ? $billing_details['billing_vat_number'] : null;
      $customer_address             = [];
      foreach (
        [
          'billing_street_and_number',
          'billing_city',
          'billing_postal_code',
          'billing_county',
          'billing_country'
        ] as $address_key
      ) {
        $value = ! empty($billing_details[$address_key]) ? $billing_details[$address_key] : null;
        if ( ! empty($value)) {
          $customer_address[] = $value;
        }
      }
      $customer_details = implode("\r\n", $customer_address);
      // item
      $tax_rate = get_theme_mod('inventor_invoices_tax_rate', 0);
      // tax rate filter
      $tax_rate        = apply_filters('inventor_invoices_tax_rate', $tax_rate, $supplier_vat_number,
        $customer_vat_number);
      $item_tax_rate   = (float)$tax_rate;
      $rate            = (float)(100 + $item_tax_rate) / 100;
      $item_unit_price = round($price / $rate, 2);
      $item            = [
        $this->invoice_prefix . 'item_title'      => get_the_title($object_id),
        $this->invoice_prefix . 'item_quantity'   => 1,
        $this->invoice_prefix . 'item_unit_price' => (string)$item_unit_price,
        $this->invoice_prefix . 'item_tax_rate'   => (string)$item_tax_rate
      ];
      $items           = [$item];
      // details
      $details = '';
      // Wire transfer gateway handle
      if ($gateway == 'wire-transfer') {
        $type         = 'ADVANCE';
        $bank_details = [];
        foreach (
          [
            'account_number',
            'swift',
            'full_name',
            'street',
            'postcode',
            'city',
            'country'
          ] as $details_key
        ) {
          $customize_key = 'inventor_wire_transfer_' . $details_key;
          $value         = get_theme_mod($customize_key, '');
          $label         = $this->get_control_label($customize_key);
          if ( ! empty($value)) {
            $bank_details[] = $label . ': ' . $value;
          }
        }
        if (count($bank_details) > 0) {
          array_unshift($bank_details, __('Bank details', 'inventor-invoices') . ':');
        }
        $details = implode("\r\n", $bank_details);
      }
      # update invoice
      update_post_meta($invoice_id, $this->invoice_prefix . 'type', $type);
      update_post_meta($invoice_id, $this->invoice_prefix . 'currency_code', $currency_code);
      update_post_meta($invoice_id, $this->invoice_prefix . 'reference', $reference);
      update_post_meta($invoice_id, $this->invoice_prefix . 'payment_term', $payment_term);
      update_post_meta($invoice_id, $this->invoice_prefix . 'details', $details);
      update_post_meta($invoice_id, $this->invoice_prefix . 'supplier_name', $supplier_name);
      update_post_meta($invoice_id, $this->invoice_prefix . 'supplier_registration_number',
        $supplier_registration_number);
      update_post_meta($invoice_id, $this->invoice_prefix . 'supplier_vat_number', $supplier_vat_number);
      update_post_meta($invoice_id, $this->invoice_prefix . 'supplier_details', $supplier_details);
      update_post_meta($invoice_id, $this->invoice_prefix . 'customer_name', $customer_name);
      update_post_meta($invoice_id, $this->invoice_prefix . 'customer_registration_number',
        $customer_registration_number);
      update_post_meta($invoice_id, $this->invoice_prefix . 'customer_vat_number', $customer_vat_number);
      update_post_meta($invoice_id, $this->invoice_prefix . 'customer_details', $customer_details);
      update_post_meta($invoice_id, $this->invoice_prefix . 'item', $items);
      if ($gateway == 'wire-transfer') {
        $_SESSION['messages'][] = ['success', __('Advance invoice was created.', 'inventor-invoices')];
      }
    }

    /**
     * @return mixed|void
     */
    public function get_next_invoice_number()
    {
      $next_number = 1;
      $invoices    = $this->get_all_invoices();
      if (count($invoices) > 0) {
        $last_invoice        = $invoices[0];
        $last_invoice_number = get_the_title($last_invoice);
        if (is_numeric($last_invoice_number)) {
          $next_number = (int)$last_invoice_number + 1;
        }
      }
      while ($this->invoice_number_exists($next_number)) {
        ++$next_number;
      }

      return apply_filters('inventor_invoices_next_invoice_number', $next_number);
    }

    /**
     * @return array
     */
    public function get_all_invoices()
    {
      $query = new \WP_Query([
        'post_type'      => 'invoice',
        'posts_per_page' => -1,
        'post_status'    => 'any',
        'orderby'        => 'date',
        'order'          => 'DESC'
      ]);

      return $query->posts;
    }

    /**
     * @param $invoice_number
     *
     * @return bool
     */
    public function invoice_number_exists($invoice_number)
    {
      global $wpdb;
      $title_ids
        = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT ID FROM {$wpdb->posts} WHERE post_status = \"publish\" AND post_title = '%s'",
        $invoice_number));

      return count($title_ids) > 0;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function get_control_label($id)
    {
      $labels = [
        'inventor_wire_transfer_account_number' => __('Account number', 'inventor'),
        'inventor_wire_transfer_swift'          => __('Bank code', 'inventor'),
        'inventor_wire_transfer_full_name'      => __('Full name', 'inventor'),
        'inventor_wire_transfer_street'         => __('Street / P.O.Box', 'inventor'),
        'inventor_wire_transfer_postcode'       => __('Postcode', 'inventor'),
        'inventor_wire_transfer_city'           => __('City', 'inventor'),
        'inventor_wire_transfer_country'        => __('Country', 'inventor')
      ];

      return array_key_exists($id, $labels) ? $labels[$id] : $id;
    }

    /**
     * @param $types
     *
     * @return mixed
     */
    public function default_types($types)
    {
      $types['INVOICE']         = __('Invoice', 'inventor-invoices');
      $types['ADVANCE']         = __('Advance invoice', 'inventor-invoices');
      $types['PROFORMA']        = __('Proforma invoice', 'inventor-invoices');
      $types['VAT_CREDIT_NOTE'] = __('VAT credit note', 'inventor-invoices');

      return $types;
    }

    /**
     * @param $proceed
     * @param $gateway
     *
     * @return bool
     */
    public function proceed_payment_gateway($proceed, $gateway)
    {
      if ($gateway == 'wire-transfer') {
        return true;
      }

      return $proceed;
    }

    /**
     * @param $single
     *
     * @return mixed
     */
    public function invoice_template($single)
    {
      global $post;
      if ($post->post_type == 'invoice') {
        if ( ! defined('ABSPATH')) {
          exit;
        }
        get_header(); ?>
        <section id="primary" class="content-area">
          <main id="main" class="site-main content" role="main">
            <?php if (have_posts()) : ?>
              <?php while (have_posts()) : the_post(); ?>
                <div class="invoice">
                  <?php
                    $invoice_id                   = get_the_ID();
                    $issue_date                   = get_the_date('Y-m-d');
                    $type                         = get_post_meta($invoice_id, $this->invoice_prefix . 'type', true);
                    $currency_code                = get_post_meta($invoice_id, $this->invoice_prefix . 'currency_code',
                      true);
                    $reference                    = get_post_meta($invoice_id, $this->invoice_prefix . 'reference',
                      true);
                    $payment_term                 = get_post_meta($invoice_id, $this->invoice_prefix . 'payment_term',
                      true);
                    $details                      = get_post_meta($invoice_id, $this->invoice_prefix . 'details', true);
                    $supplier_name                = get_post_meta($invoice_id, $this->invoice_prefix . 'supplier_name',
                      true);
                    $supplier_registration_number = get_post_meta($invoice_id,
                      $this->invoice_prefix . 'supplier_registration_number', true);
                    $supplier_vat_number          = get_post_meta($invoice_id,
                      $this->invoice_prefix . 'supplier_vat_number', true);
                    $supplier_details             = get_post_meta($invoice_id,
                      $this->invoice_prefix . 'supplier_details', true);
                    $customer_name                = get_post_meta($invoice_id, $this->invoice_prefix . 'customer_name',
                      true);
                    $customer_registration_number = get_post_meta($invoice_id,
                      $this->invoice_prefix . 'customer_registration_number', true);
                    $customer_vat_number          = get_post_meta($invoice_id,
                      $this->invoice_prefix . 'customer_vat_number', true);
                    $customer_details             = get_post_meta($invoice_id,
                      $this->invoice_prefix . 'customer_details', true);
                    $items                        = get_post_meta($invoice_id, $this->invoice_prefix . 'item', true);
                    $total                        = $this->get_invoice_total($invoice_id);
                  ?>
                  <h1><?= $this->get_type_display($type); ?> #<?php the_title(); ?></h1>
                  <section id="general">
                    <dl>
                      <dt><?= __('Issue date', 'inventor-invoices') . ':' ?></dt>
                      <dd><?= $issue_date; ?></dd>
                      <dt><?= __('Payment term', 'inventor-invoices') . ':' ?></dt>
                      <dd><?= _n(sprintf('%d day', $payment_term), sprintf('%d days', $payment_term), $payment_term,
                          'inventor-invoices'); ?></dd>
                      <dt><?= __('Reference', 'inventor-invoices') . ':' ?></dt>
                      <dd><?= $reference; ?></dd>
                    </dl>
                  </section>
                  <?php if ( ! empty($details)): ?>
                    <section id="details">
                      <dl>
                        <dt><?= __('Details / Instructions', 'inventor-invoices') . ':' ?></dt>
                        <dd><?= nl2br(apply_filters('inventor_invoices_payment_details', $details)); ?></dd>
                      </dl>
                    </section>
                  <?php endif; ?>
                  <section id="supplier">
                    <h2><?= __('Supplier', 'inventor-invoices') ?></h2>
                    <dl>
                      <dt><?= __('Name', 'inventor-invoices') . ':' ?></dt>
                      <dd><?= $supplier_name; ?></dd>
                      <dt><?= __('Reg. No.', 'inventor-invoices') . ':' ?></dt>
                      <dd><?= $supplier_registration_number; ?></dd>
                      <dt><?= __('VAT No.', 'inventor-invoices') . ':' ?></dt>
                      <dd><?= $supplier_vat_number; ?></dd>
                      <dt><?= __('Details', 'inventor-invoices') . ':' ?></dt>
                      <dd><?= nl2br(apply_filters('inventor_invoices_supplier_details', $supplier_details)); ?></dd>
                    </dl>
                  </section>
                  <section id="customer">
                    <h2><?= __('Customer', 'inventor-invoices') ?></h2>
                    <dl>
                      <dt><?= __('Name', 'inventor-invoices') . ':' ?></dt>
                      <dd><?= $customer_name; ?></dd>
                      <dt><?= __('Reg. No.', 'inventor-invoices') . ':' ?></dt>
                      <dd><?= $customer_registration_number; ?></dd>
                      <dt><?= __('VAT No.', 'inventor-invoices') . ':' ?></dt>
                      <dd><?= $customer_vat_number; ?></dd>
                      <dt><?= __('Details', 'inventor-invoices') . ':' ?></dt>
                      <dd><?= nl2br(apply_filters('inventor_invoices_customer_details', $customer_details)); ?></dd>
                    </dl>
                  </section>
                  <section id="items">
                    <?php $items_count = count($items); ?>
                    <?php if ($items_count > 0) : ?>
                      <table class="invoice-items-table">
                        <thead>
                          <th><?= __('Item', 'inventor-invoice'); ?></th>
                          <th><?= __('Quantity', 'inventor-invoice'); ?></th>
                          <th><?= __('Unit price', 'inventor-invoice'); ?></th>
                          <th><?= __('Tax rate', 'inventor-invoice'); ?></th>
                          <th><?= __('Subtotal', 'inventor-invoice'); ?></th>
                          <th><?= __('Currency', 'inventor-invoice'); ?></th>
                        </thead>
                        <tbody>
                          <?php foreach ((array)$items as $item): ?>
                            <?php
                            $title      = $item[$this->invoice_prefix . 'item_title'];
                            $quantity   = $item[$this->invoice_prefix . 'item_quantity'];
                            $unit_price = $item[$this->invoice_prefix . 'item_unit_price'];
                            $tax_rate   = $item[$this->invoice_prefix . 'item_tax_rate'];
                            $subtotal   = $this->get_invoice_item_subtotal($item);
                            ?>
                            <tr>
                              <td><?= $title; ?></td>
                              <td><?= $quantity; ?></td>
                              <td><?= $unit_price; ?></td>
                              <td><?= $tax_rate; ?>%</td>
                              <td><?= $subtotal; ?></td>
                              <td><?= $currency_code; ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    <?php else : ?>
                      <div class="alert alert-warning"><?= __('No invoice items found.', 'inventor-invoices'); ?></div>
                    <?php endif; ?>
                  </section>
                  <section id="total">
                    <label><?= __('Total', 'inventor-invoices') . ':' ?></label> <span><?php printf('%s %s', $total,
                        $currency_code); ?>
                      <span>
                  </section>
                </div>
              <?php endwhile; ?>
              <?php the_posts_pagination([
                'prev_text'          => __('Previous', 'inventor-invoices'),
                'next_text'          => __('Next', 'inventor-invoices'),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page',
                    'inventor-invoices') . ' </span>'
              ]); ?>
            <?php else : ?>
              <?php get_template_part('content', 'none'); ?>
            <?php endif; ?>
          </main>
        </section>
        <?php get_footer();
      }

      return $single;
    }

    /**
     * @param $type
     *
     * @return mixed
     */
    public function get_type_display($type)
    {
      $types = apply_filters('inventor_invoices_types', []);

      return array_key_exists($type, $types) ? $types[$type] : $type;
    }

    /**
     * @param $atts
     */
    public function invoices($atts)
    {
      if ( ! is_user_logged_in()) { ?>
        <div class="alert alert-warning">
          <?php if ( ! is_user_logged_in()) : ?>
            <?= esc_attr__('You need to log in at first.', 'inventor'); ?>
          <?php else: ?>
            <?= esc_attr__('You are not allowed to access this page.', 'inventor'); ?>
            <?php if ( ! empty($message)) : ?>
              <?= $message; ?>
            <?php endif; ?>
          <?php endif; ?>
        </div>
        <?php if ( ! is_user_logged_in()) : ?>
          <div class="row">
            <div class="<?= get_option('users_can_register') ? 'col-md-6' : 'col-md-12'; ?>">
              <div class="login-form-wrapper">
                <h1 class="text-center"><?= __('Login', 'inventor'); ?></h1>
                <?= \Inventor_Shortcodes::login(); ?>
              </div>
            </div>
            <?php if (get_option('users_can_register')) : ?>
              <div class="<?= get_option('users_can_register') ? 'col-md-6' : 'col-md-12'; ?>">
                <div class="register-form-wrapper">
                  <h1 class="text-center"><?= __('Register', 'inventor'); ?></h1>
                  <?= \Inventor_Shortcodes::register(); ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
        <?php endif;

        return;
      }
      $this->loop_my_invoices();
      if ( ! defined('ABSPATH')) {
        exit;
      }
      ?>
      <?php if (have_posts()) : ?>
      <table class="invoices-table">
        <thead>
          <tr>
            <th><?= __('Number', 'inventor-invoices'); ?></th>
            <th><?= __('Type', 'inventor-invoices'); ?></th>
            <th><?= __('Items', 'inventor-invoices'); ?></th>
            <th><?= __('Total', 'inventor-invoices'); ?></th>
            <th><?= __('Currency', 'inventor-invoices'); ?></th>
            <th><?= __('Issue date', 'inventor-invoices'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php while (have_posts()) : the_post(); ?>
            <tr>
              <td>
                <strong>
                  <a href="<?= get_the_permalink(get_the_ID()); ?>">#<?php the_title(); ?></a>
                </strong>
              </td>
              <td>
                <?php
                  $type  = get_post_meta(get_the_ID(), $this->invoice_prefix . 'type', true);
                  $types = apply_filters('inventor_invoices_types', []);
                  echo empty($types[$type]) ? $type : $types[$type];
                ?>
              </td>
              <td>
                <?php foreach ($this->get_invoice_item_list(get_the_ID()) as $item): ?>
                  <?= esc_attr($item); ?>
                <?php endforeach; ?>
              </td>
              <td>
                <?= $this->get_invoice_total(get_the_ID()); ?>
              </td>
              <td>
                <?= get_post_meta(get_the_ID(), $this->invoice_prefix . 'currency_code', true); ?>
              </td>
              <td>
                <?= get_the_date('Y-m-d'); ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <?php the_posts_pagination([
        'prev_text'          => __('Previous page', 'inventor'),
        'next_text'          => __('Next page', 'inventor'),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'inventor') . ' </span>'
      ]); ?>
    <?php else : ?>
      <div class="alert alert-warning"><?= __('No invoices found.', 'inventor'); ?></div>
    <?php endif; ?>
      <?php wp_reset_query();
    }

    public function loop_my_invoices()
    {
      $paged = get_query_var('paged') ? get_query_var('paged') : 1;
      query_posts([
        'post_type'   => 'invoice',
        'paged'       => $paged,
        'post_status' => 'publish',
        'author'      => get_current_user_id()
      ]);
    }

    /**
     * @param $invoice_id
     *
     * @return array
     */
    public function get_invoice_item_list($invoice_id)
    {
      $items = get_post_meta($invoice_id, $this->invoice_prefix . 'item', true);
      if ( ! is_array($items)) {
        return [];
      }
      $result = [];
      foreach ((array)$items as $item) {
        $item_title_key = $this->invoice_prefix . 'item_title';
        $item_title     = ( ! empty($item[$item_title_key])) ? $item[$item_title_key] : null;
        if ( ! empty($item_title)) {
          $result[] = $item_title;
        }
      }

      return $result;
    }
  }

<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
<article id="page-<?php the_ID(); ?>" <?php post_class('payment'); ?>>
    <?php $payment_type = ! empty($_POST['payment_type']) ? $_POST['payment_type'] : null; ?>
    <?php $object_id = ! empty($_POST['object_id']) ? $_POST['object_id'] : null; ?>
    <?php $payment_gateway = ! empty($_POST['payment_gateway']) ? $_POST['payment_gateway'] : false; ?>
    <?php $currency = Inventor_Price::default_currency_code(); ?>

    <?php if (empty($payment_type)) : ?>
    <div class="payment-info">
        <?php echo __('You are missing payment type.', 'inventor'); ?>
    </div>
    <?php elseif (! in_array($payment_type, apply_filters('inventor_payment_types', []))) : ?>
    <div class="payment-info">
        <?php echo __('Invalid payment type.', 'inventor'); ?>
    </div>
    <?php elseif (empty($object_id)) : ?>
    <div class="payment-info">
        <?php echo __('Object is missing.', 'inventor'); ?>
    </div>
    <?php else: ?>
    <?php do_action('inventor_payment_form_before', $payment_type, $object_id, $payment_gateway); ?>
    <form class="payment-form" method="post" action="?">
        <?php do_action('inventor_payment_form_fields', $payment_type, $object_id, $payment_gateway); ?>

        <?php if (! empty($payment_type)) : ?>
        <input type="hidden" name="payment_type" value="<?php echo esc_attr($payment_type); ?>">
        <?php endif; ?>

        <?php if (! empty($object_id)) : ?>
        <input type="hidden" name="object_id" value="<?php echo esc_attr($object_id); ?>">
        <?php endif; ?>

        <?php if (! empty($currency)) : ?>
        <input type="hidden" name="currency" value="<?php echo esc_attr($currency); ?>">
        <?php endif; ?>

        <?php $price = apply_filters('inventor_payment_form_price_value', null, $payment_type, $object_id); ?>
      <h2><?php echo __('Billing details', 'inventor') ?></h2>
        <?php echo Inventor_Template_Loader::load('payment/billing-details'); ?>

        <?php if (! empty($price) && $price !== 0) : ?>
        <h2><?php echo __('Payment gateway', 'inventor') ?></h2>
        <input type="hidden" name="price" value="<?php echo esc_attr($price); ?>">
        <?php
        $payment_gateways = apply_filters('inventor_payment_gateways', []);
        $payment_gateways_count = count($payment_gateways);
        ?>
        <?php if (is_array($payment_gateways) && $payment_gateways_count > 0) : ?>
          <input type="hidden" name="process-payment" value="1">
            <?php foreach ($payment_gateways as $gateway) : ?>
            <div class="gateway">
              <div class="gateway-header">
                <div class="radio-wrapper">
                  <label for="gateway-<?php echo esc_attr($gateway['id']); ?>">
                    <input type="radio" id="gateway-<?php echo esc_attr($gateway['id']); ?>" name="payment_gateway" value="<?php echo esc_attr($gateway['id']); ?>" data-proceed="<?php var_export($gateway['proceed']); ?>" <?php if (! empty($gateway['submit_title'])) : ?>data-submit-title="<?php echo $gateway['submit_title']; ?>"<?php 
                   endif; ?> <?php if ($payment_gateway === $gateway['id']) : ?>checked="checked"<?php 
                   endif; ?>>
                    <span><?php echo esc_attr($gateway['title']); ?></span>
                  </label>
                </div>
              </div>
                <?php if (! empty($gateway['content'])) : ?>
                <div class="gateway-content"><?php echo $gateway['content']; ?></div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            <?php $terms = get_theme_mod('inventor_general_terms_and_conditions_page', false); ?>
          <div class="payment-form-bottom">
            <?php if (! empty($terms)) : ?>
              <h2><?php echo __('Terms & Conditions', 'inventor') ?></h2>
                <?php $agree_terms = ! empty($_POST['agree_terms']) ? $_POST['agree_terms'] : false; ?>
              <div class="form-group terms-conditions-input">
                <div class="checkbox">
                  <label for="terms-and-conditions">
                    <input id="terms-and-conditions" type="checkbox" name="agree_terms" required="required" <?php if ($agree_terms) : ?>checked<?php 
                   endif; ?>>
                    <?php echo sprintf(
                        __('I agree with <a href="%s">terms & conditions</a>', 'inventor'),
                        get_permalink($terms)
                    ); ?>
                  </label>
                </div>
              </div>
            <?php endif; ?>

            <?php $submission_page_id = get_theme_mod('inventor_submission_list_page'); ?>
            <button type="submit" name="process-payment" class="payment-process btn btn-primary hidden">
                <?php echo __('Proceed payment', 'inventor'); ?>
            </button>
          </div>
        <?php else : ?>
          <div class="alert alert-warning">
            <?php echo __('No payment gateways found.', 'inventor'); ?>
          </div>
        <?php endif; ?>
        <?php endif; ?>

        <?php if (! empty($submission_page_id)) : ?>
        <p class="payment-back">
            <?php echo __('Back to', 'inventor'); ?>:
          <a href="<?php echo get_permalink($submission_page_id); ?>">
            <?php echo get_the_title($submission_page_id); ?>
          </a>
        </p>
        <?php endif; ?>
    </form>
    <?php do_action('inventor_payment_form_after', $payment_type, $object_id, $payment_gateway); ?>
    <?php endif; ?>
</article>

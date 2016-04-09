<?php if ('package' == $payment_type) : ?>

    <?php if (!empty($object_id)) : ?>
        <?php $title = get_the_title($object_id); ?>
        <?php $price = get_post_meta($object_id, INVENTOR_PACKAGE_PREFIX.'price', true); ?>

        <?php if (Inventor_Packages_Logic::is_package_trial($object_id)) : ?>
            <div class="alert alert-danger">
                <?php echo __("You can't choose trial package.", 'inventor-package'); ?>
            </div><!-- /.payment-info -->
        <?php elseif (Inventor_Packages_Logic::is_package_free($object_id)) : ?>
            <div class="payment-info">
                <?php echo sprintf(__('You choosed package <strong>"%s"</strong>.', 'inventor-package'), $title); ?>
            </div><!-- /.payment-info -->
        <?php else : ?>
            <div class="payment-info">
                <?php echo sprintf(__('You are going to pay <strong>%s</strong> for package <strong>"%s"</strong>.', 'inventor-package'), Inventor_Price::format_price($price), $title); ?>
            </div><!-- /.payment-info -->
        <?php endif; ?>

    <?php else : ?>
        <div class="payment-info">
            <?php echo __('Missing package.', 'inventor-package'); ?>
        </div><!-- /.payment-info -->
    <?php endif; ?>

<?php endif; ?>
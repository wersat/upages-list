<?php if (empty($listing)): ?>
  <div class="alert alert-warning">
    <?php echo __('You have to specify listing!', 'inventor-claims') ?>
  </div>
<?php elseif (Inventor_Claims_Logic::user_already_claimed($listing->ID, get_current_user_id())): ?>
  <div class="alert alert-info">
    <?php echo __('You have already claimed this listing. Please, wait for admin review.', 'inventor-claims') ?>
  </div>
<?php else: ?>
  <form method="post" action="<?php echo get_the_permalink($listing) ?>">
    <input type="hidden" name="listing_id" value="<?php echo $listing->ID; ?>">
    <div class="form-group">
      <input class="form-control" name="name" type="text" placeholder="<?php echo __('Name',
        'inventor-claims'); ?>" required="required">
    </div>
    <div class="form-group">
      <input class="form-control" name="email" type="email" placeholder="<?php echo __('E-mail',
        'inventor-claims'); ?>" required="required">
    </div>
    <div class="form-group">
      <input class="form-control" name="phone" type="phone" placeholder="<?php echo __('Phone',
        'inventor-claims'); ?>" required="required">
    </div>
    <div class="form-group">
      <textarea class="form-control" name="message" required="required" placeholder="<?php echo __('Message',
        'inventor-claims'); ?>" rows="4"></textarea>
    </div>
    <?php if (class_exists('Inventor_Recaptcha')) : ?>
      <?php if (Inventor_Recaptcha::is_recaptcha_enabled()) : ?>
        <div id="recaptcha-<?php echo esc_attr($this->id); ?>" class="recaptcha" data-sitekey="<?php echo get_theme_mod('inventor_recaptcha_site_key'); ?>"></div>
      <?php endif; ?>
    <?php endif; ?>
    <div class="button-wrapper">
      <button type="submit" class="btn btn-primary" name="claim_form"><?php echo sprintf(__('Claim %s',
          'inventor-claims'), get_the_title($listing)); ?></button>
    </div>
  </form>
<?php endif; ?>

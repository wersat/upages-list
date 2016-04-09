<?php
  if ( ! defined('ABSPATH')) {
    exit;
  }
?>

<?php if (get_option('users_can_register')) : ?>
  <?php if ( ! is_user_logged_in()) : ?>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="register-form">
      <div class="form-group">
        <label for="register-form-name"><?php echo __('Username', 'inventor'); ?></label>
        <input id="register-form-name" type="text" name="name" class="form-control" required="required">
      </div>
      <div class="form-group">
        <label for="register-form-email"><?php echo __('E-mail', 'inventor'); ?></label>
        <input id="register-form-email" type="email" name="email" class="form-control" required="required">
      </div>
      <div class="form-group">
        <label for="register-form-password"><?php echo __('Password', 'inventor'); ?></label>
        <input id="register-form-password" type="password" name="password" class="form-control" required="required">
      </div>
      <div class="form-group">
        <label for="register-form-retype"><?php echo __('Retype Password', 'inventor'); ?></label>
        <input id="register-form-retype" type="password" name="password_retype" class="form-control" required="required">
      </div>
      <?php $terms = get_theme_mod('inventor_general_terms_and_conditions_page', false); ?>

      <?php if ( ! empty($terms)) : ?>
        <div class="form-group terms-conditions-input">
          <div class="checkbox">
            <label for="register-form-conditions">
              <input id="register-form-conditions" type="checkbox" name="agree_terms">
              <?php echo sprintf(__('I agree with <a href="%s">terms & conditions</a>', 'inventor'),
                get_permalink($terms)); ?>
            </label>
          </div>
        </div>
      <?php endif; ?>

      <?php do_action('wordpress_social_login'); ?>
      <button type="submit" class="button" name="register_form"><?php echo __('Sign Up', 'inventor'); ?></button>
    </form>
  <?php else : ?>
    <div class="alert alert-warning">
      <?php echo __('You are already logged in.', 'inventor'); ?>
    </div>
  <?php endif; ?>
<?php else: ?>
  <div class="alert alert-warning">
    <?php echo __('Registrations are not allowed.', 'inventor'); ?>
  </div>
<?php endif; ?>

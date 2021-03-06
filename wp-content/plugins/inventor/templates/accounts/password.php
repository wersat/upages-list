<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
<form method="post" action="<?php the_permalink(); ?>" class="change-password-form">
  <div class="form-group">
    <label for="change-password-form-old-password"><?php echo __('Old password', 'inventor'); ?></label>
    <input id="change-password-form-old-password" class="form-control" type="password" name="old_password" required="required">
  </div>
  <div class="form-group">
    <label for="change-password-form-new-password"><?php echo __('New password', 'inventor'); ?></label>
    <input id="change-password-form-new-password" class="form-control" type="password" name="new_password" required="required" minlength="8">
  </div>
  <div class="form-group">
    <label for="change-password-form-retype-password"><?php echo __('Retype password', 'inventor'); ?></label>
    <input id="change-password-form-retype-password" class="form-control" type="password" name="retype_password" required="required" minlength="8">
  </div>
  <button type="submit" name="change_password_form" class="button"><?php echo __(
      'Change Password',
      'inventor'
  ); ?></button>
</form>

<?php
  if ( ! defined('ABSPATH')) {
    exit;
  }
?>

<?php if ( ! is_user_logged_in()) : ?>
  <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="login-form">
    <div class="form-group">
      <label for="login-form-username"><?php echo __('Username', 'inventor'); ?></label>
      <input id="login-form-username" type="text" name="login" class="form-control" required="required">
    </div>
    <div class="form-group">
      <label for="login-form-password"><?php echo __('Password', 'inventor'); ?></label>
      <input id="login-form-password" type="password" name="password" class="form-control" required="required">
    </div>
    <?php do_action('wordpress_social_login'); ?>
    <button type="submit" name="login_form" class="button"><?php echo __('Log in', 'inventor'); ?></button>
  </form>
<?php else: ?>
  <div class="alert alert-warning">
    <?php echo __('You are already logged in.', 'inventor'); ?>
  </div>
<?php endif; ?>

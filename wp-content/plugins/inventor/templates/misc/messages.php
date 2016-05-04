<?php $session = $_SESSION; ?>
<?php if (! empty($session['messages']) && is_array($session['messages'])) : ?>
    <?php $session['messages'] = Inventor_Utilities::array_unique_multidimensional($session['messages']); ?>
  <div class="alerts">
    <?php foreach ($session['messages'] as $message) : ?>
      <div class="alert-primary alert alert-dismissible alert-<?php echo esc_attr($message[0]); ?>">
        <div class="alert-inner">
          <div class="container">
            <?php echo wp_kses($message[1], wp_kses_allowed_html('post')); ?>
            <button type="button" class="close" data-dismiss="alert">
              <i class="fa fa-close"></i>
            </button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
    <?php unset($_SESSION['messages']); ?>
<?php endif; ?>

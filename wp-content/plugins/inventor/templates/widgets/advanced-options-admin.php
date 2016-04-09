<?php
  if (!defined('ABSPATH')) {
      exit;
  }
  $background_color = !empty($instance['background_color']) ? $instance['background_color'] : '';
  $background_image = !empty($instance['background_image']) ? $instance['background_image'] : '';
  $padding_top = isset($instance['padding_top']) ? $instance['padding_top'] : '';
  $padding_bottom = isset($instance['padding_bottom']) ? $instance['padding_bottom'] : '';
  $classes = !empty($instance['classes']) ? $instance['classes'] : '';
?>
<div class="widget widget-advanced-options">
  <div class="widget-top" style="background-color: transparent;">
    <div class="widget-title" style="cursor: pointer;">
      <h4 style="color: #333">
        <span class="dashicons dashicons-admin-generic" style="margin: -3px 0px -4px -2px; font-size: 18px;"></span> <?php echo __('Advanced Options',
          'inventor'); ?></h4>
    </div>
  </div>
  <div class="widget-inside">
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('background_color')); ?>">
        <?php echo __('Background Color', 'inventor'); ?>
      </label>
      <br>
      <input class="widefat color-picker"
             id="<?php echo esc_attr($this->get_field_id('background_color')); ?>"
             name="<?php echo esc_attr($this->get_field_name('background_color')); ?>"
             type="text"
             value="<?php echo esc_attr($background_color); ?>">
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('background_image')); ?>">
        <?php echo __('Background Image (URL)', 'inventor'); ?>
      </label>
      <input class="widefat"
             id="<?php echo esc_attr($this->get_field_id('background_image')); ?>"
             name="<?php echo esc_attr($this->get_field_name('background_image')); ?>"
             type="text"
             value="<?php echo esc_attr($background_image); ?>">
    </p>
    <p>
      <input class="widefat"
             id="<?php echo esc_attr($this->get_field_id('padding_top')); ?>"
             name="<?php echo esc_attr($this->get_field_name('padding_top')); ?>"
             type="checkbox"
             value=1
        <?php checked($padding_top, 1); ?>>
      <label for="<?php echo esc_attr($this->get_field_id('padding_top')); ?>">
        <?php echo __('Padding Top', 'inventor'); ?>
      </label>
    </p>
    <p>
      <input class="widefat"
             id="<?php echo esc_attr($this->get_field_id('padding_bottom')); ?>"
             name="<?php echo esc_attr($this->get_field_name('padding_bottom')); ?>"
             type="checkbox"
             value=1
        <?php checked($padding_bottom, 1); ?>>
      <label for="<?php echo esc_attr($this->get_field_id('padding_bottom')); ?>">
        <?php echo __('Padding Bottom', 'inventor'); ?>
      </label>
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('classes')); ?>">
        <?php echo __('Classes', 'inventor'); ?>
      </label>
      <input class="widefat"
             id="<?php echo esc_attr($this->get_field_id('classes')); ?>"
             name="<?php echo esc_attr($this->get_field_name('classes')); ?>"
             type="text"
             value="<?php echo esc_attr($classes); ?>">
      <br>
      <small><?php echo __('Additional classes e.g. <i>background-gray</i>', 'inventor'); ?></small>
    </p>
  </div>
</div>
<script type="text/javascript">
  jQuery(document).ready(function ($) {
    var colorPicker = $('#widgets-right .color-picker, .inactive-sidebar .color-picker');
    var parent = colorPicker.parent();
    colorPicker.wpColorPicker()
    parent.find('.wp-color-result').click();
  });
</script>

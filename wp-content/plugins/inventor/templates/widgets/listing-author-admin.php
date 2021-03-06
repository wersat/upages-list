<?php
if (! defined('ABSPATH')) {
    exit;
}
?>

<?php $title = ! empty($instance['title']) ? $instance['title'] : ''; ?>
<p>
  <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
    <?php echo __('Title', 'inventor'); ?>
  </label>
  <input class="widefat"
         id="<?php echo esc_attr($this->get_field_id('title')); ?>"
         name="<?php echo esc_attr($this->get_field_name('title')); ?>"
         type="text"
         value="<?php echo esc_attr($title); ?>">
</p>

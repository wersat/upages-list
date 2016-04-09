<?php
  if ( ! defined('ABSPATH')) {
    exit;
  }
  $title              = ! empty($instance['title']) ? $instance['title'] : '';
  $description        = ! empty($instance['description']) ? $instance['description'] : '';
  $listing_categories = ! empty($instance['listing_categories']) ? $instance['listing_categories'] : [];
  $per_row            = ! empty($instance['per_row']) ? $instance['per_row'] : 3;
?>
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
<p>
  <label for="<?php echo esc_attr($this->get_field_id('description')); ?>">
    <?php echo __('Description', 'inventor'); ?>
  </label>

	<textarea class="widefat"
            rows="4"
            id="<?php echo esc_attr($this->get_field_id('description')); ?>"
            name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo esc_attr($description); ?></textarea>
</p>
<p>
  <label for="<?php echo esc_attr($this->get_field_id('categories')); ?>">
    <?php echo __('Listing categories', 'inventor'); ?>
  </label>
  <select id="<?php echo esc_attr($this->get_field_id('listing_categories')); ?>" style="width: 100%;"
          multiple="multiple"
          name="<?php echo esc_attr($this->get_field_name('listing_categories')); ?>[]">
    <?php $terms = get_terms('listing_categories', ['parent' => 0, 'hide_empty' => false]); ?>

    <?php if (is_array($terms)) : ?>
      <?php foreach ($terms as $term) : ?>
        <option value="<?php echo esc_attr($term->term_id); ?>" <?php if (in_array($term->term_id,
          $listing_categories)) : ?>selected="selected"<?php endif; ?>><?php echo esc_attr($term->name); ?></option>
      <?php endforeach; ?>
    <?php endif; ?>
  </select>
</p>
<p>
  <label for="<?php echo esc_attr($this->get_field_id('per_row')); ?>">
    <?php echo __('Items per row', 'inventor'); ?>
  </label>
  <select id="<?php echo esc_attr($this->get_field_id('per_row')); ?>"
          name="<?php echo esc_attr($this->get_field_name('per_row')); ?>">
    <option value="1" <?php echo ('1' === $per_row) ? 'selected="selected"' : ''; ?>>1</option>
    <option value="2" <?php echo ('2' === $per_row) ? 'selected="selected"' : ''; ?>>2</option>
    <option value="3" <?php echo ('3' === $per_row) ? 'selected="selected"' : ''; ?>>3</option>
    <option value="4" <?php echo ('4' === $per_row) ? 'selected="selected"' : ''; ?>>4</option>
    <option value="6" <?php echo ('5' === $per_row) ? 'selected="selected"' : ''; ?>>5</option>
    <option value="6" <?php echo ('6' === $per_row) ? 'selected="selected"' : ''; ?>>6</option>
  </select>
</p>

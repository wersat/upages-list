<?php
  if ( ! defined('ABSPATH')) {
    exit;
  }
  $title              = ! empty($instance['title']) ? $instance['title'] : '';
  $description        = ! empty($instance['description']) ? $instance['description'] : '';
  $listing_categories = ! empty($instance['listing_categories']) ? $instance['listing_categories'] : [];
  $show_count         = ! empty($instance['show_count']) ? $instance['show_count'] : '';
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
  <label>
    <input type="checkbox"
           class="checkbox"
      <?php echo ( ! empty($show_count)) ? 'checked="checked"' : ''; ?>
           id="<?php echo esc_attr($this->get_field_id('show_count')); ?>"
           name="<?php echo esc_attr($this->get_field_name('show_count')); ?>">
    <?php echo __('Show count', 'inventor'); ?>
  </label>
</p>

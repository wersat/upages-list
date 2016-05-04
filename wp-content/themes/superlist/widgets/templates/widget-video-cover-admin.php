<?php
  /**
   * Widget template
   * @package    Superlist
   * @subpackage Widgets/Templates
   */
  $height          = ! empty($instance['height']) ? $instance['height'] : '';
  $poster          = ! empty($instance['poster']) ? $instance['poster'] : '';
  $video_mp4       = ! empty($instance['video_mp4']) ? $instance['video_mp4'] : '';
  $video_ogg       = ! empty($instance['video_ogg']) ? $instance['video_ogg'] : '';
  $filter          = ! empty($instance['filter']) ? $instance['filter'] : '';
  $button_text     = ! empty($instance['button_text']) ? $instance['button_text'] : '';
  $input_titles    = ! empty($instance['input_titles']) ? $instance['input_titles'] : 'labels';
  $button_text     = ! empty($instance['button_text']) ? $instance['button_text'] : '';
?>
<p>
  <label for="<?php echo esc_attr($this->get_field_id('height')); ?>">
    <?php echo esc_attr__('Height', 'superlist'); ?>
  </label>
  <input class="widefat"
         id="<?php echo esc_attr($this->get_field_id('height')); ?>"
         name="<?php echo esc_attr($this->get_field_name('height')); ?>"
         type="text"
         value="<?php echo esc_attr($height); ?>">
</p>
<p>
  <label for="<?php echo esc_attr($this->get_field_id('poster')); ?>">
    <?php echo esc_attr__('Preset Image URL', 'superlist'); ?>
  </label>
  <input class="widefat"
         id="<?php echo esc_attr($this->get_field_id('poster')); ?>"
         name="<?php echo esc_attr($this->get_field_name('poster')); ?>"
         type="text"
         value="<?php echo esc_attr($poster); ?>">
</p>
<p>
  <label for="<?php echo esc_attr($this->get_field_id('video_mp4')); ?>">
    <?php echo esc_attr__('Video MP4', 'superlist'); ?>
  </label>
  <input class="widefat"
         id="<?php echo esc_attr($this->get_field_id('video_mp4')); ?>"
         name="<?php echo esc_attr($this->get_field_name('video_mp4')); ?>"
         type="text"
         value="<?php echo esc_attr($video_mp4); ?>">
</p>
<p>
  <label for="<?php echo esc_attr($this->get_field_id('video_ogg')); ?>">
    <?php echo esc_attr__('Video OGG', 'superlist'); ?>
  </label>
  <input class="widefat"
         id="<?php echo esc_attr($this->get_field_id('video_ogg')); ?>"
         name="<?php echo esc_attr($this->get_field_name('video_ogg')); ?>"
         type="text"
         value="<?php echo esc_attr($video_ogg); ?>">
</p>
<?php if (class_exists('Inventor')) : ?>
  <p>
    <label for="<?php echo esc_attr($this->get_field_id('filter')); ?>">
      <input type="checkbox"
             <?php if ( ! empty($filter)) : ?>checked="checked"<?php endif; ?>
             name="<?php echo esc_attr($this->get_field_name('filter')); ?>"
             id="<?php echo esc_attr($this->get_field_id('filter')); ?>">
      <?php echo esc_attr__('Filter', 'superlist'); ?>
    </label>
  </p>
  <p>
    <label for="<?php echo esc_attr($this->get_field_id('button_text')); ?>">
      <?php echo esc_attr__('Filter Button Text', 'superlist'); ?>
    </label>
    <input class="widefat"
           id="<?php echo esc_attr($this->get_field_id('button_text')); ?>"
           name="<?php echo esc_attr($this->get_field_name('button_text')); ?>"
           type="text"
           value="<?php echo esc_attr($button_text); ?>">
  </p>
  <h4><?php echo esc_attr__('Input titles', 'superlist'); ?></h4>
  <ul>
    <li>
      <label>
        <input type="radio"
               class="radio"
               value="labels"
          <?php echo (empty($input_titles) || 'labels' === $input_titles) ? 'checked="checked"' : ''; ?>
               id="<?php echo esc_attr($this->get_field_id('input_titles')); ?>"
               name="<?php echo esc_attr($this->get_field_name('input_titles')); ?>">
        <?php echo esc_attr__('Labels', 'superlist'); ?>
      </label>
    </li>
    <li>
      <label>
        <input type="radio"
               class="radio"
               value="placeholders"
          <?php echo ('placeholders' === $input_titles) ? 'checked="checked"' : ''; ?>
               id="<?php echo esc_attr($this->get_field_id('input_titles')); ?>"
               name="<?php echo esc_attr($this->get_field_name('input_titles')); ?>">
        <?php echo esc_attr__('Placeholders', 'superlist'); ?>
      </label>
    </li>
  </ul>
  <h4><?php echo esc_attr__('Filter Fields', 'superlist'); ?></h4>
  <?php include Inventor_Template_Loader::locate('widgets/filter-fields'); ?>
<?php endif; ?>

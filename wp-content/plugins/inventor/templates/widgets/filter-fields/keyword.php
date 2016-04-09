<?php if (empty($instance['hide_keyword'])) : ?>
  <div class="form-group form-group-keyword">
    <?php if ('labels' === $input_titles) : ?>
      <label for="<?php echo !empty($field_id_prefix) ? $field_id_prefix
        : ''; ?><?php echo esc_attr($args['widget_id']); ?>_keyword"><?php echo __('Keyword', 'inventor'); ?></label>
    <?php endif; ?>
    <input type="text" name="filter-keyword"
           <?php if ('placeholders' === $input_titles) : ?>placeholder="<?php echo __('Keyword',
             'inventor'); ?>"<?php endif; ?>
           class="form-control" value="<?php echo !empty($_GET['filter-keyword']) ? $_GET['filter-keyword'] : ''; ?>"
           id="<?php echo !empty($field_id_prefix) ? $field_id_prefix
             : ''; ?><?php echo esc_attr($args['widget_id']); ?>_keyword">
  </div>
<?php endif; ?>

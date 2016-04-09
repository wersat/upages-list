<?php
  /**
   * Build children hierarchy.
   *
   * @param $term
   * @param $taxonomy
   * @param $selected
   * @param $parent_term
   * @param $depth
   *
   * @return null|string
   */
  function build_hierarchical_taxonomy_select_options($taxonomy, $selected = null, $parent_term = null, $depth = 1)
  {
    $output = null;
    $terms  = get_terms($taxonomy, [
      'hide_empty' => false,
      'parent'     => $parent_term ? $parent_term->term_id : 0,
    ]);
    if ( ! empty($terms) && is_array($terms)) {
      $output = '';
      foreach ($terms as $term) {
        $args = [
          'value' => $term->term_id,
          //				'value' => $term->slug,
          'label' => str_repeat('&raquo;&nbsp;', $depth - 1) . ' ' . $term->name,
        ];
        //			if ( $term->slug === $selected ) {
        if ($term->term_id === $selected) {
          $args['checked'] = 'checked';
        }
        $output .= sprintf("\t" . '<option value="%s" %s>%s</option>', $args['value'],
            selected(isset($args['checked']) && $args['checked'], true, false), $args['label']) . "\n";
        $children = build_hierarchical_taxonomy_select_options($taxonomy, $selected, $term, $depth + 1);
        if ( ! empty($children)) {
          $output .= $children;
        }
      }
    }

    return $output;
  }

?>

<?php if (empty($instance['hide_location'])) : ?>
  <div class="form-group">
    <?php if ('labels' === $input_titles) : ?>
      <label for="<?php echo ! empty($field_id_prefix) ? $field_id_prefix
        : ''; ?><?php echo esc_attr($args['widget_id']); ?>_locations"><?php echo __('Location', 'inventor'); ?></label>
    <?php endif; ?>

    <?php $locations = get_terms('locations', [
      'hide_empty' => false,
    ]); ?>
    <select class="form-control"
            name="filter-locations"
            data-size="10"
            <?php if (count($locations) > 10) : ?>data-live-search="true"<?php endif; ?>
            id="<?php echo ! empty($field_id_prefix) ? $field_id_prefix
              : ''; ?><?php echo esc_attr($args['widget_id']); ?>_locations">
      <option value="">
        <?php if ('placeholders' === $input_titles) : ?>
          <?php echo __('Location', 'inventor'); ?>
        <?php else : ?>
          <?php echo __('All locations', 'inventor'); ?>
        <?php endif; ?>
      </option>
      <?php $location_options = build_hierarchical_taxonomy_select_options('locations',
        empty($_GET['filter-locations']) ? null : $_GET['filter-locations']); ?>
      <?php echo $location_options; ?>
    </select>
  </div>
<?php endif; ?>

<?php if (empty($instance['hide_category'])) : ?>
  <div class="form-group">
    <?php if ('labels' === $input_titles) : ?>
      <label for="<?php echo ! empty($field_id_prefix) ? $field_id_prefix
        : ''; ?><?php echo esc_attr($args['widget_id']); ?>_listing_categories"><?php echo __(
            'Category',
            'inventor'
        ); ?></label>
    <?php endif; ?>

    <?php $categories = get_terms(
        'listing_categories', [
        'hide_empty' => false,
        ]
    );
      $categories_count = count($categories);
    ?>
    <select class="form-control"
            name="filter-listing_categories"
            data-size="10"
            <?php if ($categories_count > 10) : ?>data-live-search="true"<?php 
            endif; ?>
            id="<?php echo ! empty($field_id_prefix) ? $field_id_prefix
              : ''; ?><?php echo esc_attr($args['widget_id']); ?>_listing_categories">
      <option value="">
        <?php if ('placeholders' === $input_titles) : ?>
            <?php echo __('Category', 'inventor'); ?>
        <?php else : ?>
            <?php echo __('All categories', 'inventor'); ?>
        <?php endif; ?>
      </option>
        <?php $categories = get_terms(
            'listing_categories', [
            'hide_empty' => false,
            'parent'     => 0,
            ]
        ); ?>

        <?php if (is_array($categories)) : ?>
        <?php foreach ($categories as $category) : ?>
          <option value="<?php echo esc_attr($category->term_id); ?>" <?php if (! empty($_GET['filter-listing_categories']) && $_GET['filter-listing_categories'] === $category->term_id) : ?>selected="selected"<?php 
         endif; ?>><?php echo esc_html($category->name); ?></option>
            <?php $subcategories = get_terms(
                'listing_categories', [
                'hide_empty' => false,
                'parent'     => $category->term_id,
                ]
            ); ?>
            <?php if (is_array($subcategories)) : ?>
            <?php foreach ($subcategories as $subcategory) : ?>
              <option value="<?php echo esc_attr($subcategory->term_id); ?>" <?php if (! empty($_GET['filter-listing_categories']) && $_GET['filter-listing_categories'] === $subcategory->term_id) : ?>selected="selected"<?php 
             endif; ?>>
                &nbsp;&nbsp;&nbsp;&raquo;&nbsp; <?php echo esc_html($subcategory->name); ?>
              </option>
                <?php $subsubcategories = get_terms(
                    'listing_categories', [
                    'hide_empty' => false,
                    'parent'     => $subcategory->term_id,
                    ]
                ); ?>
                <?php if (is_array($subsubcategories)) : ?>
                <?php foreach ($subsubcategories as $subsubcategory) : ?>
                  <option value="<?php echo esc_attr($subsubcategory->term_id); ?>" <?php if (! empty($_GET['filter-listing_categories']) && $_GET['filter-listing_categories'] === $subsubcategory->term_id) : ?>selected="selected"<?php 
                 endif; ?>>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&nbsp; <?php echo esc_html($subsubcategory->name); ?>
                  </option>
                <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php endif; ?>
    </select>
  </div>
<?php endif; ?>

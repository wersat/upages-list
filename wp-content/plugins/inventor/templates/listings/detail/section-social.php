<?php $social_metabox = CMB2_Boxes::get(INVENTOR_LISTING_PREFIX.get_post_type().'_social'); ?>
<?php $has_social = false; ?>
<?php if (!empty($social_metabox)) : ?>
  <?php if (is_array($social_metabox->meta_box['fields'])) : ?>
    <?php foreach ($social_metabox->meta_box['fields'] as $key => $value) : ?>
      <?php $social_value = get_post_meta(get_the_ID(), $value['id'], true); ?>
      <?php if (!empty($social_value)) : ?>
        <?php $has_social = true; ?>
      <?php endif; ?>
    <?php endforeach; ?>
    <?php if ($has_social) : ?>
      <div id="listing-detail-section-social" class="listing-detail-section">
        <h2 class="page-header"><?php echo $section_title; ?></h2>
        <?php foreach ($social_metabox->meta_box['fields'] as $key => $value) : ?>
          <?php $social = get_post_meta(get_the_ID(), $value['id'], true); ?>
          <?php if (!empty($social)) : ?>
            <?php $parts = explode('_', $value['id']); ?>
            <a href="<?php echo esc_attr($social); ?>">
              <?php echo esc_attr($parts[1]); ?>
            </a>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php endif; ?>

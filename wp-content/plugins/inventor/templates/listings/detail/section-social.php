<?php
  $social_metabox = CMB2_Boxes::get(INVENTOR_LISTING_PREFIX . get_post_type() . '_social');
  $has_social     = false;
  if ($social_metabox !== null && is_array($social_metabox->meta_box['fields'])) {
    foreach ($social_metabox->meta_box['fields'] as $key => $value) {
      $social_value = get_post_meta(get_the_ID(), $value['id'], true);
      $has_social   = $social_value !== null ?? true;
    }
    if ($has_social) { ?>
      <div id="listing-detail-section-social" class="listing-detail-section">
        <h2 class="page-header"><?= $section_title; ?></h2>
        <?php
          foreach ($social_metabox->meta_box['fields'] as $key => $value) {
            $social = get_post_meta(get_the_ID(), $value['id'], true);
            if ($social !== null) {
              $parts = explode('_', $value['id']);
              ?>
              <a href="<?= esc_attr($social); ?>">
                <?= esc_attr($parts[1]); ?>
              </a>
            <?php }
          } ?>
      </div>
    <?php }
  }

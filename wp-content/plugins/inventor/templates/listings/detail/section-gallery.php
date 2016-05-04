<?php
  $if_allowed_gallery = apply_filters('inventor_submission_listing_metabox_allowed', true, 'gallery',
    get_the_author_meta('ID'));
  if ($if_allowed_gallery) {
    $gallery       = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'gallery', true);
    $gallery_count = count($gallery);
    if ( ! empty($gallery) && is_array($gallery)) { ?>
      <div class="listing-detail-section" id="listing-detail-section-gallery">
        <h2 class="page-header"><?= $section_title; ?></h2>
        <div class="listing-detail-gallery-wrapper">
          <div class="listing-detail-gallery">
            <?php
              $index = 0;
              foreach ((array)$gallery as $id => $src) {
                $img     = wp_get_attachment_image_src($id, 'large');
                $src     = esc_url($img[0]);
                $item_id = esc_attr($index++); ?>
                <a href="<?= $src; ?>" rel="listing-gallery" data-item-id="<?= $item_id; ?>">
                  <span class="item-image" data-background-image="<?= $src; ?>"></span>
                </a>
                <?php
              } ?>
          </div>
          <div class="listing-detail-gallery-preview" data-count="<?= $gallery_count ?>">
            <div class="listing-detail-gallery-preview-inner">
              <?php $index = 0;
                foreach ((array)$gallery as $id => $src) {
                  $item_id = esc_attr($index++);
                  $img     = wp_get_attachment_image_src($id, 'thumbnail');
                  $img_src = $img[0]; ?>
                  <div data-item-id="<?= $item_id; ?>">
                    <img src="<?= $img_src; ?>" alt="">
                  </div>
                <?php } ?>
            </div>
          </div>
        </div>
      </div>
    <?php }
  }

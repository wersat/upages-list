<?php
  $if_allowed_video = apply_filters('inventor_submission_listing_metabox_allowed', true, 'video',
    get_the_author_meta('ID'));
  if ($if_allowed_video) {
    $video = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'video', true);
    if ($video !== null) { ?>
      <div class="listing-detail-section" id="listing-detail-section-video">
        <h2 class="page-header"><?= $section_title; ?></h2>
        <div class="video-embed-wrapper">
          <?= apply_filters('the_content', '[embed width="1280" height="720"]' . esc_attr($video) . '[/embed]'); ?>
        </div>
      </div>
    <?php }
  }

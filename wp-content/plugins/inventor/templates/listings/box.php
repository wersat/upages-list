<div class="listing-box">
  <?php
    if (has_post_thumbnail()) {
      $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail'); ?>
      <div class="listing-box-image" style="background-image: url('<?= esc_attr($image[0]); ?>');">
        <a href="<?php the_permalink(); ?>"></a>
      </div>
    <?php } else { ?>
      <div class="listing-box-image" style="background-image: url('<?= plugins_url('inventor'); ?>/assets/img/default-item.png');">
        <a href="<?php the_permalink(); ?>"></a>
      </div>
    <?php } ?>
  <div class="listing-box-content">
    <h3>
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>
    <?php
      do_action('inventor_listing_content', get_the_ID(), 'box');
      $location = Inventor_Query::get_listing_location_name(get_the_ID(), '/', false);
      if ( ! empty($location)) : ?>
        <div class="listing-box-location">
          <?= wp_kses($location, wp_kses_allowed_html('post')); ?>
        </div>
      <?php endif;
      $price = Inventor_Price::get_price();
      if ( ! empty($price)) : ?>
        <div class="listing-box-price">
          <?= wp_kses($price, wp_kses_allowed_html('post')); ?>
        </div>
      <?php endif; ?>
  </div>
  <div class="listing-box-read-more">
  </div>
</div>

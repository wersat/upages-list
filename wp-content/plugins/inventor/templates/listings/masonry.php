<div class="listing-masonry">
  <?php if (has_post_thumbnail()) : ?>
    <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium'); ?>
    <div class="listing-masonry-image" style="background-image: url('<?php echo esc_attr($image[0]); ?>');">
      <a href="<?php the_permalink(); ?>"></a>
    </div>
  <?php else : ?>
    <div class="listing-masonry-image" style="background-image: url('<?php echo plugins_url('inventor'); ?>/assets/img/default-item.png');">
      <a href="<?php the_permalink(); ?>"></a>
    </div>
  <?php endif; ?>
  <div class="listing-masonry-content">
    <h3>
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>
    <?php do_action('inventor_listing_content', get_the_ID(), 'masonry'); ?>

    <?php $location = Inventor_Query::get_listing_location_name(get_the_ID(), '/', false); ?>
    <?php if (!empty($location)) : ?>
      <div class="listing-masonry-location"><?php echo wp_kses($location, wp_kses_allowed_html('post')); ?></div>
    <?php endif; ?>

    <?php $price = Inventor_Price::get_price(); ?>
    <?php if (!empty($price)) : ?>
      <div class="listing-masonry-price"><?php echo wp_kses($price, wp_kses_allowed_html('post')); ?></div>
    <?php endif; ?>
  </div>
  <div class="listing-masonry-read-more">
  </div>
</div>

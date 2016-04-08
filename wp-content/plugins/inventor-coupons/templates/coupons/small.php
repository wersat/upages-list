<?php
  /**
   * Template file.
   */
?>
<div class="coupon-small">
  <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium'); ?>
  <div class="coupon-small-image"
       style="background-image: url('<?php if (has_post_thumbnail()) : ?><?php echo esc_attr($image['0']); ?><?php else : ?><?php echo esc_attr(plugins_url('inventor')); ?>/assets/img/default-item.png<?php endif; ?>');">
    <div class="coupon-small-image-shadow"></div>
    <a href="<?php the_permalink(); ?>" class="coupon-small-image-link"></a>
    <?php $discount = get_post_meta(get_the_ID(), INVENTOR_COUPON_PREFIX . 'discount', true); ?>
    <?php if ( ! empty($discount)) : ?>
      <span class="coupon-small-image-label">
				<?php echo esc_attr($discount); ?>%
			</span>
    <?php endif; ?>

    <?php $location = Inventor_Query::get_listing_location_name(); ?>
    <?php if ( ! empty($location)) : ?>
      <div class="coupon-small-image-location">
        <?php echo wp_kses($location, wp_kses_allowed_html('post')); ?>
      </div>
    <?php endif; ?>
  </div>
  <div class="coupon-small-content">
    <h2>
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
  </div>
</div>

<?php
  /**
   * Template file
   * @package    Superlist
   * @subpackage Templates
   */
?>

<?php $featured = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'featured', true); ?>
<div class="listing-row <?php if ( ! empty($featured)) : ?>featured<?php endif; ?>">
  <div class="listing-row-image"
    <?php if (has_post_thumbnail()) : ?>
      <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium'); ?>
      style="background-image: url('<?php echo esc_attr($image[0]); ?>')"
    <?php else : ?>
      style="background-image: url('<?php echo esc_attr(plugins_url('inventor')); ?>/assets/img/default-item.png');"
    <?php endif; ?>
  >
    <a href="<?php the_permalink() ?>" class="listing-row-image-link"></a>
    <div class="listing-row-actions">
      <?php do_action('superlist_before_card_box_detail'); ?>
      <a href="<?php the_permalink(); ?>" class="fa fa-eye"></a>
      <?php do_action('superlist_after_card_box_detail', get_the_ID()); ?>
    </div>
    <?php $listing_category = Inventor_Query::get_listing_category_name(); ?>
    <?php if ( ! empty($listing_category)) : ?>
      <div class="listing-row-label-top"><?php echo wp_kses($listing_category, wp_kses_allowed_html('post')); ?></div>
    <?php endif; ?>

    <?php $price = Inventor_Price::get_price(); ?>
    <?php if ( ! empty($price)) : ?>
      <div class="listing-row-label-bottom"><?php echo wp_kses($price, wp_kses_allowed_html('post')); ?></div>
    <?php endif; ?>
  </div>
  <div class="listing-row-body">
    <h2 class="listing-row-title">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
    <div class="listing-row-content">
      <?php the_excerpt(); ?>
      <p>
        <a class="read-more-link" href="<?php echo esc_attr(get_permalink(get_the_ID())); ?>"><?php echo esc_attr__('Read More',
            'superlist'); ?>
          <i class="fa fa-chevron-right"></i>
        </a>
      </p>
    </div>
  </div>
  <div class="listing-row-properties">
    <dl>
      <?php if ( ! empty($price)) : ?>
        <dt><?php echo esc_attr__('Price', 'superlist'); ?></dt>
        <dd><?php echo wp_kses($price, wp_kses_allowed_html('post')); ?></dd>
      <?php endif; ?>

      <?php if ( ! empty($listing_category)) : ?>
        <dt><?php echo esc_attr__('Category', 'superlist'); ?></dt>
        <dd><?php echo wp_kses($listing_category, wp_kses_allowed_html('post')); ?></dd>
      <?php endif; ?>

      <?php $location = Inventor_Query::get_listing_location_name(get_the_ID(), '/', false); ?>
      <?php if ( ! empty($location)) : ?>
        <dt><?php echo esc_attr__('Location', 'superlist'); ?></dt>
        <dd><?php echo wp_kses($location, wp_kses_allowed_html('post')); ?></dd>
      <?php endif; ?>

      <?php do_action('inventor_listing_content', get_the_ID(), 'row'); ?>
    </dl>
  </div>
</div>


<?php $featured = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX.'featured', true); ?>
<?php $reduced = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX.'reduced', true); ?>
<div class="listing-row <?php if (!empty($featured) && 'on' == $featured) : ?>listing-featured<?php endif; ?> <?php if (!empty($reduced) && 'on' == $reduced) : ?>listing-reduced<?php endif; ?>">
  <div class="listing-row-image">
    <?php if (has_post_thumbnail()) : ?>
      <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail'); ?>
      <a href="<?php the_permalink(); ?>" style="background-image: url('<?php echo esc_attr($image[0]); ?>');"></a>
    <?php else : ?>
      <a href="<?php the_permalink(); ?>" class="listing-row-image" style="background-image: url('<?php echo plugins_url('inventor'); ?>/assets/img/default-item.png');"></a>
    <?php endif; ?>

    <?php $price = Inventor_Price::get_price(); ?>
    <?php if (!empty($price)) : ?>
      <div class="listing-row-price">
        <?php echo wp_kses($price, wp_kses_allowed_html('post')); ?>
      </div>
    <?php endif; ?>
  </div>
  <div class="listing-row-body">
    <h2 class="listing-row-title">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
    <div class="listing-row-content">
      <?php the_excerpt(); ?>
    </div>
  </div>
  <div class="listing-row-properties">
    <dl>
      <?php $listing_category = Inventor_Query::get_listing_category_name(); ?>
      <?php if (!empty($listing_category)) : ?>
        <dt><?php echo __('Category', 'inventor'); ?></dt>
        <dd><?php echo wp_kses($listing_category, wp_kses_allowed_html('post')); ?></dd>
      <?php endif; ?>

      <?php $location = Inventor_Query::get_listing_location_name(get_the_ID(), '/', false); ?>
      <?php if (!empty($location)) : ?>
        <dt><?php echo __('Location', 'inventor'); ?></dt>
        <dd><?php echo wp_kses($location, wp_kses_allowed_html('post')); ?></dd>
      <?php endif; ?>

      <?php do_action('inventor_listing_content', get_the_ID(), 'row'); ?>
    </dl>
  </div>
</div>

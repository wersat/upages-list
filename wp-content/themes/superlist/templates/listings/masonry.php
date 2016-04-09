<?php
  /**
   * Template file
   * @package    Superlist
   * @subpackage Templates
   */
?>

<?php if (has_post_thumbnail()) : ?>
<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium'); ?>
<div class="listing-masonry" style="background-image: url('<?php echo esc_attr($image[0]); ?>');">
  <?php else : ?>
  <div class="listing-masonry" style="background-image: url('<?php echo esc_attr(plugins_url('inventor')); ?>/assets/img/default-item.png');">
    <?php endif; ?>
    <a href="<?php the_permalink(); ?>" class="listing-masonry-content-link"></a>
    <div class="listing-masonry-background">
      <div class="listing-masonry-content">
        <h2 class="listing-masonry-title"><?php the_title(); ?></h2>
        <?php $location = Inventor_Query::get_listing_location_name(get_the_ID(), '/'); ?>
        <?php if ( ! empty($location)) : ?>
          <div class="listing-masonry-meta">
            <?php echo wp_kses($location, wp_kses_allowed_html('post')); ?>
          </div>
        <?php endif; ?>

        <?php do_action('inventor_listing_content', get_the_ID(), 'masonry'); ?>
        <div class="listing-masonry-actions">
          <?php do_action('superlist_before_card_box_detail'); ?>
          <a href="<?php the_permalink(); ?>" class="fa fa-eye"></a>
          <?php do_action('superlist_after_card_box_detail', get_the_ID()); ?>
        </div>
      </div>
      <?php $listing_category = Inventor_Query::get_listing_category_name(); ?>
      <?php if ( ! empty($listing_category)) : ?>
        <div class="listing-masonry-label-top"><?php echo wp_kses($listing_category,
            wp_kses_allowed_html('post')); ?></div>
      <?php endif; ?>
    </div>
  </div>

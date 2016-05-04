<?php
  /**
   * Template file
   * @package    Superlist
   * @subpackage Templates
   */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
  <?php if (has_post_thumbnail()) : ?>
    <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large'); ?>
    <div class="post-image" style="background-image: url('<?php echo esc_attr($image[0]); ?>')">
      <a class="read-more" href="<?php echo esc_attr(get_the_permalink()); ?>"><?php echo esc_attr__('View',
          'superlist'); ?></a>
    </div>
  <?php endif; ?>
  <div class="post-content">
    <h2>
      <a href="<?php echo esc_attr(get_the_permalink()); ?>"><?php the_title(); ?></a>
    </h2>
    <?php the_excerpt(); ?>
  </div>
  <div class="post-meta clearfix">
    <div class="post-meta-author"><?php echo esc_attr__('By', 'superlist'); ?><?php the_author_posts_link(); ?></div>
    <div class="post-meta-date"><?php the_date(); ?></div>
    <?php if (has_category()) : ?>
      <div class="post-meta-categories">
        <i class="fa fa-tags"></i> <?php echo wp_kses(get_the_category_list(', '), wp_kses_allowed_html('post')); ?>
      </div>
    <?php endif; ?>
    <div class="post-meta-comments">
      <i class="fa fa-comments"></i> <?php comments_number(); ?></div>
    <div class="post-meta-more">
      <a href="<?php echo esc_attr(get_the_permalink()); ?>"><?php echo esc_attr__('Read more', 'superlist'); ?>
        <i class="fa fa-chevron-right"></i>
      </a>
    </div>
  </div>
</div>

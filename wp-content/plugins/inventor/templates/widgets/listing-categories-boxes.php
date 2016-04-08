<?php
  if (!defined('ABSPATH')) {
      exit;
  }
?>

<?php $instance['per_row'] = !empty($instance['per_row']) ? $instance['per_row'] : 3; ?>

<?php echo wp_kses($args['before_widget'], wp_kses_allowed_html('post')); ?>
<div class="widget-inner
 <?php if (!empty($instance['classes'])) : ?><?php echo esc_attr($instance['classes']); ?><?php endif; ?>
 <?php echo (empty($instance['padding_top'])) ? '' : 'widget-pt'; ?>
 <?php echo (empty($instance['padding_bottom'])) ? '' : 'widget-pb'; ?>"
  <?php if (!empty($instance['background_color']) || !empty($instance['background_image'])) : ?>
    style="
    <?php if (!empty($instance['background_color'])) : ?>
      background-color: <?php echo esc_attr($instance['background_color']); ?>;
    <?php endif; ?>
    <?php if (!empty($instance['background_image'])) : ?>
      background-image: url('<?php echo esc_attr($instance['background_image']); ?>');
    <?php endif; ?>"
  <?php endif; ?>>
  <?php if (!empty($instance['title'])) : ?>
    <?php echo wp_kses($args['before_title'], wp_kses_allowed_html('post')); ?>
    <?php echo wp_kses($instance['title'], wp_kses_allowed_html('post')); ?>
    <?php echo wp_kses($args['after_title'], wp_kses_allowed_html('post')); ?>
  <?php endif; ?>


  <?php if (!empty($instance['description'])) : ?>
    <div class="description">
      <?php echo wp_kses($instance['description'], wp_kses_allowed_html('post')); ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($instance['listing_categories']) && is_array($instance['listing_categories'])) : ?>
    <div class="listing-categories-boxes items-per-row-<?php echo esc_attr($instance['per_row']); ?>">
      <?php $index = 0; ?>
      <div class="listing-categories-boxes-row">
        <?php foreach ($instance['listing_categories'] as $category) : ?>
        <div class="listing-categories-boxes-container">
          <?php if (is_numeric($category)) : ?>
            <?php $term = get_term($category); ?>
          <?php else : ?>
            <?php $term = get_term_by('slug', $category, 'listing_categories'); ?>
          <?php endif; ?>
          <div class="listing-categories-boxes-item">
            <?php $image = Taxonomy_MetaData::get('listing_categories', $term->term_id, 'image'); ?>
            <?php if (!empty($image)) : ?>
              <div class="listing-categories-boxes-item-image" style="background-image: url('<?php echo esc_attr($image); ?>');">
                <a href="<?php echo get_term_link($term->term_id, $term->taxonomy); ?>"></a>
              </div>
            <?php else : ?>
              <div class="listing-categories-boxes-item-image" style="background-image: url('<?php echo plugins_url('inventor'); ?>/assets/img/default-item.png');">
                <a href="<?php the_permalink(); ?>"></a>
              </div>
            <?php endif; ?>
            <div class="listing-categories-boxes-item-content">
              <h3>
                <a href="<?php echo get_term_link($term->term_id,
                  $term->taxonomy); ?>"><?php echo esc_attr($term->name); ?></a>
              </h3>
              <?php $description = term_description($term->term_id, $term->taxonomy); ?>
              <?php if (!empty($description)) : ?>
                <div class="listing-categories-boxes-item-description">
                  <?php echo wp_kses($description, wp_kses_allowed_html('post')); ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php if (0 == (($index + 1) % $instance['per_row']) && 1 != $instance['per_row']) : ?>
      </div>
      <div class="listing-categories-boxes-row">
        <?php endif; ?>
        <?php ++$index; ?>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</div>
<?php echo wp_kses($args['after_widget'], wp_kses_allowed_html('post')); ?>

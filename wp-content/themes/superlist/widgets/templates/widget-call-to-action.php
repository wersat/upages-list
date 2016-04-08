<?php
  /**
   * Widget template
   * @package    Superlist
   * @subpackage Widgets/Templates
   */
?>

<?php echo wp_kses($args['before_widget'], wp_kses_allowed_html('post')); ?>
<div class="widget-inner
	<?php echo esc_attr($instance['classes']); ?>
	<?php echo (empty($instance['padding_top'])) ? '' : 'widget-pt'; ?>
	<?php echo (empty($instance['padding_bottom'])) ? '' : 'widget-pb'; ?>"
  <?php if ( ! empty($instance['background_color']) || ! empty($instance['background_image'])) : ?>
    style="
    <?php if ( ! empty($instance['background_color'])) : ?>
      background-color: <?php echo esc_attr($instance['background_color']); ?>;
    <?php endif; ?>
    <?php if ( ! empty($instance['background_image'])) : ?>
      background-image: url('<?php echo esc_attr( $instance['background_image'] ); ?>');
    <?php endif; ?>"
  <?php endif; ?>>
  <?php if ( ! empty($instance['title'])) : ?>
    <h2 class="widgettitle">
      <?php echo wp_kses($instance['title'], wp_kses_allowed_html('post')); ?>
    </h2>
  <?php endif; ?>

  <?php if ( ! empty($instance['description'])) : ?>
    <div class="description">
      <?php echo wp_kses($instance['description'], wp_kses_allowed_html('post')); ?>
    </div>
  <?php endif; ?>
  <div class="row">
    <div class="col-sm-9">
      <?php echo wp_kses($instance['text'], wp_kses_allowed_html('post')); ?>
    </div>
    <div class="col-sm-3">
      <a href="<?php echo wp_kses($instance['button_link'], wp_kses_allowed_html('post')); ?>" class="btn btn-primary">
        <?php echo esc_attr($instance['button_text']); ?>
      </a>
    </div>
  </div>
</div>
<?php echo wp_kses($args['after_widget'], wp_kses_allowed_html('post')); ?>

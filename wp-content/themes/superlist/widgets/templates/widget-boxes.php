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
    <?php for ($i = 1; $i <= 3; $i++) : ?>
      <?php $title_id = 'title_' . $i; ?>
      <?php $content_id = 'content_' . $i; ?>
      <?php $icon_id = 'icon_' . $i; ?>
      <?php $link_id = 'link_' . $i; ?>
      <div class="col-sm-4">
        <div class="box">
          <div class="box-icon">
            <i class="fa <?php echo wp_kses($instance[$icon_id], wp_kses_allowed_html('post')); ?>"></i>
          </div>
          <div class="box-body">
            <h4 class="box-title"><?php echo wp_kses($instance[$title_id], wp_kses_allowed_html('post')); ?></h4>
            <div class="box-content">
              <?php echo wp_kses($instance[$content_id], wp_kses_allowed_html('post')); ?>
            </div>
            <?php $read_more = $instance[$link_id]; ?>
            <?php if ( ! empty($read_more)) : ?>
              <a href="<?php echo wp_kses($read_more, wp_kses_allowed_html('post')); ?>" class="box-read-more">
                <?php echo esc_attr__('Read More', 'superlist'); ?>
                <i class="fa fa-angle-right"></i>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endfor; ?>
  </div>
</div>
<?php echo wp_kses($args['after_widget'], wp_kses_allowed_html('post')); ?>

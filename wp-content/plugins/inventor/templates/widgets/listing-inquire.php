<?php
  if ( ! defined('ABSPATH')) {
    exit;
  }
?>

<?php echo wp_kses($args['before_widget'], wp_kses_allowed_html('post')); ?>
<div class="widget-inner
 <?php if ( ! empty($instance['classes'])) : ?><?php echo esc_attr($instance['classes']); ?><?php endif; ?>
 <?php echo (empty($instance['padding_top'])) ? '' : 'widget-pt'; ?>
 <?php echo (empty($instance['padding_bottom'])) ? '' : 'widget-pb'; ?>"
  <?php if ( ! empty($instance['background_color']) || ! empty($instance['background_image'])) : ?>
    style="
    <?php if ( ! empty($instance['background_color'])) : ?>
      background-color: <?php echo esc_attr($instance['background_color']); ?>;
    <?php endif; ?>
    <?php if ( ! empty($instance['background_image'])) : ?>
      background-image: url('<?php echo esc_attr($instance['background_image']); ?>');
    <?php endif; ?>"
  <?php endif; ?>>
  <?php if ( ! empty($instance['title'])) : ?>
    <?php echo wp_kses($args['before_title'], wp_kses_allowed_html('post')); ?>
    <?php echo wp_kses($instance['title'], wp_kses_allowed_html('post')); ?>
    <?php echo wp_kses($args['after_title'], wp_kses_allowed_html('post')); ?>
  <?php endif; ?>
  <form method="post" action="<?php the_permalink(); ?>">
    <input type="hidden" name="post_id" value="<?php the_ID(); ?>">
    <?php if ( ! empty($instance['receive_admin'])) : ?>
      <input type="hidden" name="receive_admin" value="1">
    <?php endif; ?>

    <?php if ( ! empty($instance['receive_author'])) : ?>
      <input type="hidden" name="receive_author" value="1">
    <?php endif; ?>

    <?php if ( ! empty($instance['receive_listing_email'])) : ?>
      <input type="hidden" name="receive_listing_email" value="1">
    <?php endif; ?>

    <?php if ( ! empty($instance['show_name'])) : ?>
      <div class="form-group">
        <input class="form-control" name="name" type="text" placeholder="<?php echo __('Name',
          'inventor'); ?>" required="required">
      </div>
    <?php endif; ?>

    <?php if ( ! empty($instance['show_email'])) : ?>
      <div class="form-group">
        <input class="form-control" name="email" type="email" placeholder="<?php echo __('E-mail',
          'inventor'); ?>" required="required">
      </div>
    <?php endif; ?>

    <?php if ( ! empty($instance['show_phone'])) : ?>
      <div class="form-group">
        <input class="form-control" name="phone" type="text" placeholder="<?php echo __('Phone',
          'inventor'); ?>" required="required">
      </div>
    <?php endif; ?>

    <?php if ( ! empty($instance['show_subject'])) : ?>
      <div class="form-group">
        <input class="form-control" name="subject" type="text" placeholder="<?php echo __('Subject',
          'inventor'); ?>" required="required">
      </div>
    <?php endif; ?>

    <?php if ( ! empty($instance['show_date'])) : ?>
      <div class="form-group">
        <input class="form-control" name="date" type="date" required="required">
      </div>
    <?php endif; ?>

    <?php if ( ! empty($instance['show_message'])) : ?>
      <div class="form-group">
        <textarea class="form-control" name="message" required="required" placeholder="<?php echo __('Message',
          'inventor'); ?>" rows="4"></textarea>
      </div>
    <?php endif; ?>
    <div class="button-wrapper">
      <button type="submit" class="button" name="inquire_form"><?php echo __('Send Message', 'inventor'); ?></button>
    </div>
  </form>
</div>
<?php echo wp_kses($args['after_widget'], wp_kses_allowed_html('post')); ?>

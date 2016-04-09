<?php
  if (!defined('ABSPATH')) {
      exit;
  }
?>

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

  <?php $id = get_the_author_meta('ID'); ?>
  <div class="listing-author">
    <?php $image = get_user_meta($id, INVENTOR_USER_PREFIX.'general_image', true); ?>
    <?php $first_name = get_user_meta($id, INVENTOR_USER_PREFIX.'general_first_name', true); ?>
    <?php $last_name = get_user_meta($id, INVENTOR_USER_PREFIX.'general_last_name', true); ?>
    <?php $email = get_user_meta($id, INVENTOR_USER_PREFIX.'general_email', true); ?>
    <?php $website = get_user_meta($id, INVENTOR_USER_PREFIX.'general_website', true); ?>
    <?php $social_facebook = get_user_meta($id, INVENTOR_USER_PREFIX.'social_facebook', true); ?>
    <?php $social_twitter = get_user_meta($id, INVENTOR_USER_PREFIX.'social_twitter', true); ?>
    <?php $social_linkedin = get_user_meta($id, INVENTOR_USER_PREFIX.'social_linkedin', true); ?>

    <?php if (!empty($image)) : ?>
      <div class="listing-author-image">
        <img src="<?php echo esc_attr($image); ?>" alt="">
      </div>
    <?php endif; ?>

    <?php if (!empty($first_name) || !empty($last_name)) : ?>
      <div class="listing-author-name">
        <?php echo esc_attr($first_name); ?><?php echo esc_attr($last_name); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($website) || !empty($email)) : ?>
      <div class="listing-author-contact">
        <?php if (!empty($website)): ?>
          <a href="<?php echo esc_attr($website); ?>"><?php echo __('Website', 'inventor'); ?></a>
        <?php endif; ?>

        <?php if (!empty($email)) : ?>
          <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo __('Message', 'inventor'); ?></a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($social_facebook) || !empty($social_twitter) || !empty($social_linked)) : ?>
      <div class="listing-author-social">
        <?php if (!empty($social_facebook)) : ?>
          <a href="<?php echo esc_attr($social_facebook); ?>">
            <i class="fa fa-facebook"></i>
          </a>
        <?php endif; ?>

        <?php if (!empty($social_twitter)) : ?>
          <a href="<?php echo esc_attr($social_twitter); ?>">
            <i class="fa fa-twitter"></i>
          </a>
        <?php endif; ?>

        <?php if (!empty($social_linkedin)) : ?>
          <a href="<?php echo esc_attr($social_linkedin); ?>">
            <i class="fa fa-linkedin"></i>
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php echo wp_kses($args['after_widget'], wp_kses_allowed_html('post')); ?>

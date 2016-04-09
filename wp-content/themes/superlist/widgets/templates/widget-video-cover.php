<?php
  /**
   * Widget template
   * @package    Superlist
   * @subpackage Widgets/Templates
   */
  $title           = ! empty($instance['title']) ? $instance['title'] : '';
  $subtitle        = ! empty($instance['subtitle']) ? $instance['subtitle'] : '';
  $height          = ! empty($instance['height']) ? $instance['height'] : '';
  $poster          = ! empty($instance['poster']) ? $instance['poster'] : '';
  $overlay_opacity = ! empty($instance['overlay_opacity']) ? $instance['overlay_opacity'] : '0.4';
  $video_mp4       = ! empty($instance['video_mp4']) ? $instance['video_mp4'] : '';
  $video_ogg       = ! empty($instance['video_ogg']) ? $instance['video_ogg'] : '';
  $input_titles    = ! empty($instance['input_titles']) ? $instance['input_titles'] : 'labels';
  $button_text     = ! empty($instance['button_text']) ? $instance['button_text'] : '';
  $sort            = ! empty($instance['sort']) ? $instance['sort'] : '';
?>

<?php echo wp_kses($args['before_widget'], wp_kses_allowed_html('post')); ?>
<div id="video-outer-wrap" class="video-cover" style="<?php if ( ! empty($poster)) : ?>background-image: url('<?php echo esc_attr( $poster )?>');<?php endif; ?><?php if ( ! empty($height)) : ?>height: <?php echo esc_attr($height); ?>"<?php endif; ?>>
  <div id="video-wrap">
    <?php if ( ! empty($video_mp4) || ! empty($video_ogg)) : ?>
      <video id="video-cover" preload="metadata" autoplay muted loop>
        <?php if ( ! empty($video_mp4)) : ?>
          <source src="<?php echo esc_attr($video_mp4); ?>" type="video/mp4">
        <?php endif; ?>

        <?php if ( ! empty($video_ogg)) : ?>
          <source src="<?php echo esc_attr($video_ogg); ?>" type="video/ogg">
        <?php endif; ?>
      </video>
    <?php endif; ?>
  </div>
  <div class="video-wrapper-overlay" <?php if ( ! empty($overlay_opacity)) : ?>style="opacity: <?php echo esc_attr($overlay_opacity); ?>"<?php endif; ?>></div>
</div>
<?php if ( ! empty($title) || ! empty($subtitle)) : ?>
  <div class="video-cover-title">
    <?php if ( ! empty($title)) : ?>
      <h1><?php echo esc_attr($title); ?></h1>
    <?php endif; ?>

    <?php if ( ! empty($subtitle)) : ?>
      <h2><?php echo esc_attr($subtitle); ?></h2>
    <?php endif; ?>

    <?php if ( ! empty($instance['filter'])) : ?>
      <div class="video-cover-filter">
        <?php include Inventor_Template_Loader::locate('widgets/filter-form'); ?>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>

<?php echo wp_kses($args['after_widget'], wp_kses_allowed_html('post')); ?>

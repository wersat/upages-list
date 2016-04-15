<?php
  /**
   * Created by PhpStorm.
   * User: jazzman
   * Date: 15.04.16
   * Time: 6:59
   */
  namespace Upages_Widgets;

  use Upages_Objects\Widget_Builder;

  /**
   * Class Widget_Video_Home_Cover
   * @package Upages_Widgets
   */
  class Widget_Video_Home_Cover extends Widget_Builder
  {

    /**
     * Widget_Video_Home_Cover constructor.
     */
    public function __construct()
    {
      $args           = [
        'label'       => __('Video Cover On Home', 'superlist'),
        'description' => __('Text boxes with icons.', 'superlist')
      ];
      $args['fields'] = [
        [
          'name' => __('Height', 'superlist'),
          'id'   => 'height',
          'type' => 'text',
          'std'  => '700px'
        ],
        [
          'name' => __('Preset Image URL', 'superlist'),
          'id'   => 'poster',
          'type' => 'image'
        ],
        [
          'name' => __('Video MP4', 'superlist'),
          'id'   => 'video_mp4',
          'type' => 'text'
        ],
        [
          'name' => __('Video OGG', 'superlist'),
          'id'   => 'video_ogg',
          'type' => 'text'
        ],
        [
          'name' => __('Video WebM', 'superlist'),
          'id'   => 'video_webm',
          'type' => 'text'
        ],
        [
          'name' => __('Input placeholder', 'superlist'),
          'id'   => 'input_placeholder',
          'type' => 'text'
        ]
      ];
      parent::__construct($args);
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
      $title             = get_bloginfo('name');
      $subtitle          = get_bloginfo('description');
      $height            = ! empty($instance['height']) ? $instance['height'] : '';
      $poster            = ! empty($instance['poster']) ? $instance['poster'] : '';
      $video_mp4         = ! empty($instance['video_mp4']) ? $instance['video_mp4'] : '';
      $video_ogg         = ! empty($instance['video_ogg']) ? $instance['video_ogg'] : '';
      $video_webm        = ! empty($instance['video_webm']) ? $instance['video_webm'] : '';
      $input_placeholder = ! empty($instance['input_placeholder']) ? $instance['input_placeholder'] : '';
      ?>
      <?php echo wp_kses($args['before_widget'], wp_kses_allowed_html('post')); ?>
      <div id="video-outer-wrap"
           class="video-cover"
           style="
           <?php if ( ! empty($poster)) : ?>background-image: url('<?php echo esc_attr( $poster )?>');<?php endif; ?>
           <?php if ( ! empty($height)) : ?>height: <?php echo esc_attr($height); ?>"<?php endif; ?>>
        <div id="video-wrap" class="hidden-md hidden-sm hidden-xs">
          <?php if ( ! empty($video_mp4) || ! empty($video_ogg)) : ?>
            <video id="video-cover" preload="metadata" autoplay muted loop>
              <?php if ( ! empty($video_mp4)) : ?>
                <source src="<?php echo esc_attr($video_mp4); ?>" type="video/mp4">
              <?php endif; ?>

              <?php if ( ! empty($video_ogg)) : ?>
                <source src="<?php echo esc_attr($video_ogg); ?>" type="video/ogg">
              <?php endif; ?>
              <?php if ( ! empty($video_webm)) : ?>
                <source src="<?php echo esc_attr($video_webm); ?>" type="video/webm">
              <?php endif; ?>
            </video>
          <?php endif; ?>
        </div>
        <div class="video-wrapper-overlay"></div>
      </div>
      <div class="video-cover-title">
        <?php if ( ! empty($title)) : ?>
          <h1><?= esc_attr($title); ?></h1>
        <?php endif; ?>

        <?php if ( ! empty($subtitle)) : ?>
          <h2><?= esc_attr($subtitle); ?></h2>
        <?php endif; ?>
        <div class="video-cover-filter">
          <?php do_action('inventor_before_filter_form', $args); ?>
          <form method="get"
                role="form"
                action="<?php echo esc_attr(\Inventor_Filter::get_filter_action()); ?>">
            <div class="row">
              <div class="col-xs-12">
                <div class="input-group input-group-lg">
                  <input type="text" name="filter-title"
                         placeholder="<?= $input_placeholder ?>"
                         class="form-control"
                         value="<?php echo ! empty($_GET['filter-title']) ? $_GET['filter-title'] : ''; ?>"
                         id="<?php echo esc_attr($args['widget_id']); ?>_title">
                  <div class="input-group-btn">
                    <button type="submit" class="btn">
                      <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <?php do_action('inventor_after_filter_form', $args); ?>
        </div>
      </div>
      <?php echo wp_kses($args['after_widget'], wp_kses_allowed_html('post'));
    }

  }

<?php
  /**
   * Created by PhpStorm.
   * User: jazzman
   * Date: 21.04.16
   * Time: 16:09
   */
  namespace Upages_Widgets;

  use Upages_Objects\Widget_Builder;

  class Widgets_Faq extends Widget_Builder
  {
    /**
     * Widgets_Faq constructor.
     *
     * @param string $args
     * @param array  $options
     */
    public function __construct()
    {
      $args             = [
        'label'       => __('FAQ New', 'inventor-faq'),
        'description' => __('Displays FAQ.', 'inventor-faq'),
      ];
      $args['fields']   = [
        [
          'name' => __('Title', 'inventor'),
          'id'   => 'title',
          'type' => 'text',
        ],
        [
          'name' => __('Description', 'inventor'),
          'id'   => 'description',
          'type' => 'textarea',
        ]
      ];
      $advanced_options = $this->add_advanced_options();
      foreach ($advanced_options as $option) {
        $args['fields'][] = $option;
      }
      parent::__construct($args);
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
      query_posts([
        'post_type'      => 'faq',
        'posts_per_page' => -1,
      ]);
      echo wp_kses($args['before_widget'], wp_kses_allowed_html('post')); ?>
      <div <?= $this->advanced_style($instance) ?>>
        <?= $this->advanced_widget_title_and_description($instance) ?>
        <?php
          if (have_posts()) { ?>
            <div class="faq">
              <?php while (have_posts()) {
                the_post(); ?>
                <div class="faq-item">
                  <div class="faq-item-question">
                    <h2><?php the_title(); ?></h2>
                  </div>
                  <div class="faq-item-answer">
                    <p><?php the_content(); ?></p>
                  </div>
                </div>
              <?php } ?>
            </div>
          <?php } else { ?>
            <div class="alert alert-warning">
              <?= __('No FAQ found.', 'inventor-faq'); ?>
            </div>
          <?php } ?>
      </div>
      <?= wp_kses($args['after_widget'], wp_kses_allowed_html('post'));
      wp_reset_query();
    }
  }

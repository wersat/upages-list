<?php
  /**
   * Created by PhpStorm.
   * User: jazzman
   * Date: 23.04.16
   * Time: 6:58
   */
  namespace Upages_Widgets;

  use Upages_Objects\Widget_Builder;

class Widget_Partners extends Widget_Builder
{
    /**
     * Widget_Partners constructor.
     *
     * @param string $args
     * @param array  $options
     */
    public function __construct()
    {
        $args             = [
        'label'       => __('Partners', 'inventor-partners'),
        'description' => __('Displays partners widget', 'inventor-partners'),
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
        ],
        [
          'name' => __('Count', 'inventor'),
          'id'   => 'count',
          'type' => 'text',
          'std'  => 3
        ],
        [
          'name' => __('IDs', 'inventor'),
          'id'   => 'ids',
          'type' => 'text',
          'desc' => __(
              'For specific partners please insert post ids, separated by comma. Example: 1,2,3',
              'inventor-partners'
          )
        ],
        [
          'name'   => __('Items per row', 'inventor-partners'),
          'id'     => 'per_row',
          'type'   => 'select',
          'std'    => 3,
          'fields' => [
            [
              'value' => 1,
              'name'  => '1'
            ],
            [
              'value' => 2,
              'name'  => '2'
            ],
            [
              'value' => 3,
              'name'  => '3'
            ],
            [
              'value' => 4,
              'name'  => '4'
            ],
            [
              'value' => 5,
              'name'  => '5'
            ],
            [
              'value' => 6,
              'name'  => '6'
            ],
          ]
        ],
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
        $query = [
        'post_type'      => 'partner',
        'posts_per_page' => ! empty($instance['count']) ? $instance['count'] : 3,
        ];
        if (! empty($instance['ids'])) {
            $ids               = explode(',', $instance['ids']);
            $query['post__in'] = $ids;
        }
        query_posts($query);

        echo wp_kses($args['before_widget'], wp_kses_allowed_html('post')); ?>
      <div <?php echo $this->advanced_style($instance) ?>>
        <?= $this->advanced_widget_title_and_description($instance) ?>

        <?php
        if (have_posts()) : ?>
            <div class="items-per-row-<?php echo esc_attr($instance['per_row']); ?>">
                <?php if ($instance['per_row'] != 1) : ?>
              <div class="partners-row">
                <?php endif; ?>

                <?php $index = 0; ?>
                <?php while (have_posts()) :
                    the_post(); ?>
                <div class="partners-container">
                    <?php if (has_post_thumbnail()) : ?>
                    <div class="partner-featured-image">
                      <a href="<?php echo get_post_meta(get_the_ID(), 'partner_url', true); ?>">
                        <?php the_post_thumbnail(); ?>
                      </a>
                    </div>
                    <?php else : ?>
                    <div class="alert alert-warning">
                        <?php echo __('Featured image not found.', 'inventor-partners'); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if (($index + 1) % $instance['per_row'] == 0 && $instance['per_row'] != 1 && \Inventor_Query::loop_has_next()) : ?>
              </div>
              <div class="partners-row">
                <?php endif; ?>
                <?php ++$index; ?>
                <?php endwhile; ?>
                <?php if ($instance['per_row'] != 1) : ?>
              </div>
                <?php endif; ?>
            </div>
            <?php else : ?>
            <div class="alert alert-warning">
                <?php echo __('No partners found.', 'inventor-partners'); ?>
            </div>
            <?php endif; ?>
      </div>
        <?php echo wp_kses($args['after_widget'], wp_kses_allowed_html('post'));
        wp_reset_query();
    }

}

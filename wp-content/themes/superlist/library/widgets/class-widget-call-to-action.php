<?php
  /**
   * Created by PhpStorm.
   * User: jazzman
   * Date: 15.04.16
   * Time: 5:48
   */
  namespace Upages_Widgets;

  use Upages_Objects\Widget_Builder;

class Widget_Call_To_Action extends Widget_Builder
{
    /**
     * @param $args
     */
    public function __construct()
    {
        $args             = [
        'label'       => __('Call to action', 'superlist'),
        'description' => __('Call to action widget.', 'superlist'),
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
          'name' => __('Text', 'superlist'),
          'id'   => 'text',
          'type' => 'textarea',
        ],
        [
          'name' => __('Button Text', 'superlist'),
          'id'   => 'button_text',
          'type' => 'text',
        ],
        [
          'name'   => __('Button Link', 'superlist'),
          'id'     => 'button_link',
          'type'   => 'select',
          'fields' => $this->getPageList()
        ]
        ];
        $advanced_options = $this->add_advanced_options();
        foreach ($advanced_options as $option) {
            $args['fields'][] = $option;
        }
        parent::__construct($args);
    }

    public function widget($args, $instance)
    {
        echo wp_kses($args['before_widget'], wp_kses_allowed_html('post')); ?>
      <div <?php echo $this->advanced_style($instance) ?>>
        <?= $this->advanced_widget_title_and_description($instance) ?>
        <div class="row">
          <div class="col-sm-9">
            <?php echo wp_kses($instance['text'], wp_kses_allowed_html('post')); ?>
          </div>
          <div class="col-sm-3">
            <a href="<?php echo wp_kses($instance['button_link'], wp_kses_allowed_html('post')); ?>"
               class="btn btn-primary">
                <?php echo esc_attr($instance['button_text']); ?>
            </a>
          </div>
        </div>
      </div>
        <?php echo wp_kses($args['after_widget'], wp_kses_allowed_html('post'));
    }

}

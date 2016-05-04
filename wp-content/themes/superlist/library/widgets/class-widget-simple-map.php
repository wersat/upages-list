<?php
  /**
   * Created by PhpStorm.
   * User: jazzman
   * Date: 15.04.16
   * Time: 6:18
   */
  namespace Upages_Widgets;

  use Upages_Objects\Widget_Builder;

  /**
   * Class Widget_Simple_Map
   *
   * @package Upages_Widgets
   */
class Widget_Simple_Map extends Widget_Builder
{

    /**
     * @param $args
     */
    public function __construct()
    {
        $args             = [
        'label'       => __('Simple Map', 'superlist'),
        'description' => __('Displays 1 place in the map.', 'superlist'),
        ];
        $args['fields']   = [
        [
          'name' => __('Latitude', 'superlist'),
          'id'   => 'latitude',
          'type' => 'text',
          'std'  => 40.772798
        ],
        [
          'name' => __('Longitude', 'superlist'),
          'id'   => 'longitude',
          'type' => 'text',
          'std'  => -73.968653
        ],
        [
          'name' => __('Zoom', 'superlist'),
          'id'   => 'zoom',
          'type' => 'number',
          'max'  => 25,
          'min'  => 0,
          'std'  => 16
        ],
        [
          'name' => __('Height in pixels', 'superlist'),
          'id'   => 'height',
          'type' => 'number',
          'min'  => 0,
          'step' => 50,
          'std'  => 350
        ],
        [
          'name'   => __('Style', 'superlist'),
          'id'     => 'style',
          'type'   => 'select',
          'fields' => $this->google_map_styles()
        ]
        ];
        $advanced_options = $this->add_advanced_options();
        foreach ($advanced_options as $option) {
            $args['fields'][] = $option;
        }
        parent::__construct($args);
    }

    /**
     * @return array
     */
    public function google_map_styles()
    {
        $maps_list = [];
        $maps      = \Inventor_Google_Map_Styles::styles();
        foreach ((array)$maps as $map) {
            $maps_list[] = [
            'name'  => $map['title'],
            'value' => $map['slug']
            ];
        }

        return $maps_list;
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        echo wp_kses($args['before_widget'], wp_kses_allowed_html('post')); ?>
      <div <?php echo $this->advanced_style($instance) ?>>
        <?php $style = ! empty($instance['style']) ? $instance['style'] : ''; ?>
        <?php $style_slug = ( ! empty($_GET['map-style'])) ? esc_attr($_GET['map-style'])
          : $style; // Input var okay; sanitization okay.
        ?>
        <div class="map-wrapper">
          <div class="map" id="simple-map" style="height: <?php echo esc_attr($instance['height']); ?>px"
               data-transparent-marker-image="<?php echo esc_attr(get_template_directory_uri()); ?>/assets/img/transparent-marker-image.png"
               data-latitude="<?php echo esc_attr($instance['latitude']); ?>"
               data-longitude="<?php echo esc_attr($instance['longitude']); ?>"
               data-zoom="<?php echo esc_attr($instance['zoom']); ?>"
                <?php if (class_exists('Inventor_Google_Map_Styles')) : ?>data-styles='<?php echo esc_attr(\Inventor_Google_Map_Styles::get_style($style_slug)); ?>'<?php 
                endif; ?>
               data-geolocation='false'>
          </div>
        </div>
      </div>
        <?php echo wp_kses($args['after_widget'], wp_kses_allowed_html('post'));
    }

}

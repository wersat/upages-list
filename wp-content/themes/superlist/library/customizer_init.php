<?php
    /**
     * Created by PhpStorm.
     * User: jazzman
     * Date: 04.05.16
     * Time: 0:30
     */
    use Upages_Objects\Customizer_Library;

    $section             = 'logo_new_test';
    $sections[]          = [
        'id'       => $section,
        'title'    => __('Logo Example', 'demo'),
        'priority' => '30'
    ];
    $options['logo_new_test']     = [
        'id'      => 'logo_new_test',
        'label'   => __('Logo Example', 'demo'),
        'section' => $section,
        'type'    => 'upload',
        'default' => '',
    ];
    $options['sections'] = $sections;
    $test_custom         = new Customizer_Library($options);

<?php
    /**
     * Created by PhpStorm.
     * User: jazzman
     * Date: 04.05.16
     * Time: 0:30
     */
    use Upages_Objects\Customizer_Library;

    $section                                   = 'logo_new_test';
    $sections[]                                = [
        'id'       => 'inventor_currencies[0]',
        'title'    => __('Inventor Currency', 'inventor'),
        'priority' => 1,
    ];
    $options['inventor_currencies[0][symbol]'] = [
        'id'      => 'inventor_currencies[0][symbol]',
        'label'   => __('Currency Symbol', 'inventor'),
        'section' => 'inventor_currencies[0]',
        'type'    => 'text',
        'default' => '$',
    ];
    $options['sections']                       = $sections;
    $test_custom                               = new Customizer_Library($options);

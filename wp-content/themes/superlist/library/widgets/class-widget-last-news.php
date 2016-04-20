<?php
    /**
     * Created by PhpStorm.
     * User: jazzman
     * Date: 15.04.16
     * Time: 18:59
     */
    namespace Upages_Widgets;
    
    use Upages_Objects\Widget_Builder;

    if ( ! defined('ABSPATH')) {
        exit;
    }
    class Widget_Last_News extends Widget_Builder
    {
        public $listing_categories = [];

        public function __construct()
        {
            $this->setListingCategories();
            $args             = [
                'label'       => __('Listings Last News', 'superlist'),
                'description' => __('Displays Last News.', 'superlist'),
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
                    'type' => 'number',
                    'std'  => 4
                ],
                [
                    'name' => __('IDs', 'inventor'),
                    'id'   => 'ids',
                    'type' => 'text',
                    'desc' => __('For specific listings please insert post ids, separated by comma. Example: 1,2,3',
                        'inventor')
                ],
                [
                    'name'   => __('Items per row', 'inventor'),
                    'id'     => 'per_row',
                    'type'   => 'select',
                    'fields' => [
                        [
                            'name'  => 1,
                            'value' => 1
                        ],
                        [
                            'name'  => 2,
                            'value' => 2
                        ],
                        [
                            'name'  => 3,
                            'value' => 3
                        ],
                        [
                            'name'  => 4,
                            'value' => 4
                        ],
                        [
                            'name'  => 5,
                            'value' => 5
                        ],
                        [
                            'name'  => 6,
                            'value' => 6
                        ]
                    ]
                ],
                [
                    'name'   => __('Order', 'inventor'),
                    'id'     => 'order',
                    'type'   => 'select',
                    'std'    => 'on',
                    'fields' => [
                        [
                            'name'  => __('Default', 'inventor'),
                            'value' => 'on'
                        ],
                        [
                            'name'  => __('Random', 'inventor'),
                            'value' => 'rand'
                        ],
                        [
                            'name'  => __('IDs', 'inventor'),
                            'value' => 'ids'
                        ]
                    ]
                ],
                [
                    'name'   => __('Choose attribute', 'inventor'),
                    'id'     => 'attribute',
                    'type'   => 'select',
                    'std'    => 'on',
                    'fields' => [
                        [
                            'name'  => __('None', 'inventor'),
                            'value' => 'on'
                        ],
                        [
                            'name'  => __('Featured only', 'inventor'),
                            'value' => 'featured'
                        ],
                        [
                            'name'  => __('Reduced only', 'inventor'),
                            'value' => 'reduced'
                        ]
                    ]
                ],
                [
                    'name'   => __('Display as', 'inventor'),
                    'id'     => 'display',
                    'type'   => 'select',
                    'std'    => 'small',
                    'fields' => [
                        [
                            'name'  => __('Small', 'inventor'),
                            'value' => 'small'
                        ],
                        [
                            'name'  => __('Box', 'inventor'),
                            'value' => 'box'
                        ],
                        [
                            'name'  => __('Row', 'inventor'),
                            'value' => 'row'
                        ],
                        [
                            'name'  => __('Masonry', 'inventor'),
                            'value' => 'masonry'
                        ]
                    ]
                ],
                [
                    'name'     => __('Listing Categories', 'inventor'),
                    'id'       => 'listing_categories',
                    'type'     => 'select',
                    'multiple' => true,
                    'fields'   => [
                        [
                            'name'  => __('Small', 'inventor'),
                            'value' => 'small'
                        ],
                        [
                            'name'  => __('Box', 'inventor'),
                            'value' => 'box'
                        ],
                        [
                            'name'  => __('Row', 'inventor'),
                            'value' => 'row'
                        ],
                        [
                            'name'  => __('Masonry', 'inventor'),
                            'value' => 'masonry'
                        ]
                    ]
                ]
            ];
            $advanced_options = $this->add_advanced_options();
            foreach ($advanced_options as $option) {
                $args['fields'][] = $option;
            }
            parent::__construct($args);
        }

        /**
         * @param array $listing_categories
         */
        public function setListingCategories()
        {
            $terms = get_terms('listing_categories', ['hide_empty' => false]);
            //var_dump($terms);
            if(is_array($terms)){
                foreach($terms as $key => $val){
                    $this->listing_categories[] = [

                    ];
                }

            }
        }

        public function widget($args, $instance)
        {
            echo $instance['attribute'];
        }

    }

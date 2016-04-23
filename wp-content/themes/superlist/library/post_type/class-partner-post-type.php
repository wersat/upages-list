<?php
    /**
     * Created by PhpStorm.
     * User: jazzman
     * Date: 23.04.16
     * Time: 7:21
     */
    namespace Upages_Post_Type;
    
    use Upages_Objects\Custom_Post_Type;

    /**
     * Class Partner_Post_Type
     * @package Upages_Post_Type
     */
    class Partner_Post_Type
    {
        /**
         * @type
         */
        public $post_type;
        /**
         * @type string
         */
        public $post_type_name = 'Partner';
        /**
         * @type string
         */
        public $partner_prefix = 'partner_';
        /**
         * @type string
         */
        public $post_type_slug;

        /**
         * @type array
         */
        public $post_type_option
            = [
                'supports'     => ['title', 'thumbnail'],
                'public'        => false,
                'show_ui'       => true,
                'show_in_menu'  => 'inventor',
                'menu_icon'     => 'dashicons-businessman',
                'menu_position' => 55,
            ];

        /**
         * Partner_Post_Type constructor.
         */
        public function __construct()
        {
            $this->post_type_slug = sanitize_title($this->post_type_name);
            $this->setPostType();
            add_filter('cmb2_init', [$this, 'fields']);
        }

        /**
         * @param mixed $post_type
         */
        public function setPostType()
        {
            $this->post_type = new Custom_Post_Type([
                'post_type_name' => $this->post_type_slug,
                'singular'       => $this->post_type_name,
                'plural'         => $this->post_type_name,
                'slug'           => $this->post_type_slug
            ], $this->post_type_option);
        }

        /**
         *
         */
        public function fields()
        {
            $cmb = new_cmb2_box([
                'id'           => $this->partner_prefix . 'url',
                'title'        => __('URL', 'inventor-partners'),
                'object_types' => [$this->post_type_slug],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $cmb->add_field([
                'name' => __('URL', 'inventor-partners'),
                'id'   => $this->partner_prefix . 'url',
                'type' => 'text_url',
            ]);
        }
    }

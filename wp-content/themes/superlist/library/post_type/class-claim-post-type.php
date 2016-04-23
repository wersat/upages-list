<?php
    /**
     * Created by PhpStorm.
     * User: jazzman
     * Date: 21.04.16
     * Time: 5:02
     */
    namespace Upages_Post_Type;
    
    use Upages_Objects\Custom_Post_Type;

    class Claim_Post_Type
    {
        public $post_type;
        public $post_type_name = 'Claim Test';

        public $post_type_option
            = [
                'supports' => ['author'],
                'show_in_menu' => 'inventor'
            ];
        public $metabox;
        public $metabox_template;

        public function __construct()
        {
            $this->setPostType();
            $this->setMetaboxTemplate();
            add_action('after_setup_theme', [$this, 'setMetabox']);
        }

        /**
         * @param mixed $post_type
         */
        public function setPostType()
        {
            $this->post_type = new Custom_Post_Type([
                'post_type_name' => sanitize_title($this->post_type_name),
                'singular'       => $this->post_type_name,
                'plural'         => $this->post_type_name,
                'slug'           => sanitize_title($this->post_type_name)
            ], $this->post_type_option);
        }

        /**
         * @param mixed $metabox
         */
        public function setMetabox()
        {
            $this->metabox = new \VP_Metabox([
                'id'          => sanitize_title($this->post_type_name),
                'types'       => [sanitize_title($this->post_type_name)],
                'title'       => __('VP Metabox', 'vp_textdomain'),
                'priority'    => 'high',
                'is_dev_mode' => true,
                'template'    => $this->metabox_template
            ]);
        }

        /**
         * @param mixed $metabox_template
         *
         * @return Claim_Post_Type
         */
        public function setMetaboxTemplate()
        {
            $this->metabox_template = [
                [
                    'type'        => 'color',
                    'name'        => 'cl_1',
                    'label'       => __('Color 1', 'vp_textdomain'),
                    'description' => __('Color Picker, you can set the default color.', 'vp_textdomain'),
                    'default'     => 'rgba(255,0,0,0.5)',
                    'format'      => 'rgba',
                ],
            ];
        }
    }

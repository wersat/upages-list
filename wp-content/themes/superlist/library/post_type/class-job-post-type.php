<?php
    /**
     * Created by PhpStorm.
     * User: jazzman
     * Date: 21.04.16
     * Time: 5:02
     */
    namespace Upages_Post_Type;
    
    use Upages_Objects\Custom_Post_Type;

    class Job_Post_Type
    {
        public $post_type;
        public $post_type_name = 'Job Test';

        public $post_type_option
            = [
                'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
                'show_ui'      => true,
                'show_in_menu' => 'title',
                'has_archive'       => true,
                'name_test' => 'name_test'
            ];

        public function __construct()
        {
            $this->setPostType();
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
    }

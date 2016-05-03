<?php
    namespace Upages_Post_Type;
    
    use Upages_Objects\Custom_Post_Type;

    /**
     * Class Faq_Post_Type
     *
     * @package Upages_Post_Type
     */
class Faq_Post_Type
{
    /**
         * @type
         */
    public $post_type;
    /**
         * @type string
         */
    public $post_type_name = 'FAQ';

    /**
         * @type array
         */
    public $post_type_option
    = [
        'supports'     => ['title', 'editor'],
        'show_in_menu' => 'inventor',
        'name_test' => 'name_test'
    ];

    /**
         * Faq_Post_Type constructor.
         */
    public function __construct()
    {
        $this->setPostType();
    }

    /**
         *
         */
    public function setPostType()
    {
        $this->post_type = new Custom_Post_Type(
            [
            'post_type_name' => sanitize_title($this->post_type_name),
            'singular'       => $this->post_type_name,
            'plural'         => $this->post_type_name,
            'slug'           => sanitize_title($this->post_type_name)
            ], $this->post_type_option
        );
    }
}

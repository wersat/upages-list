<?php
    /**
     * Created by PhpStorm.
     * User: jazzman
     * Date: 21.04.16
     * Time: 5:02
     */
    namespace Upages_Post_Type;
    
    use Upages_Objects\Custom_Post_Type;

class Mail_Templates_Post_Type
{
    public $post_type;
    public $post_type_name = 'Mail Templates';
    /**
         * @type string
         */
    public $post_type_slug;

    public $post_type_option
    = [
        'supports'            => ['title', 'editor', 'author'],
        'show_in_menu'        => 'inventor',
        'exclude_from_search' => true,
        'has_archive'         => false,
        'show_ui'             => true,
    ];

    public function __construct()
    {
        $this->post_type_slug = sanitize_title($this->post_type_name);
        $this->post_type_prefix = sanitize_title($this->post_type_name).'_';
        $this->setPostType();
        add_filter('cmb2_init', [$this, 'fields']);
    }

    /**
         * @param mixed $post_type
         */
    public function setPostType()
    {
        $this->post_type = new Custom_Post_Type(
            [
            'post_type_name' => $this->post_type_slug,
            'singular'       => $this->post_type_name,
            'plural'         => $this->post_type_name,
            'slug'           => $this->post_type_slug
            ], $this->post_type_option
        );
        $this->post_type->columns(
            [
            'cb'         => '<input type="checkbox" />',
            'title'      => __('Title', 'inventor-mail-templates'),
            'action' => __('Action', 'inventor-mail-templates'),
            'author' => __('Author', 'inventor-mail-templates'),
            'date'   => __('Date and status', 'inventor-mail-templates'),
            ]
        );
        $this->post_type->sortable(
            [
            'title'      => ['title', true],
            'action'       => ['action', true],
            'author'   => ['author', true],
            'date'      => ['date', true]
            ]
        );
        $this->post_type->populate_column(
            'action', function ($column, $post) {
                $action       = get_post_meta(get_the_ID(), $this->post_type_prefix . 'action', true);
                $mail_actions = apply_filters('inventor_mail_actions_choices', []);
                echo (empty($mail_actions[$action])) ? $action : $mail_actions[$action];
            }
        );
    }
    public function fields()
    {
        $cmb = new_cmb2_box(
            [
            'id'           => $this->post_type_prefix . 'general',
            'title'        => __('General', 'inventor-mail-templates'),
            'object_types' => [$this->post_type_slug],
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true,
            ]
        );
        $action_choices = apply_filters('inventor_mail_actions_choices', []);
        $cmb->add_field(
            [
            'name'    => __('Action', 'inventor-mail-templates'),
            'id'      => $this->post_type_prefix . 'action',
            'type'    => 'select',
            'options' => $action_choices,
            ]
        );
    }
}

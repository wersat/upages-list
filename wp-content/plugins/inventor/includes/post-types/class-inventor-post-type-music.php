<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Post_Type_Music.
     *
     * @class  Inventor_Post_Type_Music
     * @author Pragmatic Mates
     */
class Inventor_Post_Type_Music
{
    /**
         * Initialize custom post type.
         */
    public static function init()
    {
        add_action('init', [__CLASS__, 'definition']);
    }

    /**
         * Custom post type definition.
         */
    public static function definition()
    {
        $labels = [
            'name'               => __('Musics', 'inventor'),
            'singular_name'      => __('Music', 'inventor'),
            'add_new'            => __('Add New Music', 'inventor'),
            'add_new_item'       => __('Add New Music', 'inventor'),
            'edit_item'          => __('Edit Music', 'inventor'),
            'new_item'           => __('New Music', 'inventor'),
            'all_items'          => __('Musics', 'inventor'),
            'view_item'          => __('View Music', 'inventor'),
            'search_items'       => __('Search Music', 'inventor'),
            'not_found'          => __('No Musics found', 'inventor'),
            'not_found_in_trash' => __('No Musics Found in Trash', 'inventor'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Musics', 'inventor'),
        ];
        register_post_type(
            'music', [
                'labels'       => $labels,
                'show_in_menu' => 'listings',
                'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
                'has_archive'  => true,
                'rewrite'      => ['slug' => _x('musics', 'URL slug', 'inventor')],
                'public'       => true,
                'show_ui'      => true,
                'categories'   => [],
            ]
        );
    }

    /**
         * Defines custom fields.
     *
         * @return array
         */
    public static function fields()
    {
        Inventor_Post_Types::add_metabox('music', ['general', 'banner', 'gallery', 'price']);
    }
}

    Inventor_Post_Type_Music::init();

<?php
    /**
     * Here is the place to put your own defined function that serve as
     * datasource to field with multiple options.
     */
    function vp_get_categories()
    {
        $wp_cat = get_categories(['hide_empty' => 0]);
        $result = [];
        foreach ($wp_cat as $cat) {
            $result[] = ['value' => $cat->cat_ID, 'label' => $cat->name];
        }

        return $result;
    }

    function vp_get_users()
    {
        $wp_users = VP_WP_User::get_users();
        $result   = [];
        foreach ($wp_users as $user) {
            $result[] = ['value' => $user['id'], 'label' => $user['display_name']];
        }

        return $result;
    }

    function vp_get_posts()
    {
        $wp_posts = get_posts([
            'posts_per_page' => -1,
        ]);
        $result   = [];
        foreach ($wp_posts as $post) {
            $result[] = ['value' => $post->ID, 'label' => $post->post_title];
        }

        return $result;
    }

    function vp_get_pages()
    {
        $wp_pages = get_pages();
        $result   = [];
        foreach ($wp_pages as $page) {
            $result[] = ['value' => $page->ID, 'label' => $page->post_title];
        }

        return $result;
    }

    function vp_get_tags()
    {
        $wp_tags = get_tags(['hide_empty' => 0]);
        $result  = [];
        foreach ($wp_tags as $tag) {
            $result[] = ['value' => $tag->term_id, 'label' => $tag->name];
        }

        return $result;
    }

    function vp_get_roles()
    {
        $result         = [];
        $editable_roles = VP_WP_User::get_editable_roles();
        foreach ($editable_roles as $key => $role) {
            $result[] = ['value' => $key, 'label' => $role['name']];
        }

        return $result;
    }

    function vp_get_gwf_family()
    {
        $fonts = file_get_contents(dirname(__FILE__) . '/gwf.json');
        $fonts = json_decode($fonts);
        $fonts = array_keys(get_object_vars($fonts));
        foreach ($fonts as $font) {
            $result[] = ['value' => $font, 'label' => $font];
        }

        return $result;
    }

    VP_Security::instance()
               ->whitelist_function('vp_get_gwf_weight');
    function vp_get_gwf_weight($face)
    {
        if (empty($face)) {
            return [];
        }
        $fonts = file_get_contents(dirname(__FILE__) . '/gwf.json');
        $fonts = json_decode($fonts);
        if ( ! property_exists($fonts, $face)) {
            return;
        }
        $weights = $fonts->{$face}->weights;
        foreach ($weights as $weight) {
            $result[] = ['value' => $weight, 'label' => $weight];
        }

        return $result;
    }

    VP_Security::instance()
               ->whitelist_function('vp_get_gwf_style');
    function vp_get_gwf_style($face)
    {
        if (empty($face)) {
            return [];
        }
        $fonts = file_get_contents(dirname(__FILE__) . '/gwf.json');
        $fonts = json_decode($fonts);
        if ( ! property_exists($fonts, $face)) {
            return;
        }
        $styles = $fonts->{$face}->styles;
        foreach ($styles as $style) {
            $result[] = ['value' => $style, 'label' => $style];
        }

        return $result;
    }

    VP_Security::instance()
               ->whitelist_function('vp_get_gwf_subset');
    function vp_get_gwf_subset($face)
    {
        if (empty($face)) {
            return [];
        }
        $fonts = file_get_contents(dirname(__FILE__) . '/gwf.json');
        $fonts = json_decode($fonts);
        if ( ! property_exists($fonts, $face)) {
            return;
        }
        $subsets = $fonts->{$face}->subsets;
        foreach ($subsets as $subset) {
            $result[] = ['value' => $subset, 'label' => $subset];
        }

        return $result;
    }

    function vp_get_social_medias()
    {
        $socmeds = [
            ['value' => 'blogger', 'label' => 'Blogger'],
            ['value' => 'delicious', 'label' => 'Delicious'],
            ['value' => 'deviantart', 'label' => 'DeviantArt'],
            ['value' => 'digg', 'label' => 'Digg'],
            ['value' => 'dribbble', 'label' => 'Dribbble'],
            ['value' => 'email', 'label' => 'Email'],
            ['value' => 'facebook', 'label' => 'Facebook'],
            ['value' => 'flickr', 'label' => 'Flickr'],
            ['value' => 'forrst', 'label' => 'Forrst'],
            ['value' => 'foursquare', 'label' => 'Foursquare'],
            ['value' => 'github', 'label' => 'Github'],
            ['value' => 'googleplus', 'label' => 'Google+'],
            ['value' => 'instagram', 'label' => 'Instagram'],
            ['value' => 'lastfm', 'label' => 'Last.FM'],
            ['value' => 'linkedin', 'label' => 'LinkedIn'],
            ['value' => 'myspace', 'label' => 'MySpace'],
            ['value' => 'pinterest', 'label' => 'Pinterest'],
            ['value' => 'reddit', 'label' => 'Reddit'],
            ['value' => 'rss', 'label' => 'RSS'],
            ['value' => 'soundcloud', 'label' => 'SoundCloud'],
            ['value' => 'stumbleupon', 'label' => 'StumbleUpon'],
            ['value' => 'tumblr', 'label' => 'Tumblr'],
            ['value' => 'twitter', 'label' => 'Twitter'],
            ['value' => 'vimeo', 'label' => 'Vimeo'],
            ['value' => 'wordpress', 'label' => 'WordPress'],
            ['value' => 'yahoo', 'label' => 'Yahoo!'],
            ['value' => 'youtube', 'label' => 'Youtube'],
        ];

        return $socmeds;
    }

    function vp_get_fontawesome_icons()
    {
        // scrape list of icons from fontawesome css
        if (false === ($icons = get_transient('vp_fontawesome_icons'))) {
            $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s*{\s*content/';
            $subject = file_get_contents(VP_DIR . '/public/css/vendor/font-awesome.min.css');
            preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
            $icons = [];
            foreach ($matches as $match) {
                $icons[] = ['value' => $match[1], 'label' => $match[1]];
            }
            set_transient('vp_fontawesome_icons', $icons, 60 * 60 * 24);
        }

        return $icons;
    }

    VP_Security::instance()
               ->whitelist_function('vp_dep_boolean');
    function vp_dep_boolean($value)
    {
        $args   = func_get_args();
        $result = true;
        foreach ($args as $val) {
            $result = ($result and ! empty($val));
        }

        return $result;
    }

    /*
     * EOF
     */

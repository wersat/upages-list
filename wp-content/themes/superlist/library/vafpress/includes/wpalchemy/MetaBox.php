<?php
/**
 * @author         Dimas Begunoff
 * @copyright      Copyright (c) 2009, Dimas Begunoff, http://farinspace.com
 * @license        http://en.wikipedia.org/wiki/MIT_License The MIT License
 *
 * @version        1.5.2
 *
 * @link           http://github.com/farinspace/wpalchemy
 * @link           http://farinspace.com
 */
/**
 * This is modified version so that WPAlchemy supports nested repeatable group
 * Vafpress (http://vafpress.com)
 * 2013.
 */
    // todo: perhaps move _global_head and _global_foot locally, when first run
    // define a constant to prevent other instances from running again ...
    add_action('admin_head', ['WPAlchemy_MetaBox', '_global_head']);
    add_action('admin_footer', ['WPAlchemy_MetaBox', '_global_foot']);
    define('WPALCHEMY_MODE_ARRAY', 'array');
    define('WPALCHEMY_MODE_EXTRACT', 'extract');
    define('WPALCHEMY_FIELD_HINT_TEXT', 'text');
    define('WPALCHEMY_FIELD_HINT_TEXTAREA', 'textarea');
    define('WPALCHEMY_FIELD_HINT_CHECKBOX', 'checkbox');
    define('WPALCHEMY_FIELD_HINT_CHECKBOX_MULTI', 'checkbox_multi');
    define('WPALCHEMY_FIELD_HINT_RADIO', 'radio');
    define('WPALCHEMY_FIELD_HINT_SELECT', 'select');
    define('WPALCHEMY_FIELD_HINT_SELECT_MULTI', 'select_multi');
    // depreciated, use WPALCHEMY_FIELD_HINT_SELECT_MULTI instead
    define('WPALCHEMY_FIELD_HINT_SELECT_MULTIPLE', 'select_multiple');
    define('WPALCHEMY_LOCK_TOP', 'top');
    define('WPALCHEMY_LOCK_BOTTOM', 'bottom');
    define('WPALCHEMY_LOCK_BEFORE_POST_TITLE', 'before_post_title');
    define('WPALCHEMY_LOCK_AFTER_POST_TITLE', 'after_post_title');
    define('WPALCHEMY_VIEW_START_OPENED', 'opened');
    define('WPALCHEMY_VIEW_START_CLOSED', 'closed');
    define('WPALCHEMY_VIEW_ALWAYS_OPENED', 'always_opened');

    class WPAlchemy_MetaBox
    {
        /*
         * User defined identifier for the meta box, prefix with an underscore to
         * prevent option(s) form showing up in the custom fields meta box, this
         * option should be used when instantiating the class.
         * @since     1.0
         * @access    public
         * @var        string required
         */
        public $id;

        /*
         * Used to set the title of the meta box, this option should be used when
         * instantiating the class.
         * @since      1.0
         * @access     public
         * @var        string required
         * @see        $hide_title
         */
        public $title = 'Custom Meta';

        /*
         * Used to set the meta box content, the contents of your meta box should be
         * defined within this file, this option should be used when instantiating
         * the class.
         * @since     1.0
         * @access    public
         * @var        string required
         */
        public $template;

        /*
         * Used to set the post types that the meta box can appear in, this option
         * should be used when instantiating the class.
         * @since     1.0
         * @access    public
         * @var        array
         */
        public $types;

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $context = 'normal';

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $priority = 'high';

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $autosave = true;

        /*
         * Used to set how the class does its data storage, data will be stored as
         * an associative array in a single meta entry in the wp_postmeta table or
         * data can be set and individual entries in the wp_postmeta table, the
         * following constants should be used when setting this option,
         * WPALCHEMY_MODE_ARRAY (default) and WPALCHEMY_MODE_EXTRACT, this option
         * should be used when instantiating the class.
         * @since     1.2
         * @access    public
         * @var        string
         */
        public $mode = WPALCHEMY_MODE_ARRAY;

        /*
         * When the mode option is set to WPALCHEMY_MODE_EXTRACT, you have to take
         * care to avoid name collisions with other meta entries. Use this option to
         * automatically add a prefix to your variables, this option should be used
         * when instantiating the class.
         * @since     1.2
         * @access    public
         * @var        array
         */
        public $prefix;

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $exclude_template;

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $exclude_category_id;

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $exclude_category;

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $exclude_tag_id;

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $exclude_tag;

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $exclude_post_id;

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $include_template;

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $include_category_id;

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $include_category;

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $include_tag_id;

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $include_tag;

        /*
         * @since     1.0
         * @access    public
         * @var        bool
         */
        public $include_post_id;

        /*
         * Callback used on the WordPress "admin_init" action, the main benefit is
         * that this callback is executed only when the meta box is present, this
         * option should be used when instantiating the class.
         * @since     1.3.4
         * @access    public
         * @var        string|array optional
         */
        public $init_action;

        /*
         * Callback used to override when the meta box gets displayed, must return
         * true or false to determine if the meta box should or should not be
         * displayed, this option should be used when instantiating the class.
         * @since      1.3
         * @access     public
         * @var        string|array optional
         * @param    array $post_id first variable passed to the callback function
         * @see        can_output()
         */
        public $output_filter;

        /*
         * Callback used to override or insert meta data before saving, you can halt
         * saving by passing back FALSE (return FALSE), this option should be used
         * when instantiating the class.
         * @since      1.3
         * @access     public
         * @var        string|array optional
         * @param    array  $meta    meta box data, first variable passed to the callback function
         * @param    string $post_id second variable passed to the callback function
         * @see        $save_action, add_filter()
         */
        public $save_filter;

        /*
         * Callback used to execute custom code after saving, this option should be
         * used when instantiating the class.
         * @since      1.3
         * @access     public
         * @var        string|array optional
         * @param    array  $meta    meta box data, first variable passed to the callback function
         * @param    string $post_id second variable passed to the callback function
         * @see        $save_filter, add_filter()
         */
        public $save_action;

        /*
         * Callback used to override or insert STYLE or SCRIPT tags into the head,
         * this option should be used when instantiating the class.
         * @since      1.3
         * @access     public
         * @var        string|array optional
         * @param    array $content current head content, first variable passed to the callback function
         * @see        $head_action, add_filter()
         */
        public $head_filter;

        /*
         * Callback used to insert STYLE or SCRIPT tags into the head,
         * this option should be used when instantiating the class.
         * @since      1.3
         * @access     public
         * @var        string|array optional
         * @see        $head_filter, add_action()
         */
        public $head_action;

        /*
         * Callback used to override or insert SCRIPT tags into the footer, this
         * option should be used when instantiating the class.
         * @since      1.3
         * @access     public
         * @var        string|array optional
         * @param    array $content current foot content, first variable passed to the callback function
         * @see        $foot_action, add_filter()
         */
        public $foot_filter;

        /*
         * Callback used to insert SCRIPT tags into the footer, this option should
         * be used when instantiating the class.
         * @since      1.3
         * @access     public
         * @var        string|array optional
         * @see        $foot_filter, add_action()
         */
        public $foot_action;

        /*
         * Used to hide the default content editor in a page or post, this option
         * should be used when instantiating the class.
         * @since     1.3
         * @access    public
         * @var        bool optional
         */
        public $hide_editor = false;

        /*
         * Used in conjunction with the "hide_editor" option, prevents the media
         * buttons from also being hidden.
         * @since     1.5
         * @access    public
         * @var        bool optional
         */
        public $use_media_buttons = false;

        /*
         * Used to hide the meta box title, this option should be used when
         * instantiating the class.
         * @since      1.3
         * @access     public
         * @var        bool optional
         * @see        $title
         */
        public $hide_title = false;

        /*
         * Used to lock a meta box in place, possible values are: top, bottom,
         * before_post_title, after_post_title, this option should be used when
         * instantiating the class.
         * @since         1.3.3
         * @access        public
         * @var            string optional possible values are: top, bottom, before_post_title, after_post_title
         */
        public $lock;

        /*
         * Used to lock a meta box at top (below the default content editor), this
         * option should be used when instantiating the class.
         * @deprecated     deprecated since version 1.3.3
         * @since          1.3
         * @access         public
         * @var            bool optional
         * @see            $lock
         */
        public $lock_on_top = false;

        /*
         * Used to lock a meta box at bottom, this option should be used when
         * instantiating the class.
         * @deprecated     deprecated since version 1.3.3
         * @since          1.3
         * @access         public
         * @var            bool optional
         * @see            $lock
         */
        public $lock_on_bottom = false;

        /*
         * Used to set the initial view state of the meta box, possible values are:
         * opened, closed, always_opened, this option should be used when
         * instantiating the class.
         * @since     1.3.3
         * @access    public
         * @var        string optional possible values are: opened, closed, always_opened
         */
        public $view;

        /*
         * Used to hide the show/hide checkbox option from the screen options area,
         * this option should be used when instantiating the class.
         * @since         1.3.4
         * @access        public
         * @var            bool optional
         */
        public $hide_screen_option = false;

        // private
        public $meta;
        public $name;

        /*
         * Used to provide field type hinting
         * @since      1.3
         * @access     private
         * @var        string
         * @see        the_field()
         */
        public $hint;

        public $length = 0;
        public $current = -1;
        public $in_loop = false;
        public $in_template = false;
        public $group_tag;
        public $current_post_id;

        /*
         * Used to store current loop details, cleared after loop ends
         * @since      1.4
         * @access     private
         * @var        stdClass
         * @see        have_fields_and_multi(), have_fields()
         */
        public $_loop_data;
        /*
         * Other than core modifications, here is the loop stack function and class to support
         * nested repeatable group.
         * author Vafpress
         */
        public $_loop_stack = [];

        public function __construct($arr)
        {
            $this->_loop_data = new stdClass();
            $this->meta = [];
            $this->types = ['post', 'page'];
            if (isset($arr) and is_array($arr)) {
                foreach ($arr as $n => $v) {
                    $this->$n = $v;
                }
                if (empty($this->id)) {
                    die('Meta box ID required');
                }
                if (is_numeric($this->id)) {
                    die('Meta box ID must be a string');
                }
                if (empty($this->template)) {
                    die('Meta box template file required');
                }
                // check for nonarray values
                $exc_inc = [
                    'exclude_template',
                    'exclude_category_id',
                    'exclude_category',
                    'exclude_tag_id',
                    'exclude_tag',
                    'exclude_post_id',
                    'include_template',
                    'include_category_id',
                    'include_category',
                    'include_tag_id',
                    'include_tag',
                    'include_post_id',
                ];
                foreach ($exc_inc as $v) {
                    // ideally the exclude and include values should be in array form, convert to array otherwise
                    if (!empty($this->$v) and !is_array($this->$v)) {
                        $this->$v = array_map('trim', explode(',', $this->$v));
                    }
                }
                // convert depreciated variables
                if ($this->lock_on_top) {
                    $this->lock = WPALCHEMY_LOCK_TOP;
                } elseif ($this->lock_on_bottom) {
                    $this->lock = WPALCHEMY_LOCK_BOTTOM;
                }
                add_action('admin_init', [$this, '_init']);
                // uses the default wordpress-importer plugin hook
                add_action('import_post_meta', [$this, '_import'], 10, 3);
            } else {
                die('Associative array parameters required');
            }
        }

        /**
         * Used to correct double serialized data during post/page export/import,
         * additionally will try to fix corrupted serialized data by recalculating
         * string length values.
         *
         * @since     1.3.16
         */
        public function _import($post_id, $key, $value)
        {
            if (WPALCHEMY_MODE_ARRAY == $this->mode and $key == $this->id) {
                // using $wp_import to get access to the raw postmeta data prior to it getting passed
                // through "maybe_unserialize()" in "plugins/wordpress-importer/wordpress-importer.php"
                // the "import_post_meta" action is called after "maybe_unserialize()"
                global $wp_import;
                foreach ($wp_import->posts as $post) {
                    if ($post_id == $post['post_id']) {
                        foreach ($post['postmeta'] as $meta) {
                            if ($key == $meta['key']) {
                                // try to fix corrupted serialized data, specifically "\r\n" being converted to "\n" during wordpress XML export (WXR)
                                // "maybe_unserialize()" fixes a wordpress bug which double serializes already serialized data during export/import
                                $value = maybe_unserialize(preg_replace('!s:(\d+):"(.*?)";!es',
                                    "'s:'.strlen('$2').':\"$2\";'", stripslashes($meta['value'])));
                                update_post_meta($post_id, $key, $value);
                            }
                        }
                    }
                }
            }
        }

        /**
         * Used to initialize the meta box, runs on WordPress admin_init action,
         * properly calls internal WordPress methods.
         *
         * @since     1.0
         */
        public function _init()
        {
            // must be creating or editing a post or page
            if (!self::_is_post() and !self::_is_page()) {
                return;
            }
            if (!empty($this->output_filter)) {
                $this->add_filter('output', $this->output_filter);
            }
            if ($this->can_output()) {
                foreach ($this->types as $type) {
                    add_meta_box($this->id.'_metabox', $this->title, [$this, '_setup'], $type, $this->context,
                        $this->priority);
                }
                add_action('save_post', [$this, '_save']);
                $filters = ['save', 'head', 'foot'];
                foreach ($filters as $filter) {
                    $var = $filter.'_filter';
                    if (!empty($this->$var)) {
                        if ('save' == $filter) {
                            $this->add_filter($filter, $this->$var, 10, 2);
                        } else {
                            $this->add_filter($filter, $this->$var);
                        }
                    }
                }
                $actions = ['save', 'head', 'foot', 'init'];
                foreach ($actions as $action) {
                    $var = $action.'_action';
                    if (!empty($this->$var)) {
                        if ('save' == $action) {
                            $this->add_action($action, $this->$var, 10, 2);
                        } else {
                            $this->add_action($action, $this->$var);
                        }
                    }
                }
                add_action('admin_head', [$this, '_head'], 11);
                add_action('admin_footer', [$this, '_foot'], 11);
                // action: init
                if ($this->has_action('init')) {
                    $this->do_action('init');
                }
            }
        }

        /**
         * Used to check if creating a new post or editing one.
         *
         * @static
         *
         * @since      1.3.7
         *
         * @return bool
         *
         * @see        _is_page()
         */
        public static function _is_post()
        {
            if ('post' == self::_is_post_or_page()) {
                return true;
            }

            return false;
        }

        /**
         * Used to check if creating or editing a post or page.
         *
         * @static
         *
         * @since      1.3.8
         *
         * @return string "post" or "page"
         *
         * @see        _is_post(), _is_page()
         */
        public static function _is_post_or_page()
        {
            $post_type = self::_get_current_post_type();
            if (isset($post_type)) {
                if ('page' == $post_type) {
                    return 'page';
                } else {
                    return 'post';
                }
            }

            return;
        }

        /**
         * Used to check for the current post type, works when creating or editing a
         * new post, page or custom post type.
         *
         * @static
         *
         * @since    1.4.6
         *
         * @return string [custom_post_type], page or post
         */
        public static function _get_current_post_type()
        {
            $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
            if (isset($uri)) {
                $uri_parts = parse_url($uri);
                $file = basename($uri_parts['path']);
                if ($uri and in_array($file, ['post.php', 'post-new.php'])) {
                    $post_id = self::_get_post_id();
                    $post_type = isset($_GET['post_type']) ? $_GET['post_type'] : null;
                    $post_type = $post_id ? get_post_type($post_id) : $post_type;
                    if (isset($post_type)) {
                        return $post_type;
                    } else {
                        // because of the 'post.php' and 'post-new.php' checks above, we can default to 'post'
                        return 'post';
                    }
                }
            }

            return;
        }

        /**
         * Used to get the current post id.
         *
         * @static
         *
         * @since    1.4.8
         *
         * @return int post ID
         */
        public static function _get_post_id()
        {
            global $post;
            $p_post_id = isset($_POST['post_ID']) ? $_POST['post_ID'] : null;
            $g_post_id = isset($_GET['post']) ? $_GET['post'] : null;
            $post_id = $g_post_id ? $g_post_id : $p_post_id;
            $post_id = isset($post->ID) ? $post->ID : $post_id;
            if (isset($post_id)) {
                return (integer) $post_id;
            }

            return;
        }

        /**
         * Used to check if creating a new page or editing one.
         *
         * @static
         *
         * @since      1.3.7
         *
         * @return bool
         *
         * @see        _is_post()
         */
        public static function _is_page()
        {
            if ('page' == self::_is_post_or_page()) {
                return true;
            }

            return false;
        }

        /**
         * Uses WordPress add_filter() function, see WordPress add_filter().
         *
         * @since     1.3
         * @link      http://core.trac.wordpress.org/browser/trunk/wp-includes/plugin.php#L65
         */
        public function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1)
        {
            $tag = $this->_get_filter_tag($tag);
            add_filter($tag, $function_to_add, $priority, $accepted_args);
        }

        /**
         * Used to properly prefix the filter tag, the tag is unique to the meta
         * box instance.
         *
         * @since     1.3
         *
         * @param string $tag name of the filter
         *
         * @return string uniquely prefixed tag name
         */
        public function _get_filter_tag($tag)
        {
            $prefix = 'wpalchemy_filter_'.$this->id.'_';
            $prefix = preg_replace('/_+/', '_', $prefix);
            $tag = preg_replace('/^'.$prefix.'/i', '', $tag);

            return $prefix.$tag;
        }

        /**
         * @since    1.0
         */
        public function can_output()
        {
            $post_id = self::_get_post_id();
            if (!empty($this->exclude_template) or !empty($this->include_template)) {
                $template_file = get_post_meta($post_id, '_wp_page_template', true);
            }
            if (!empty($this->exclude_category) or !empty($this->exclude_category_id) or !empty($this->include_category) or !empty($this->include_category_id)) {
                $categories = wp_get_post_categories($post_id, 'fields=all');
            }
            if (!empty($this->exclude_tag) or !empty($this->exclude_tag_id) or !empty($this->include_tag) or !empty($this->include_tag_id)) {
                $tags = wp_get_post_tags($post_id);
            }
            // processing order: "exclude" then "include"
            // processing order: "template" then "category" then "post"
            $can_output = true; // include all
            if (!empty($this->exclude_template) or !empty($this->exclude_category_id) or !empty($this->exclude_category) or !empty($this->exclude_tag_id) or !empty($this->exclude_tag) or !empty($this->exclude_post_id) or !empty($this->include_template) or !empty($this->include_category_id) or !empty($this->include_category) or !empty($this->include_tag_id) or !empty($this->include_tag) or !empty($this->include_post_id)) {
                if (!empty($this->exclude_template)) {
                    if (in_array($template_file, $this->exclude_template)) {
                        $can_output = false;
                    }
                }
                if (!empty($this->exclude_category_id)) {
                    foreach ($categories as $cat) {
                        if (in_array($cat->term_id, $this->exclude_category_id)) {
                            $can_output = false;
                            break;
                        }
                    }
                }
                if (!empty($this->exclude_category)) {
                    foreach ($categories as $cat) {
                        if (in_array($cat->slug, $this->exclude_category) or in_array($cat->name,
                                $this->exclude_category)
                        ) {
                            $can_output = false;
                            break;
                        }
                    }
                }
                if (!empty($this->exclude_tag_id)) {
                    foreach ($tags as $tag) {
                        if (in_array($tag->term_id, $this->exclude_tag_id)) {
                            $can_output = false;
                            break;
                        }
                    }
                }
                if (!empty($this->exclude_tag)) {
                    foreach ($tags as $tag) {
                        if (in_array($tag->slug, $this->exclude_tag) or in_array($tag->name, $this->exclude_tag)) {
                            $can_output = false;
                            break;
                        }
                    }
                }
                if (!empty($this->exclude_post_id)) {
                    if (in_array($post_id, $this->exclude_post_id)) {
                        $can_output = false;
                    }
                }
                // excludes are not set use "include only" mode
                if (empty($this->exclude_template) and empty($this->exclude_category_id) and empty($this->exclude_category) and empty($this->exclude_tag_id) and empty($this->exclude_tag) and empty($this->exclude_post_id)) {
                    $can_output = false;
                }
                if (!empty($this->include_template)) {
                    if (in_array($template_file, $this->include_template)) {
                        $can_output = true;
                    }
                }
                if (!empty($this->include_category_id)) {
                    foreach ($categories as $cat) {
                        if (in_array($cat->term_id, $this->include_category_id)) {
                            $can_output = true;
                            break;
                        }
                    }
                }
                if (!empty($this->include_category)) {
                    foreach ($categories as $cat) {
                        if (in_array($cat->slug, $this->include_category) or in_array($cat->name,
                                $this->include_category)
                        ) {
                            $can_output = true;
                            break;
                        }
                    }
                }
                if (!empty($this->include_tag_id)) {
                    foreach ($tags as $tag) {
                        if (in_array($tag->term_id, $this->include_tag_id)) {
                            $can_output = true;
                            break;
                        }
                    }
                }
                if (!empty($this->include_tag)) {
                    foreach ($tags as $tag) {
                        if (in_array($tag->slug, $this->include_tag) or in_array($tag->name, $this->include_tag)) {
                            $can_output = true;
                            break;
                        }
                    }
                }
                if (!empty($this->include_post_id)) {
                    if (in_array($post_id, $this->include_post_id)) {
                        $can_output = true;
                    }
                }
            }
            $post_type = self::_get_current_post_type();
            if (isset($post_type) and !in_array($post_type, $this->types)) {
                $can_output = false;
            }
            // filter: output (can_output)
            if ($this->has_filter('output')) {
                $can_output = $this->apply_filters('output', $post_id);
            }

            return $can_output;
        }

        /**
         * Uses WordPress has_filter() function, see WordPress has_filter().
         *
         * @since     1.3
         * @link      http://core.trac.wordpress.org/browser/trunk/wp-includes/plugin.php#L86
         */
        public function has_filter($tag, $function_to_check = false)
        {
            $tag = $this->_get_filter_tag($tag);

            return has_filter($tag, $function_to_check);
        }

        /**
         * Uses WordPress apply_filters() function, see WordPress apply_filters().
         *
         * @since     1.3
         * @link      http://core.trac.wordpress.org/browser/trunk/wp-includes/plugin.php#L134
         */
        public function apply_filters($tag, $value)
        {
            $args = func_get_args();
            $args[0] = $this->_get_filter_tag($tag);

            return call_user_func_array('apply_filters', $args);
        }

        /**
         * Uses WordPress add_action() function, see WordPress add_action().
         *
         * @since     1.3
         * @link      http://core.trac.wordpress.org/browser/trunk/wp-includes/plugin.php#L324
         */
        public function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1)
        {
            $tag = $this->_get_action_tag($tag);
            add_action($tag, $function_to_add, $priority, $accepted_args);
        }

        /**
         * Used to properly prefix the action tag, the tag is unique to the meta
         * box instance.
         *
         * @since     1.3
         *
         * @param string $tag name of the action
         *
         * @return string uniquely prefixed tag name
         */
        public function _get_action_tag($tag)
        {
            $prefix = 'wpalchemy_action_'.$this->id.'_';
            $prefix = preg_replace('/_+/', '_', $prefix);
            $tag = preg_replace('/^'.$prefix.'/i', '', $tag);

            return $prefix.$tag;
        }

        /**
         * Uses WordPress has_action() function, see WordPress has_action().
         *
         * @since     1.3
         * @link      http://core.trac.wordpress.org/browser/trunk/wp-includes/plugin.php#L492
         */
        public function has_action($tag, $function_to_check = false)
        {
            $tag = $this->_get_action_tag($tag);

            return has_action($tag, $function_to_check);
        }

        /**
         * Uses WordPress do_action() function, see WordPress do_action().
         *
         * @since     1.3
         * @link      http://core.trac.wordpress.org/browser/trunk/wp-includes/plugin.php#L352
         */
        public function do_action($tag, $arg = '')
        {
            $args = func_get_args();
            $args[0] = $this->_get_action_tag($tag);

            return call_user_func_array('do_action', $args);
        }

        /**
         * Used to insert STYLE or SCRIPT tags into the head, called on WordPress
         * admin_head action.
         *
         * @since      1.3
         * @see        _foot()
         */
        public function _head()
        {
            $content = null;
            ob_start();
            ?>
            <style type="text/css">
                <?php if ($this->hide_editor) {
    ?>
                #wp-content-editor-container, #post-status-info, <?php if ($this->use_media_buttons) {
    ?> #content-html, #content-tmce<?php 
} else {
    ?> #wp-content-wrap<?php 
}
    ?> {
                    display : none;
                    }

                <?php 
}
            ?>
            </style>
            <?php
            $content = ob_get_contents();
            ob_end_clean();
            // filter: head
            if ($this->has_filter('head')) {
                $content = $this->apply_filters('head', $content);
            }
            echo $content;
            // action: head
            if ($this->has_action('head')) {
                $this->do_action('head');
            }
        }

        /**
         * Used to insert SCRIPT tags into the footer, called on WordPress
         * admin_footer action.
         *
         * @since      1.3
         * @see        _head()
         */
        public function _foot()
        {
            $content = null;
            if ($this->lock or $this->hide_title or $this->view or $this->hide_screen_option) {
                ob_start();
                ?>
                <script type="text/javascript">
                    /* <![CDATA[ */
                    (
                        function ($) { /* not using jQuery ondomready, code runs right away in footer */

                            var mb_id = '<?php echo $this->id;
                ?>';
                            var mb = $('#' + mb_id + '_metabox');

                            <?php if (WPALCHEMY_LOCK_TOP == $this->lock): ?>
                            <?php if ('side' == $this->context): ?>
                            var id = 'wpalchemy-side-top';
                            if (!$('#' + id).length) {
                                $('<div></div>').attr('id', id).prependTo('#side-info-column');
                            }
                            <?php else: ?>
                            var id = 'wpalchemy-content-top';
                            if (!$('#' + id).length) {
                                $('<div></div>').attr('id', id).insertAfter('#postdiv, #postdivrich');
                            }
                            <?php endif;
                ?>
                            $('#' + id).append(mb);
                            <?php elseif (WPALCHEMY_LOCK_BOTTOM == $this->lock): ?>
                            <?php if ('side' == $this->context): ?>
                            var id = 'wpalchemy-side-bottom';
                            if (!$('#' + id).length) {
                                $('<div></div>').attr('id', id).appendTo('#side-info-column');
                            }
                            <?php else: ?>
                            if (!$('#advanced-sortables').children().length) {
                                $('#advanced-sortables').css('display', 'none');
                            }

                            var id = 'wpalchemy-content-bottom';
                            if (!$('#' + id).length) {
                                $('<div></div>').attr('id', id).insertAfter('#advanced-sortables');
                            }
                            <?php endif;
                ?>
                            $('#' + id).append(mb);
                            <?php elseif (WPALCHEMY_LOCK_BEFORE_POST_TITLE == $this->lock): ?>
                            <?php if ('side' != $this->context): ?>
                            var id = 'wpalchemy-content-bpt';
                            if (!$('#' + id).length) {
                                $('<div></div>').attr('id', id).prependTo('#post-body-content');
                            }
                            $('#' + id).append(mb);
                            <?php endif;
                ?>
                            <?php elseif (WPALCHEMY_LOCK_AFTER_POST_TITLE == $this->lock): ?>
                            <?php if ('side' != $this->context): ?>
                            var id = 'wpalchemy-content-apt';
                            if (!$('#' + id).length) {
                                $('<div></div>').attr('id', id).insertAfter('#titlediv');
                            }
                            $('#' + id).append(mb);
                            <?php endif;
                ?>
                            <?php endif;
                ?>

                            <?php if (!empty($this->lock)): ?>
                            $('.hndle', mb).css('cursor', 'pointer');
                            $('.handlediv', mb).remove();
                            <?php endif;
                ?>

                            <?php if ($this->hide_title): ?>
                            $('.hndle', mb).remove();
                            $('.handlediv', mb).remove();
                            mb.removeClass('closed');
                            /* start opened */
                            <?php endif;
                ?>

                            <?php if (WPALCHEMY_VIEW_START_OPENED == $this->view): ?>
                            mb.removeClass('closed');
                            <?php elseif (WPALCHEMY_VIEW_START_CLOSED == $this->view): ?>
                            mb.addClass('closed');
                            <?php elseif (WPALCHEMY_VIEW_ALWAYS_OPENED == $this->view): ?>
                            /* todo: need to find a way to add this script block below, load-scripts.php?... */
                            var h3 = mb.children('h3');
                            setTimeout(function () { h3.unbind('click'); }, 1000);
                            $('.handlediv', mb).remove();
                            mb.removeClass('closed');
                            /* start opened */
                            $('.hndle', mb).css('cursor', 'auto');
                            <?php endif;
                ?>

                            <?php if ($this->hide_screen_option): ?>
                            $('.metabox-prefs label[for=' + mb_id + '_metabox-hide]').remove();
                            <?php endif;
                ?>

                            mb = null;

                        })(jQuery);
                    /* ]]> */
                </script>
                <?php
                $content = ob_get_contents();
                ob_end_clean();
            }
            // filter: foot
            if ($this->has_filter('foot')) {
                $content = $this->apply_filters('foot', $content);
            }
            echo $content;
            // action: foot
            if ($this->has_action('foot')) {
                $this->do_action('foot');
            }
        }

        /**
         * Used to setup the meta box content template.
         *
         * @since      1.0
         * @see        _init()
         */
        public function _setup()
        {
            $this->in_template = true;
            // also make current post data available
            global $post;
            // shortcuts
            $mb = &$this;
            $metabox = &$this;
            $id = $this->id;
            $meta = $this->_meta(null, true);
            // use include because users may want to use one templete for multiple meta boxes
            include $this->template;
            // create a nonce for verification
            echo '<input type="hidden" name="'.$this->id.'_nonce" value="'.wp_create_nonce($this->id).'" />';
            $this->in_template = false;
        }

        /**
         * Gets the meta data for a meta box
         * Internal method calls will typically bypass the data retrieval and will
         * immediately return the current meta data.
         *
         * @since      1.3
         *
         * @param int  $post_id  optional post ID for which to retrieve the meta data
         * @param bool $internal optional boolean if internally calling
         *
         * @return array
         *
         * @see        the_meta()
         */
        public function _meta($post_id = null, $internal = false)
        {
            if (!is_numeric($post_id)) {
                if ($internal and $this->current_post_id) {
                    $post_id = $this->current_post_id;
                } else {
                    global $post;
                    $post_id = $post->ID;
                }
            }
            // this allows multiple internal calls to _meta() without having to fetch data everytime
            if ($internal and !empty($this->meta) and $this->current_post_id == $post_id) {
                return $this->meta;
            }
            $this->current_post_id = $post_id;
            // WPALCHEMY_MODE_ARRAY
            $meta = get_post_meta($post_id, $this->id, true);
            // WPALCHEMY_MODE_EXTRACT
            $fields = get_post_meta($post_id, $this->id.'_fields', true);
            if (!empty($fields) and is_array($fields)) {
                $meta = [];
                foreach ($fields as $field) {
                    $field_noprefix = preg_replace('/^'.$this->prefix.'/i', '', $field);
                    $meta[$field_noprefix] = get_post_meta($post_id, $field, true);
                }
            }
            $this->meta = $meta;

            return $this->meta;
        }

        /**
         * Uses WordPress remove_filter() function, see WordPress remove_filter().
         *
         * @since     1.3
         * @link      http://core.trac.wordpress.org/browser/trunk/wp-includes/plugin.php#L250
         */
        public function remove_filter($tag, $function_to_remove, $priority = 10, $accepted_args = 1)
        {
            $tag = $this->_get_filter_tag($tag);

            return remove_filter($tag, $function_to_remove, $priority, $accepted_args);
        }

        /**
         * Uses WordPress remove_action() function, see WordPress remove_action().
         *
         * @since     1.3
         * @link      http://core.trac.wordpress.org/browser/trunk/wp-includes/plugin.php#L513
         */
        public function remove_action($tag, $function_to_remove, $priority = 10, $accepted_args = 1)
        {
            $tag = $this->_get_action_tag($tag);

            return remove_action($tag, $function_to_remove, $priority, $accepted_args);
        }

        /**
         * Used to insert global STYLE or SCRIPT tags into the head, called on
         * WordPress admin_footer action.
         *
         * @static
         *
         * @since      1.3
         * @see        _global_foot()
         */
        public static function _global_head()
        {
            // must be creating or editing a post or page
            if (!self::_is_post() and !self::_is_page()) {
                return;
            }
            // todo: you're assuming people will want to use this exact functionality
            // consider giving a developer access to change this via hooks/callbacks
            // include javascript for special functionality
            ?>
            <style type="text/css"> .wpa_group.tocopy {
                    display : none;
                    } </style>
            <script type="text/javascript">
                /* <![CDATA[ */
                jQuery(function ($) {
                    $(document).click(function (e) {
                        var elem = $(e.target);

                        if (elem.attr('class') && elem.filter('[class*=dodelete]').length) {
                            e.preventDefault();

                            var p = elem.parents('.wpa_group:first');

                            if (p.length <= 0) {
                                p = elem.parents('.postbox');
                            }
                            /*wp*/

                            var the_name = elem.attr('class').match(/dodelete-([a-zA-Z0-9_-]*)/i);

                            the_name = (
                                       the_name && the_name[1]) ? the_name[1] : null;

                            /* todo: expose and allow editing of this message */
                            if (confirm('This action can not be undone, are you sure?')) {
                                if (the_name) {
                                    $('.wpa_group-' + the_name, p).not('.tocopy').remove();
                                }
                                else {
                                    elem.parents('.wpa_group:first').remove();
                                }

                                if (!the_name) {
                                    var the_group = elem.parents('.wpa_group');
                                    if (the_group && the_group.attr('class')) {
                                        the_name = the_group.attr('class').match(/wpa_group-([a-zA-Z0-9_-]*)/i);
                                        the_name = (
                                                   the_name && the_name[1]) ? the_name[1] : null;
                                    }
                                }
                                checkLoopLimit(the_name);

                                $.wpalchemy.trigger('wpa_delete');
                            }
                        }
                    });

                    $(document).on('click', '[class*=docopy-]', function (e) {
                        e.preventDefault();

                        var p = $(this).parents('.wpa_group:first');

                        if (p.length <= 0) {
                            p = $(this).parents('.postbox');
                        }
                        /*wp*/

                        var the_name = $(this).attr('class').match(/docopy-([a-zA-Z0-9_-]*)/i)[1];

                        var the_group = $('.wpa_group-' + the_name + '.tocopy', p).first();

                        var the_clone = the_group.clone().removeClass('tocopy last');

                        var the_props = [
                            'name',
                            'id',
                            'for',
                            'class'
                        ];

                        the_group.find('*').each(function (i, elem) {
                            for (var j = 0; j < the_props.length; j++) {
                                var the_prop = $(elem).attr(the_props[j]);

                                if (the_prop) {
                                    var reg = new RegExp('\\[' + the_name + '\\]\\[(\\d+)\\]', 'i');
                                    var the_match = the_prop.match(reg);

                                    if (the_match) {
                                        the_prop = the_prop.replace(the_match[0], '[' + the_name + ']' + '[' + (
                                                                                  +the_match[1] + 1) + ']');

                                        $(elem).attr(the_props[j], the_prop);
                                    }

                                    the_match = null;

                                    // todo: this may prove to be too broad of a search
                                    the_match = the_prop.match(/n(\d+)/i);

                                    if (the_match) {
                                        the_prop = the_prop.replace(the_match[0], 'n' + (
                                                                                  +the_match[1] + 1));

                                        $(elem).attr(the_props[j], the_prop);
                                    }
                                }
                            }
                        });

                        // increment the group id
                        var reg = new RegExp('\\[(\\d+)\\]$', 'i');
                        var the_id = the_group.attr("id");
                        var the_match = the_id.match(reg);
                        if (the_match) {
                            the_group.attr("id", the_id.replace(the_match[0], '[' + (
                                                                              +the_match[1] + 1) + ']'));
                        }

                        if ($(this).hasClass('ontop')) {
                            $('.wpa_group-' + the_name, p).first().before(the_clone);
                        }
                        else {
                            the_group.before(the_clone);
                        }

                        checkLoopLimit(the_name);

                        $.wpalchemy.trigger('wpa_copy', [the_clone]);
                    });

                    function checkLoopLimit(name) {
                        var elems = $('.docopy-' + name);

                        $.each(elems, function (idx, elem) {

                            var p = $(this).parents('.wpa_group:first');

                            if (p.length <= 0) {
                                p = $(this).parents('.postbox');
                            }
                            /*wp*/

                            var the_class = $('.wpa_loop-' + name, p).attr('class');

                            if (the_class) {
                                var the_match = the_class.match(/wpa_loop_limit-([0-9]*)/i);

                                if (the_match) {
                                    var the_limit = the_match[1];

                                    if ($('.wpa_group-' + name, p).not('.wpa_group.tocopy').length >= the_limit) {
                                        $(this).hide();
                                    }
                                    else {
                                        $(this).show();
                                    }
                                }
                            }

                        });

                    }

                    /* do an initial limit check, show or hide buttons */
                    $('[class*=docopy-]').each(function () {
                        var the_name = $(this).attr('class').match(/docopy-([a-zA-Z0-9_-]*)/i)[1];

                        checkLoopLimit(the_name);
                    });
                });
                /* ]]> */
            </script>
            <?php

        }

        /**
         * Used to insert global SCRIPT tags into the footer, called on WordPress
         * admin_footer action.
         *
         * @static
         *
         * @since      1.3
         * @see        _global_head()
         */
        public static function _global_foot()
        {
            // must be creating or editing a post or page
            if (!self::_is_post() and !self::_is_page()) {
                return;
            }
            ?>
            <script type="text/javascript">
                /* <![CDATA[ */
                (
                    function ($) { /* not using jQuery ondomready, code runs right away in footer */

                        /* use a global dom element to attach events to */
                        $.wpalchemy = $('<div></div>').attr('id', 'wpalchemy').appendTo('body');

                    })(jQuery);
                /* ]]> */
            </script>
            <?php

        }

        // user can also use the_ID(), php functions are case-insensitive
        /**
         * Gets the meta data for a meta box.
         *
         * @since      1.0
         *
         * @param int $post_id optional post ID for which to retrieve the meta data
         *
         * @return array
         *
         * @see        _meta
         */
        public function the_meta($post_id = null)
        {
            return $this->_meta($post_id);
        }

        /**
         * @since     1.0
         */
        public function the_id()
        {
            echo $this->get_the_id();
        }

        /**
         * @since     1.0
         */
        public function get_the_id()
        {
            return $this->id;
        }

        /**
         * @since     1.0
         */
        public function the_field($n, $hint = null)
        {
            $this->name = $n;
            $this->hint = $hint;
        }

        /**
         * @since     1.0
         */
        public function have_value($n = null)
        {
            if ($this->get_the_value($n)) {
                return true;
            }

            return false;
        }

        public function get_the_value($n = null, $collection = false)
        {
            $this->_meta(null, true);
            $value = null;
            if ($this->is_in_loop()) {
                $n = is_null($n) ? $this->name : $n;
                if (!is_null($n)) {
                    if ($collection) {
                        $keys = $this->get_the_loop_group_name_array();
                    } else {
                        $keys = $this->get_the_loop_group_name_array();
                        $keys[] = $n;
                    }
                } else {
                    if ($collection) {
                        $keys = $this->get_the_loop_group_name_array();
                        end($keys);
                        $last = key($keys);
                        unset($keys[$last]);
                    } else {
                        $keys = $this->get_the_loop_group_name_array();
                    }
                }
                $value = $this->get_meta_by_array($keys);
            } else {
                $n = is_null($n) ? $this->name : $n;
                if (isset($this->meta[$n])) {
                    $value = $this->meta[$n];
                }
            }
            if (is_string($value) || is_numeric($value)) {
                if ($this->in_template) {
                    return $value;
                } else {
                    // http://wordpress.org/support/topic/call-function-called-by-embed-shortcode-direct
                    // http://phpdoc.wordpress.org/trunk/WordPress/Embed/WP_Embed.html#run_shortcode
                    global $wp_embed;

                    return do_shortcode($wp_embed->run_shortcode($value));
                }
            } else {
                // value can sometimes be an array
                return $value;
            }
        }

        public function is_in_loop()
        {
            if (current($this->_loop_stack) === false) {
                return false;
            }

            return true;
        }

        public function get_the_loop_group_name_array($with_id = false)
        {
            $loop_name = [];
            $curr = $this->get_the_current_loop();
            if ($with_id) {
                $loop_name[] = $this->id;
            }
            // copy _loop_stack to prevent internal pointer ruined
            $loop_stack = $this->get_the_loop_collection();
            foreach ($loop_stack as $loop) {
                $loop_name[] = $loop->name;
                $loop_name[] = $loop->current;
                if ($loop->name === $curr->name) {
                    break;
                }
            }

            return $loop_name;
        }

        public function get_the_current_loop()
        {
            return current($this->_loop_stack);
        }

        public function get_the_loop_collection($name = null)
        {
            $collection = [];
            if (is_null($name)) {
                $curr = $this->get_the_current_loop();
                if ($curr) {
                    $name = $curr->name;
                    $loop_stack = $this->_loop_stack;
                    $loop = $loop_stack[$name];
                    $collection[] = $loop;
                    while ($loop) {
                        $collection[] = $loop;
                        if ($loop->parent) {
                            $loop = $loop_stack[$loop->parent];
                        } else {
                            $loop = false;
                        }
                    }
                    $collection = array_reverse($collection);
                }
            }

            return $collection;
        }

        public function get_meta_by_array($arr)
        {
            $meta = $this->meta;
            if (!is_array($arr) || !is_array($meta) || is_null($meta)) {
                return;
            }
            foreach ($arr as $key) {
                if (is_array($meta) and array_key_exists($key, $meta)) {
                    $meta = $meta[$key];
                } else {
                    return;
                }
            }

            return $meta;
        }

        /**
         * @since     1.0
         */
        public function the_value($n = null)
        {
            echo $this->get_the_value($n);
        }

        /**
         * @since     1.0
         */
        public function the_name($n = null)
        {
            echo $this->get_the_name($n);
        }

        /**
         * @since     1.0
         */
        public function get_the_name($n = null)
        {
            if (!$this->in_template and $this->mode == WPALCHEMY_MODE_EXTRACT) {
                return $this->prefix.str_replace($this->prefix, '', is_null($n) ? $this->name : $n);
            }
            if ($this->is_in_loop()) {
                $n = is_null($n) ? $this->name : $n;
                if (!is_null($n)) {
                    $the_field = $this->get_the_loop_group_name(true).'['.$n.']';
                } else {
                    $the_field = $this->get_the_loop_group_name(true);
                }
            } else {
                $n = is_null($n) ? $this->name : $n;
                $the_field = $this->id.'['.$n.']';
            }
            $hints = [
                WPALCHEMY_FIELD_HINT_CHECKBOX_MULTI,
                WPALCHEMY_FIELD_HINT_SELECT_MULTI,
                WPALCHEMY_FIELD_HINT_SELECT_MULTIPLE,
            ];
            if (in_array($this->hint, $hints)) {
                $the_field .= '[]';
            }

            return $the_field;
        }

        public function get_the_loop_group_name($with_id = false)
        {
            $loop_name = $with_id ? $this->id : '';
            $curr = $this->get_the_current_loop();
            // copy _loop_stack to prevent internal pointer ruined
            $loop_stack = $this->get_the_loop_collection();
            // print_r($loop_stack);
            foreach ($loop_stack as $loop) {
                $loop_name .= '['.$loop->name.']['.$loop->current.']';
                if ($loop->name === $curr->name) {
                    break;
                }
            }

            return $loop_name;
        }

        /**
         * @since     1.1
         */
        public function the_index()
        {
            echo $this->get_the_index();
        }

        /**
         * @since     1.1
         */
        public function get_the_index()
        {
            return $this->in_loop ? $this->get_the_current_group_current() : 0;
        }

        public function get_the_current_group_current()
        {
            return current($this->_loop_stack)->current;
        }

        /**
         * @since     1.0
         */
        public function is_first()
        {
            if ($this->in_loop and $this->current == 0) {
                return true;
            }

            return false;
        }

        /**
         * @since     1.0
         */
        public function is_last()
        {
            if ($this->in_loop and ($this->current + 1) == $this->length) {
                return true;
            }

            return false;
        }

        /**
         * Used to check if a value is a match.
         *
         * @since      1.1
         *
         * @param string $n the field name to check or the value to check for (if the_field() is used prior)
         * @param string $v optional the value to check for
         *
         * @return bool
         *
         * @see        is_value()
         */
        public function is_value($n, $v = null)
        {
            if (is_null($v)) {
                $the_value = $this->get_the_value();
                $v = $n;
            } else {
                $the_value = $this->get_the_value($n);
            }
            if ($v == $the_value) {
                return true;
            }

            return false;
        }

        /**
         * Prints the current state of a checkbox field and should be used inline
         * within the INPUT tag.
         *
         * @since      1.3
         *
         * @param string $n the field name to check or the value to check for (if the_field() is used prior)
         * @param string $v optional the value to check for
         *
         * @see        get_the_checkbox_state()
         */
        public function the_checkbox_state($n, $v = null)
        {
            echo $this->get_the_checkbox_state($n, $v);
        }

        /**
         * Returns the current state of a checkbox field, the returned string is
         * suitable to be used inline within the INPUT tag.
         *
         * @since      1.3
         *
         * @param string $n the field name to check or the value to check for (if the_field() is used prior)
         * @param string $v optional the value to check for
         *
         * @return string suitable to be used inline within the INPUT tag
         *
         * @see        the_checkbox_state()
         */
        public function get_the_checkbox_state($n, $v = null)
        {
            if ($this->is_selected($n, $v)) {
                return ' checked="checked"';
            }
        }

        /**
         * Used to check if a value is selected, useful when working with checkbox,
         * radio and select values.
         *
         * @since      1.3
         *
         * @param string $n the field name to check or the value to check for (if the_field() is used prior)
         * @param string $v optional the value to check for
         *
         * @return bool
         *
         * @see        is_value()
         */
        public function is_selected($n, $v = null)
        {
            if (is_null($v)) {
                $the_value = $this->get_the_value(null);
                $v = $n;
            } else {
                $the_value = $this->get_the_value($n);
            }
            if (is_array($the_value)) {
                if (in_array($v, $the_value)) {
                    return true;
                }
            } elseif ($v == $the_value) {
                return true;
            }

            return false;
        }

        /**
         * Prints the current state of a radio field and should be used inline
         * within the INPUT tag.
         *
         * @since      1.3
         *
         * @param string $n the field name to check or the value to check for (if the_field() is used prior)
         * @param string $v optional the value to check for
         *
         * @see        get_the_radio_state()
         */
        public function the_radio_state($n, $v = null)
        {
            echo $this->get_the_checkbox_state($n, $v);
        }

        /**
         * Returns the current state of a radio field, the returned string is
         * suitable to be used inline within the INPUT tag.
         *
         * @since      1.3
         *
         * @param string $n the field name to check or the value to check for (if the_field() is used prior)
         * @param string $v optional the value to check for
         *
         * @return string suitable to be used inline within the INPUT tag
         *
         * @see        the_radio_state()
         */
        public function get_the_radio_state($n, $v = null)
        {
            return $this->get_the_checkbox_state($n, $v);
        }

        /**
         * Prints the current state of a select field and should be used inline
         * within the SELECT tag.
         *
         * @since      1.3
         *
         * @param string $n the field name to check or the value to check for (if the_field() is used prior)
         * @param string $v optional the value to check for
         *
         * @see        get_the_select_state()
         */
        public function the_select_state($n, $v = null)
        {
            echo $this->get_the_select_state($n, $v);
        }

        /**
         * Returns the current state of a select field, the returned string is
         * suitable to be used inline within the SELECT tag.
         *
         * @since      1.3
         *
         * @param string $n the field name to check or the value to check for (if the_field() is used prior)
         * @param string $v optional the value to check for
         *
         * @return string suitable to be used inline within the SELECT tag
         *
         * @see        the_select_state()
         */
        public function get_the_select_state($n, $v = null)
        {
            if ($this->is_selected($n, $v)) {
                return ' selected="selected"';
            }
        }

        /**
         * @since     1.1
         */
        public function the_group_open($t = 'div')
        {
            echo $this->get_the_group_open($t);
        }

        /**
         * @since     1.1
         */
        public function get_the_group_open($t = 'div')
        {
            $this->group_tag = $t;
            $curr_loop = $this->get_the_current_loop();
            $the_name = $curr_loop->name;
            $loop_open = null;
            $loop_open_classes = ['wpa_loop', 'wpa_loop-'.$the_name];
            $css_class = ['wpa_group', 'wpa_group-'.$the_name];
            if ($curr_loop->is_first()) {
                array_push($css_class, 'first');
                $loop_open = '<div class="wpa_loop">';
                if (isset($this->_loop_data->limit)) {
                    array_push($loop_open_classes, 'wpa_loop_limit-'.$this->_loop_data->limit);
                }
                $loop_open = '<div id="wpa_loop-'.$the_name.'" class="'.implode(' ', $loop_open_classes).'">';
            }
            if ($curr_loop->is_last()) {
                array_push($css_class, 'last');
                if ($this->in_loop == 'multi') {
                    array_push($css_class, 'tocopy');
                }
            }

            return $loop_open.'<'.$t.' class="'.implode(' ', $css_class).'">';
        }

        /**
         * @since     1.1
         */
        public function the_group_close()
        {
            echo $this->get_the_group_close();
        }

        /**
         * @since     1.1
         */
        public function get_the_group_close()
        {
            $loop_close = null;
            $curr_loop = $this->get_the_current_loop();
            if ($curr_loop->is_last()) {
                $loop_close = '</div>';
            }

            return '</'.$this->group_tag.'>'.$loop_close;
        }

        /**
         * @since     1.1
         */
        public function have_fields_and_multi($n, $options = null)
        {
            if (is_array($options)) {
                // use as stdClass object
                $options = (object) $options;
                $length = @$options->length;
                $this->_loop_data->limit = @$options->limit;
            } else {
                // backward compatibility (bc)
                $length = $options;
            }
            $this->_meta(null, true);
            $this->in_loop = 'multi';
            // push new loop or set loop to current name
            $this->push_or_set_current_loop($n, $length, $this->in_loop);

            return $this->_loop($n, $length, 2);
        }

        public function push_or_set_current_loop($name, $length, $type)
        {
            if (!array_key_exists($name, $this->_loop_stack)) {
                $this->push_loop($name, $length, $type);
            }
            $this->set_current_loop($name);
        }

        public function push_loop($name, $length, $type)
        {
            $loop = new WPA_Loop($name, $length, $type);
            $parent = $this->get_the_current_loop();
            if ($parent) {
                $loop->parent = $parent->name;
            } else {
                $loop->parent = false;
            }
            $this->_loop_stack[$name] = $loop;

            return $loop;
        }

        public function set_current_loop($name)
        {
            reset($this->_loop_stack);
            if (!array_key_exists($name, $this->_loop_stack)) {
                return;
            }
            while (key($this->_loop_stack) !== $name) {
                next($this->_loop_stack);
            }
        }

        /**
         * @since     1.0
         */
        public function _loop($n, $length = null, $and_one = 0)
        {
            if (!$this->in_loop) {
                $this->in_loop = true;
            }
            $cnt = $this->get_the_current_group_count();
            $length = is_null($length) ? $cnt : $length;
            if ($this->in_loop == 'multi' and $cnt > $length) {
                $length = $cnt;
            }
            $this->length = $length;
            if ($this->in_template and $and_one) {
                if ($length == 0) {
                    $this->length = $and_one;
                } else {
                    $this->length = $length + 1;
                }
            }
            $this->set_the_current_group_length($this->length);
            $this->increment_current_loop();
            ++$this->current;
            if ($this->get_the_current_group_current() < $this->get_the_current_group_length()) {
                $this->name = null;
                $this->fieldtype = null;

                return true;
            } elseif ($this->get_the_current_group_current() == $this->get_the_current_group_length()) {
                $this->name = null;
                $this->set_the_current_group_current(-1);
                $this->prev_loop();
            }
            $this->in_loop = false;
            $this->_loop_data = new stdClass();

            return false;
        }

        public function get_the_current_group_count()
        {
            $arr = $this->get_the_loop_group_name_array();
            end($arr);
            $last = key($arr);
            unset($arr[$last]);
            $meta = $this->get_meta_by_array($arr);

            return count($meta);
        }

        public function set_the_current_group_length($length)
        {
            current($this->_loop_stack)->length = $length;
        }

        public function increment_current_loop()
        {
            current($this->_loop_stack)->current++;
        }

        public function get_the_current_group_length()
        {
            return current($this->_loop_stack)->length;
        }

        public function set_the_current_group_current($current)
        {
            current($this->_loop_stack)->current = $current;
        }

        public function prev_loop()
        {
            $parent = $this->get_the_current_loop()->parent;
            if ($parent) {
                $this->set_current_loop($parent);
            } else {
                $this->_loop_stack = [];

                return false;
            }
        }

        /**
         * @deprecated
         * @since     1.0
         */
        public function have_fields_and_one($n)
        {
            $this->_meta(null, true);
            $this->in_loop = 'single';
            $this->push_or_set_current_loop($n, $length, $this->in_loop);

            return $this->_loop($n, null, 1);
        }

        /**
         * @since     1.0
         */
        public function have_fields($n, $length = null)
        {
            $this->_meta(null, true);
            // push new loop or set loop to current name
            $this->in_loop = 'normal';
            $this->push_or_set_current_loop($n, $length, $this->in_loop);

            return $this->_loop($n, $length);
        }

        /**
         * @since     1.0
         */
        public function _save($post_id)
        {
            /*
             * note: the "save_post" action fires for saving revisions and post/pages,
             * when saving a post this function fires twice, once for a revision save,
             * and again for the post/page save ... the $post_id is different for the
             * revision save, this means that "get_post_meta()" will not work if trying
             * to get values for a revision (as it has no post meta data)
             * see http://alexking.org/blog/2008/09/06/wordpress-26x-duplicate-custom-field-issue
             * why let the code run twice? wordpress does not currently save post meta
             * data per revisions (I think it should, so users can do a complete revert),
             * so in the case that this functionality changes, let it run twice
             */
            $real_post_id = isset($_POST['post_ID']) ? $_POST['post_ID'] : null;
            // check autosave
            if (defined('DOING_AUTOSAVE') and DOING_AUTOSAVE and !$this->autosave) {
                return $post_id;
            }
            // make sure data came from our meta box, verify nonce
            $nonce = isset($_POST[$this->id.'_nonce']) ? $_POST[$this->id.'_nonce'] : null;
            if (!wp_verify_nonce($nonce, $this->id)) {
                return $post_id;
            }
            // check user permissions
            if ($_POST['post_type'] == 'page') {
                if (!current_user_can('edit_page', $post_id)) {
                    return $post_id;
                }
            } else {
                if (!current_user_can('edit_post', $post_id)) {
                    return $post_id;
                }
            }
            // authentication passed, save data
            $new_data = isset($_POST[$this->id]) ? $_POST[$this->id] : null;
            self::clean($new_data);
            if (empty($new_data)) {
                $new_data = null;
            }
            // filter: save
            if ($this->has_filter('save')) {
                $new_data = $this->apply_filters('save', $new_data, $real_post_id);
                /*
                 * halt saving
                 * @since 1.3.4
                 */
                if (false === $new_data) {
                    return $post_id;
                }
                self::clean($new_data);
            }
            // get current fields, use $real_post_id (checked for in both modes)
            $current_fields = get_post_meta($real_post_id, $this->id.'_fields', true);
            if ($this->mode == WPALCHEMY_MODE_EXTRACT) {
                $new_fields = [];
                if (is_array($new_data)) {
                    foreach ($new_data as $k => $v) {
                        $field = $this->prefix.$k;
                        array_push($new_fields, $field);
                        $new_value = $new_data[$k];
                        if (is_null($new_value)) {
                            delete_post_meta($post_id, $field);
                        } else {
                            update_post_meta($post_id, $field, $new_value);
                        }
                    }
                }
                $diff_fields = array_diff((array) $current_fields, $new_fields);
                if (is_array($diff_fields)) {
                    foreach ($diff_fields as $field) {
                        delete_post_meta($post_id, $field);
                    }
                }
                delete_post_meta($post_id, $this->id.'_fields');
                if (!empty($new_fields)) {
                    add_post_meta($post_id, $this->id.'_fields', $new_fields, true);
                }
                // keep data tidy, delete values if previously using WPALCHEMY_MODE_ARRAY
                delete_post_meta($post_id, $this->id);
            } else {
                if (is_null($new_data)) {
                    delete_post_meta($post_id, $this->id);
                } else {
                    update_post_meta($post_id, $this->id, $new_data);
                }
                // keep data tidy, delete values if previously using WPALCHEMY_MODE_EXTRACT
                if (is_array($current_fields)) {
                    foreach ($current_fields as $field) {
                        delete_post_meta($post_id, $field);
                    }
                    delete_post_meta($post_id, $this->id.'_fields');
                }
            }
            // action: save
            if ($this->has_action('save')) {
                $this->do_action('save', $new_data, $real_post_id);
            }

            return $post_id;
        }

        /**
         * Cleans an array, removing blank ('') values.
         *
         * @static
         *
         * @since     1.0
         *
         * @param    array the array to clean (passed by reference)
         */
        public static function clean(&$arr)
        {
            if (is_array($arr)) {
                foreach ($arr as $i => $v) {
                    if (is_array($arr[$i])) {
                        self::clean($arr[$i]);
                        if (!count($arr[$i])) {
                            unset($arr[$i]);
                        }
                    } else {
                        if ('' == trim($arr[$i]) or is_null($arr[$i])) {
                            unset($arr[$i]);
                        }
                    }
                }
                if (!count($arr)) {
                    $arr = [];
                } else {
                    $keys = array_keys($arr);
                    $is_numeric = true;
                    foreach ($keys as $key) {
                        if (!is_numeric($key)) {
                            $is_numeric = false;
                            break;
                        }
                    }
                    if ($is_numeric) {
                        $arr = array_values($arr);
                    }
                }
            }
        }

        public function next_loop()
        {
            return next($this->_loop_stack);
        }

        public function get_the_loop_level()
        {
            $curr = $this->get_the_current_loop();
            $depth = 0;
            // copy _loop_stack to prevent internal pointer ruined
            $loop_stack = $this->get_the_loop_collection();
            foreach ($loop_stack as $loop) {
                if ($loop->name === $curr->name) {
                    break;
                }
                ++$depth;
            }

            return $depth;
        }

        public function get_the_loop_group_id()
        {
            $loop_name = '';
            $curr = $this->get_the_current_loop();
            // copy _loop_stack to prevent internal pointer ruined
            $loop_stack = $this->get_the_loop_collection();
            foreach ($loop_stack as $key => $loop) {
                $is_first = false;
                $is_last = false;
                reset($loop_stack);
                if ($key === key($loop_stack)) {
                    $is_first = true;
                }
                if ($loop->name === $curr->name) {
                    $is_last = true;
                }
                $loop_name .= '['.$loop->name.']';
                if (!$is_last) {
                    $loop_name .= '['.$loop->current.']';
                }
                if ($loop->name === $curr->name) {
                    break;
                }
            }

            return $loop_name;
        }

        public function get_the_dotted_loop_group_name($with_id = false)
        {
            $loop_name = $with_id ? $this->id : '';
            $curr = $this->get_the_current_loop();
            // copy _loop_stack to prevent internal pointer ruined
            $loop_stack = $this->get_the_loop_collection();
            foreach ($loop_stack as $loop) {
                $loop_name .= ($loop_name === '' ? '' : '.').$loop->name.'.'.$loop->current;
                if ($loop->name === $curr->name) {
                    break;
                }
            }

            return $loop_name;
        }

        public function get_meta_by_dotted($dotted)
        {
            $keys = explode('.', $dotted);
            $meta = $this->meta;
            foreach ($keys as $key) {
                if (array_key_exists($key, $meta)) {
                    $meta = $meta[$key];
                } else {
                    return;
                }
            }

            return $meta;
        }

        public function is_in_multi_last()
        {
            // copy _loop_stack to prevent internal pointer ruined
            $loop_stack = $this->get_the_loop_collection();
            foreach ($loop_stack as $loop) {
                if ($loop->type === 'multi' and $loop->is_last()) {
                    return true;
                }
            }

            return false;
        }

        public function is_parent_multi()
        {
            // copy _loop_stack to prevent internal pointer ruined
            $loop_stack = $this->get_the_loop_collection();
            foreach ($loop_stack as $loop) {
                if ($loop->type === 'multi') {
                    return true;
                }
            }

            return false;
        }

        public function the_copy_button_class()
        {
            $curr = $this->get_the_current_loop();

            return 'docopy-'.$curr->get_the_indexed_name();
        }
    }

    class WPA_Loop
    {
        public $length = 0;

        public $parent = null;

        public $current = -1;

        public $name = null;

        public $type = false;

        public function __construct($name, $length, $type)
        {
            $this->name = $name;
            $this->length = $length;
            $this->type = $type;
        }

        public function the_indexed_name()
        {
            echo $this->get_the_indexed_name();
        }

        public function get_the_indexed_name()
        {
            return $this->name.'['.$this->current.']';
        }

        public function is_first()
        {
            if ($this->current == 0) {
                return true;
            }

            return false;
        }

        public function is_last()
        {
            if (($this->current + 1) == $this->length) {
                return true;
            }

            return false;
        }
    }

/* eof */

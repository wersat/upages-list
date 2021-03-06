<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Admin_Menu.
     *
     * @class  Inventor_Admin_Menu
     * @author Pragmatic Mates
     */
class Inventor_Admin_Menu
{
    /**
         * Initialize.
         */
    public static function init()
    {
        add_action('custom_menu_order', '__return_true');
        add_filter('menu_order', [__CLASS__, 'menu_reorder']);
        add_action('admin_menu', [__CLASS__, 'admin_menu']);
        add_action('admin_menu', [__CLASS__, 'admin_separator']);
        add_action('admin_menu', [__CLASS__, 'counter'], 1);
    }

    /**
         * Reorder submenus.
         *
         * @param $menu_order
         *
         * @return mixed
         */
    public static function menu_reorder($menu_order)
    {
        global $submenu;
        $menu_slugs = ['inventor', 'lexicon', 'listings'];
        if (! empty($submenu) && ! empty($menu_slugs) && is_array($menu_slugs)) {
            foreach ($menu_slugs as $slug) {
                if (! empty($submenu[$slug])) {
                    usort($submenu[$slug], [__CLASS__, 'sort_alphabet']);
                }
            }
        }

        return $menu_order;
    }

    /**
         * Compare alphabetically.
         *
         * @param $a
         * @param $b
         *
         * @return int
         */
    public static function sort_alphabet($a, $b)
    {
        return strnatcmp($a[0], $b[0]);
    }

    /**
         * Count post types under listings menu item.
         */
    public static function counter()
    {
        global $wp_post_types;
        foreach ($wp_post_types as $post_type) {
            if ('listings' == $post_type->show_in_menu) {
                $name                                    = $post_type->name;
                $published                               = wp_count_posts($name)->publish;
                $draft                                   = wp_count_posts($name)->draft;
                $pending                                 = wp_count_posts($name)->pending;
                $count                                   = $published + $draft + $pending;
                $name_with_count
                                                         = sprintf(
                                                             '%s <span class="inventor-menu-count">(%s)</span>',
                                                             $wp_post_types[$name]->labels->all_items, $count
                                                         );
                $wp_post_types[$name]->labels->all_items = $name_with_count;
            }
        }
    }

    /**
         * Registers separator.
         */
    public static function admin_separator()
    {
        global $menu;
        $menu[49] = ['', 'read', 'separator', '', 'wp-menu-separator'];
    }

    /**
         * Registers Inventor admin menu wrapper.
         */
    public static function admin_menu()
    {
        add_menu_page(
            __('Inventor', 'inventor'), __('Inventor', 'inventor'), 'edit_posts', 'inventor', null, null,
            '50'
        );
        add_submenu_page(
            'inventor', __('Colors', 'inventor'), __('Colors', 'inventor'), 'edit_posts',
            'edit-tags.php?taxonomy=colors', false
        );
        add_submenu_page(
            'inventor', __('Locations', 'inventor'), __('Locations', 'inventor'), 'edit_posts',
            'edit-tags.php?taxonomy=locations', false
        );
        add_submenu_page(
            'inventor', __('Categories', 'inventor'), __('Categories', 'inventor'), 'edit_posts',
            'edit-tags.php?taxonomy=listing_categories', false
        );
        remove_submenu_page('inventor', 'inventor');
        add_menu_page(
            __('Listings', 'inventor'), __('Listings', 'inventor'), 'edit_posts', 'listings', null, null,
            '51'
        );
        add_menu_page(
            __('Lexicon', 'inventor'), __('Lexicon', 'inventor'), 'edit_posts', 'lexicon', null, null,
            '52'
        );
        $taxonomies         = get_taxonomies([], 'objects');
        $enabled_post_types = Inventor_Post_Types::get_listing_post_types();
        foreach ($taxonomies as $taxonomy) {
            if ($taxonomy->show_in_menu !== 'lexicon') {
                continue;
            }
            $name              = $taxonomy->name;
            $label             = $taxonomy->label;
            $object_type       = $taxonomy->object_type;
            $object_type_count = count($object_type);
            $add_submenu       = true;
            if (is_array($object_type) && $object_type_count === 1) {
                $object_type = $object_type[0];
                $add_submenu = in_array($object_type, $enabled_post_types);
            }
            if ($add_submenu) {
                add_submenu_page('lexicon', $label, $label, 'edit_posts', 'edit-tags.php?taxonomy=' . $name, false);
            }
        }
        remove_submenu_page('lexicon', 'lexicon');
    }
}

    Inventor_Admin_Menu::init();

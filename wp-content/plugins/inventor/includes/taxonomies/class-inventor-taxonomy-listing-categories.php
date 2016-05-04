<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Taxonomy_Listing_Categories.
     *
     * @class  Inventor_Taxonomy_Listing_Categories
     * @author Pragmatic Mates
     */
class Inventor_Taxonomy_Listing_Categories
{
    /**
         * Initialize taxonomy.
         */
    public static function init()
    {
        add_action('init', [__CLASS__, 'definition'], 12);
        add_action('cmb2_init', [__CLASS__, 'fields']);
        add_action('parent_file', [__CLASS__, 'menu']);
    }

    /**
         * Widget definition.
         */
    public static function definition()
    {
        $labels = [
            'name'              => __('Categories', 'inventor'),
            'singular_name'     => __('Category', 'inventor'),
            'search_items'      => __('Search Categories', 'inventor'),
            'all_items'         => __('All Categories', 'inventor'),
            'parent_item'       => __('Parent Category', 'inventor'),
            'parent_item_colon' => __('Parent Category:', 'inventor'),
            'edit_item'         => __('Edit Category', 'inventor'),
            'update_item'       => __('Update Category', 'inventor'),
            'add_new_item'      => __('Add New Category', 'inventor'),
            'new_item_name'     => __('New Category', 'inventor'),
            'menu_name'         => __('Categories', 'inventor'),
            'not_found'         => __('No categories found.', 'inventor'),
        ];
        register_taxonomy(
            'listing_categories', Inventor_Post_Types::get_listing_post_types(), [
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'listing-category',
            'rewrite'           => ['slug' => _x('listing-category', 'URL slug', 'inventor')],
            'public'            => true,
            'show_ui'           => true,
            'show_in_menu'      => false,
            'show_in_nav_menus' => true,
            'meta_box_cb'       => false,
            'show_admin_column' => true,
            ]
        );
    }

    /**
         * Set active menu for taxonomy location.
     *
         * @return string
         */
    public static function menu($parent_file)
    {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;
        if ('listing_categories' === $taxonomy) {
            return 'inventor';
        }

        return $parent_file;
    }

    /**
         * Define custom fields for listing category taxonomy.
         */
    public static function fields()
    {
        $meta_box_id = 'listing_categories_options';
        $cmb         = new_cmb2_box(
            [
            'id'           => $meta_box_id,
            'object_types' => ['key' => 'options-page', 'value' => ['unknown']],
            ]
        );
        $cmb->add_field(
            [
            'name' => __('Image', 'inventor'),
            'id'   => 'image',
            'type' => 'file',
            ]
        );
        $cmb->add_field(
            [
            'name'    => __('POI', 'inventor'),
            'id'      => 'poi',
            'type'    => 'radio_inline',
            'options' => [
                'inventor-poi-airport'         => '<i class="inventor-poi inventor-poi-airport"></i>',
                'inventor-poi-apartment'       => '<i class="inventor-poi inventor-poi-apartment"></i>',
                'inventor-poi-atm'             => '<i class="inventor-poi inventor-poi-atm"></i>',
                'inventor-poi-bank'            => '<i class="inventor-poi inventor-poi-bank"></i>',
                'inventor-poi-bookcase'        => '<i class="inventor-poi inventor-poi-bookcase"></i>',
                'inventor-poi-bus'             => '<i class="inventor-poi inventor-poi-bus"></i>',
                'inventor-poi-camera'          => '<i class="inventor-poi inventor-poi-camera"></i>',
                'inventor-poi-camping'         => '<i class="inventor-poi inventor-poi-camping"></i>',
                'inventor-poi-car-service'     => '<i class="inventor-poi inventor-poi-car-service"></i>',
                'inventor-poi-car'             => '<i class="inventor-poi inventor-poi-car"></i>',
                'inventor-poi-cart'            => '<i class="inventor-poi inventor-poi-cart"></i>',
                'inventor-poi-casino'          => '<i class="inventor-poi inventor-poi-casino"></i>',
                'inventor-poi-castle'          => '<i class="inventor-poi inventor-poi-castle"></i>',
                'inventor-poi-cemetery'        => '<i class="inventor-poi inventor-poi-cemetery"></i>',
                'inventor-poi-church'          => '<i class="inventor-poi inventor-poi-church"></i>',
                'inventor-poi-cinema'          => '<i class="inventor-poi inventor-poi-cinema"></i>',
                'inventor-poi-clock'           => '<i class="inventor-poi inventor-poi-clock"></i>',
                'inventor-poi-cocktail'        => '<i class="inventor-poi inventor-poi-cocktail"></i>',
                'inventor-poi-coffee'          => '<i class="inventor-poi inventor-poi-coffee"></i>',
                'inventor-poi-cog-wheel'       => '<i class="inventor-poi inventor-poi-cog-wheel"></i>',
                'inventor-poi-coins'           => '<i class="inventor-poi inventor-poi-coins"></i>',
                'inventor-poi-compass'         => '<i class="inventor-poi inventor-poi-compass"></i>',
                'inventor-poi-computer-screen' => '<i class="inventor-poi inventor-poi-computer-screen"></i>',
                'inventor-poi-condominium'     => '<i class="inventor-poi inventor-poi-condominium"></i>',
                'inventor-poi-cottage'         => '<i class="inventor-poi inventor-poi-cottage"></i>',
                'inventor-poi-divider'         => '<i class="inventor-poi inventor-poi-divider"></i>',
                'inventor-poi-exchange'        => '<i class="inventor-poi inventor-poi-exchange"></i>',
                'inventor-poi-eye'             => '<i class="inventor-poi inventor-poi-eye"></i>',
                'inventor-poi-factory'         => '<i class="inventor-poi inventor-poi-factory"></i>',
                'inventor-poi-family-home'     => '<i class="inventor-poi inventor-poi-family-home"></i>',
                'inventor-poi-female'          => '<i class="inventor-poi inventor-poi-female"></i>',
                'inventor-poi-fruit'           => '<i class="inventor-poi inventor-poi-fruit"></i>',
                'inventor-poi-gamepad'         => '<i class="inventor-poi inventor-poi-gamepad"></i>',
                'inventor-poi-gas'             => '<i class="inventor-poi inventor-poi-gas"></i>',
                'inventor-poi-glass'           => '<i class="inventor-poi inventor-poi-glass"></i>',
                'inventor-poi-glasses'         => '<i class="inventor-poi inventor-poi-glasses"></i>',
                'inventor-poi-globe'           => '<i class="inventor-poi inventor-poi-globe"></i>',
                'inventor-poi-guitar'          => '<i class="inventor-poi inventor-poi-guitar"></i>',
                'inventor-poi-hamburger'       => '<i class="inventor-poi inventor-poi-hamburger"></i>',
                'inventor-poi-heart'           => '<i class="inventor-poi inventor-poi-heart"></i>',
                'inventor-poi-hospital'        => '<i class="inventor-poi inventor-poi-hospital"></i>',
                'inventor-poi-hotel'           => '<i class="inventor-poi inventor-poi-hotel"></i>',
                'inventor-poi-house'           => '<i class="inventor-poi inventor-poi-house"></i>',
                'inventor-poi-information'     => '<i class="inventor-poi inventor-poi-information"></i>',
                'inventor-poi-key'             => '<i class="inventor-poi inventor-poi-key"></i>',
                'inventor-poi-lcd'             => '<i class="inventor-poi inventor-poi-lcd"></i>',
                'inventor-poi-leaf'            => '<i class="inventor-poi inventor-poi-leaf"></i>',
                'inventor-poi-library'         => '<i class="inventor-poi inventor-poi-library"></i>',
                'inventor-poi-lunch'           => '<i class="inventor-poi inventor-poi-lunch"></i>',
                'inventor-poi-mail'            => '<i class="inventor-poi inventor-poi-mail"></i>',
                'inventor-poi-male'            => '<i class="inventor-poi inventor-poi-male"></i>',
                'inventor-poi-map'             => '<i class="inventor-poi inventor-poi-map"></i>',
                'inventor-poi-mic'             => '<i class="inventor-poi inventor-poi-mic"></i>',
                'inventor-poi-mountain'        => '<i class="inventor-poi inventor-poi-mountain"></i>',
                'inventor-poi-music'           => '<i class="inventor-poi inventor-poi-music"></i>',
                'inventor-poi-palms'           => '<i class="inventor-poi inventor-poi-palms"></i>',
                'inventor-poi-parking'         => '<i class="inventor-poi inventor-poi-parking"></i>',
                'inventor-poi-pastry'          => '<i class="inventor-poi inventor-poi-pastry"></i>',
                'inventor-poi-pencil'          => '<i class="inventor-poi inventor-poi-pencil"></i>',
                'inventor-poi-pharmacy'        => '<i class="inventor-poi inventor-poi-pharmacy"></i>',
                'inventor-poi-phone'           => '<i class="inventor-poi inventor-poi-phone"></i>',
                'inventor-poi-picture'         => '<i class="inventor-poi inventor-poi-picture"></i>',
                'inventor-poi-pin'             => '<i class="inventor-poi inventor-poi-pin"></i>',
                'inventor-poi-play'            => '<i class="inventor-poi inventor-poi-play"></i>',
                'inventor-poi-plug'            => '<i class="inventor-poi inventor-poi-plug"></i>',
                'inventor-poi-printer'         => '<i class="inventor-poi inventor-poi-printer"></i>',
                'inventor-poi-pub'             => '<i class="inventor-poi inventor-poi-pub"></i>',
                'inventor-poi-pushchair'       => '<i class="inventor-poi inventor-poi-pushchair"></i>',
                'inventor-poi-radio'           => '<i class="inventor-poi inventor-poi-radio"></i>',
                'inventor-poi-scissors'        => '<i class="inventor-poi inventor-poi-scissors"></i>',
                'inventor-poi-shield'          => '<i class="inventor-poi inventor-poi-shield"></i>',
                'inventor-poi-ship'            => '<i class="inventor-poi inventor-poi-ship"></i>',
                'inventor-poi-shirt'           => '<i class="inventor-poi inventor-poi-shirt"></i>',
                'inventor-poi-single-house'    => '<i class="inventor-poi inventor-poi-single-house"></i>',
                'inventor-poi-snowflake'       => '<i class="inventor-poi inventor-poi-snowflake"></i>',
                'inventor-poi-speaker'         => '<i class="inventor-poi inventor-poi-speaker"></i>',
                'inventor-poi-star'            => '<i class="inventor-poi inventor-poi-star"></i>',
                'inventor-poi-steak'           => '<i class="inventor-poi inventor-poi-steak"></i>',
                'inventor-poi-theatre'         => '<i class="inventor-poi inventor-poi-theatre"></i>',
                'inventor-poi-train'           => '<i class="inventor-poi inventor-poi-train"></i>',
                'inventor-poi-trash'           => '<i class="inventor-poi inventor-poi-trash"></i>',
                'inventor-poi-tree'            => '<i class="inventor-poi inventor-poi-tree"></i>',
                'inventor-poi-trousers'        => '<i class="inventor-poi inventor-poi-trousers"></i>',
                'inventor-poi-truck'           => '<i class="inventor-poi inventor-poi-truck"></i>',
                'inventor-poi-umbrella'        => '<i class="inventor-poi inventor-poi-umbrella"></i>',
                'inventor-poi-university'      => '<i class="inventor-poi inventor-poi-university"></i>',
                'inventor-poi-villa'           => '<i class="inventor-poi inventor-poi-villa"></i>',
                'inventor-poi-warehouse'       => '<i class="inventor-poi inventor-poi-warehouse"></i>',
                'inventor-poi-warning'         => '<i class="inventor-poi inventor-poi-warning"></i>',
                'inventor-poi-wi-fi'           => '<i class="inventor-poi inventor-poi-wi-fi"></i>',
                'inventor-poi-winery'          => '<i class="inventor-poi inventor-poi-winery"></i>',
                'inventor-poi-zoo'             => '<i class="inventor-poi inventor-poi-zoo"></i>',
            ],
            ]
        );
        new Taxonomy_MetaData_CMB2('listing_categories', $meta_box_id, __('Listing Category Options', 'inventor'));
    }
}

    Inventor_Taxonomy_Listing_Categories::init();

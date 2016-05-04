<?php
if (! defined('ABSPATH')) {
    exit;
}

    /**
     * Class Inventor_Taxonomies.
     *
     * @class  Inventor_Taxonomies
     * @author Pragmatic Mates
     */
class Inventor_Taxonomies
{
    /**
         * Initialize taxonomies.
         */
    public static function init()
    {
        self::includes();
    }

    /**
         * Includes all taxonomies.
         */
    public static function includes()
    {
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-colors.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-locations.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-listing-categories.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-car-models.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-car-body-styles.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-car-engine-types.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-car-transmissions.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-dating-groups.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-dating-interests.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-dating-statuses.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-education-levels.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-education-subjects.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-event-types.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-food-kinds.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-hotel-classes.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-pet-animals.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-shopping-categories.php';
        include_once INVENTOR_TAX_DIR . '/class-inventor-taxonomy-travel-activities.php';
    }

    /**
         * Get list of available taxonomies.
     *
         * @return array
         */
    public static function get_listing_taxonomies()
    {
        $taxonomies     = [];
        $all_taxonomies = get_taxonomies([], 'objects');
        if (! empty($all_taxonomies)) {
            foreach ($all_taxonomies as $taxonomy) {
                $post_types = Inventor_Post_Types::get_listing_post_types();
                if (! empty($post_types)) {
                    foreach ($post_types as $post_type) {
                        if (in_array($post_type, $taxonomy->object_type)) {
                            $taxonomies[] = $taxonomy->name;
                            break;
                        }
                    }
                }
            }
        }

        return $taxonomies;
    }
}

    Inventor_Taxonomies::init();

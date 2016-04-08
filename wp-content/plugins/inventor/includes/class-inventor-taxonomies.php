<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Taxonomies.
     *
     * @class  Inventor_Taxonomies
     *
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
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-colors.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-locations.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-listing-categories.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-car-models.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-car-body-styles.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-car-engine-types.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-car-transmissions.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-dating-groups.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-dating-interests.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-dating-statuses.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-education-levels.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-education-subjects.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-event-types.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-food-kinds.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-hotel-classes.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-pet-animals.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-shopping-categories.php';
            require_once INVENTOR_DIR.'includes/taxonomies/class-inventor-taxonomy-travel-activities.php';
        }

        /**
         * Get list of available taxonomies.
         *
         * @return array
         */
        public static function get_listing_taxonomies()
        {
            $taxonomies = [];
            $all_taxonomies = get_taxonomies([], 'objects');
            if (!empty($all_taxonomies)) {
                foreach ($all_taxonomies as $taxonomy) {
                    $post_types = Inventor_Post_Types::get_listing_post_types();
                    if (!empty($post_types)) {
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

<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Filter.
     *
     * @class  Inventor_Filter
     *
     * @author Pragmatic Mates
     */
    class Inventor_Filter
    {
        /**
         * Initialize filtering.
         */
        public static function init()
        {
            add_filter('inventor_filter_fields', [__CLASS__, 'default_fields']);
            add_filter('inventor_filter_sort_by_choices', [__CLASS__, 'sort_by_choices']);
            add_action('pre_get_posts', [__CLASS__, 'archive']);
        }

        /**
         * List of default fields defined by plugin.
         *
         * @return array
         */
        public static function default_fields()
        {
            return [
                'listing_type' => __('Listing type', 'inventor'),
                'title' => __('Title', 'inventor'),
                'description' => __('Description', 'inventor'),
                'keyword' => __('Keyword', 'inventor'),
                'distance' => __('Distance', 'inventor'),
                'price' => __('Price', 'inventor'),
                'geolocation' => __('Geolocation', 'inventor'),
                'locations' => __('Locations', 'inventor'),
                'listing_categories' => __('Categories', 'inventor'),
                'featured' => __('Featured', 'inventor'),
                'reduced' => __('Reduced', 'inventor'),
            ];
        }

        /**
         * Returns list of available filter fields templates.
         *
         * @return array
         */
        public static function get_fields()
        {
            return apply_filters('inventor_filter_fields', []);
        }

        /**
         * Returns sort by choices form filter form.
         *
         * @return array
         */
        public static function sort_by_choices($choices)
        {
            $choices['price'] = __('Price', 'inventor');
            $choices['title'] = __('Title', 'inventor');
            $choices['published'] = __('Published', 'inventor');

            return $choices;
        }

        /**
         * Checks if in URI are filter conditions.
         *
         * @return bool
         */
        public static function has_filter($not_empty = false)
        {
            if (!empty($_GET) && is_array($_GET)) {
                foreach ($_GET as $key => $value) {
                    if (strrpos($key, 'filter-', -strlen($key)) !== false) {
                        if (!empty($value) || $not_empty) {
                            return true;
                        }
                    }
                }
            }

            return false;
        }

        /**
         * Gets filter form action.
         *
         * @return false|string
         */
        public static function get_filter_action()
        {
            if (is_post_type_archive(Inventor_Post_Types::get_listing_post_types())) {
                return get_post_type_archive_link(get_post_type());
            }
            if (is_tax(Inventor_Taxonomies::get_listing_taxonomies())) {
                global $wp_query;

                return get_term_link($wp_query->queried_object);
            }

            return get_post_type_archive_link('listing');
        }

        /**
         * Filter listings on archive page.
         *
         * @param $query
         *
         * @return WP_Query|null
         */
        public static function archive($query)
        {
            if ((is_tax(Inventor_Taxonomies::get_listing_taxonomies()) || is_post_type_archive(Inventor_Post_Types::get_listing_post_types(true))) && $query->is_main_query() && !is_admin()) {
                return self::filter_query($query);
            }

            return;
        }

        /**
         * Add params into query object.
         *
         * @param $query
         * @param $params array
         *
         * @return mixed
         */
        public static function filter_query($query = null, $params = null)
        {
            global $wpdb;
            global $wp_query;
            if (empty($query)) {
                $query = $wp_query;
            }
            if (empty($params)) {
                $params = $_GET;
            }
            $meta = [];
            $taxonomies = [];
            $ids = null;
            if (empty($params['filter-sort-by'])) {
                $params['filter-sort-order'] = get_theme_mod('inventor_general_default_listing_order', 'desc');
            }
            if (!empty($params['filter-sort-order'])) {
                $query->set('order', $params['filter-sort-order']);
            }
            if (empty($params['filter-sort-by'])) {
                $params['filter-sort-by'] = get_theme_mod('inventor_general_default_listing_sort', 'published');
            }
            if (!empty($params['filter-sort-by'])) {
                switch ($params['filter-sort-by']) {
                    case 'title':
                        $query->set('orderby', 'title');
                        break;
                    case 'published':
                        $query->set('orderby', 'date');
                        break;
                    case 'price':
                        $query->set('meta_key', INVENTOR_LISTING_PREFIX.'price');
                        $query->set('orderby', 'meta_value_num');
                        break;
                }
            }
            // Custom ordering
            $query = apply_filters('inventor_order_query', $query, $params);
            // Listing post type
            if (!empty($params['filter-listing_types'])) {
                $query->set('post_type', $params['filter-listing_types']);
            }
            // Location
            if (!empty($params['filter-locations'])) {
                $taxonomies[] = [
                    'taxonomy' => 'locations',
                    'field' => 'id',
                    'terms' => $params['filter-locations'],
                ];
            }
            // Category
            if (!empty($params['filter-listing_categories'])) {
                $taxonomies[] = [
                    'taxonomy' => 'listing_categories',
                    'field' => 'id',
                    'terms' => $params['filter-listing_categories'],
                ];
            }
            // Title
            if (!empty($params['filter-title'])) {
                $title_ids
                     = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT ID FROM {$wpdb->posts} WHERE post_status = \"publish\" AND post_title LIKE '%s'",
                    '%'.$params['filter-title'].'%'));
                $ids = self::build_post_ids($ids, $title_ids);
            }
            // Description
            if (!empty($params['filter-description'])) {
                $description_ids
                     = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT ID FROM {$wpdb->posts} WHERE post_status = \"publish\" AND post_content LIKE '%s'",
                    '%'.$params['filter-description'].'%'));
                $ids = self::build_post_ids($ids, $description_ids);
            }
            // Keyword
            if (!empty($params['filter-keyword'])) {
                $keyword_ids
                     = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT ID FROM {$wpdb->posts} WHERE post_status = \"publish\" AND post_content LIKE '%s' OR post_title LIKE '%s'",
                    '%'.$params['filter-keyword'].'%', '%'.$params['filter-keyword'].'%'));
                $ids = self::build_post_ids($ids, $keyword_ids);
            }
            // Custom filtering
            $ids = apply_filters('inventor_filter_query', $ids, $params);
            // Distance
            if (empty($params['filter-distance'])) {
                $params['filter-distance'] = 999999;
            }
            if (!empty($params['filter-distance-latitude']) && !empty($params['filter-distance-longitude']) && !empty($params['filter-distance'])) {
                $distance_ids = [];
                $rows = self::filter_by_distance($params['filter-distance-latitude'],
                    $params['filter-distance-longitude'], $params['filter-distance']);
                foreach ($rows as $row) {
                    $distance_ids[] = $row->ID;
                }
                $ids = self::build_post_ids($ids, $distance_ids);
            }
            // Price from
            if (!empty($params['filter-price-from'])) {
                $meta[] = [
                    'key' => INVENTOR_LISTING_PREFIX.'price',
                    'value' => $params['filter-price-from'],
                    'compare' => '>=',
                    'type' => 'NUMERIC',
                ];
            }
            // Price to
            if (!empty($params['filter-price-to'])) {
                $meta[] = [
                    'key' => INVENTOR_LISTING_PREFIX.'price',
                    'value' => $params['filter-price-to'],
                    'compare' => '<=',
                    'type' => 'NUMERIC',
                ];
            }
            // Featured
            if (!empty($params['filter-featured'])) {
                $meta[] = [
                    'key' => INVENTOR_LISTING_PREFIX.'featured',
                    'value' => 'on',
                ];
            }
            // Reduced
            if (!empty($params['filter-reduced'])) {
                $meta[] = [
                    'key' => INVENTOR_LISTING_PREFIX.'reduced',
                    'value' => 'on',
                ];
            }
            // Post IDs
            if (is_array($ids)) {
                if (count($ids) > 0) {
                    $query->set('post__in', $ids);
                } else {
                    $query->set('post__in', [0]);
                }
            }
            $query->set('post_status', 'publish');
            $query->set('meta_query', $meta);
            $query->set('tax_query', $taxonomies);

            return $query;
        }

        /**
         * Helper method to build an array of post ids.
         * Purpose is to build proper array of post ids which will be used in WP_Query. For certain queries we need
         * an array for post__in so we have to make array intersect, new array or just return null (post__in is not required).
         *
         * @param null|array $haystack
         * @param array      $ids
         *
         * @return null|array
         */
        public static function build_post_ids($haystack, array $ids)
        {
            if (!is_array($haystack)) {
                $haystack = [];
            }
            if (is_array($haystack) && count($haystack) > 0) {
                return array_intersect($haystack, $ids);
            } else {
                $haystack = $ids;
            }

            return $haystack;
        }

        /**
         * Find listings by GPS position matching the distance.
         *
         * @param $latitude
         * @param $longitude
         * @param $distance
         *
         * @return mixed
         */
        public static function filter_by_distance($latitude, $longitude, $distance)
        {
            global $wpdb;
            $radius_km = 6371;
            $radius_mi = 3959;
            $radius = $radius_mi;
            if ('km' == get_theme_mod('inventor_measurement_distance_unit_long', 'mi')) {
                $radius = $radius_km;
            }
            $sql
                = 'SELECT SQL_CALC_FOUND_ROWS ID, ( '.$radius.' * acos( cos( radians('.$latitude.') ) * cos(radians( latitude.meta_value ) ) * cos( radians( longitude.meta_value ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude.meta_value ) ) ) ) AS distance
    				FROM '.$wpdb->prefix.'posts
                    INNER JOIN '.$wpdb->prefix.'postmeta ON ('.$wpdb->prefix.'posts.ID = '.$wpdb->prefix.'postmeta.post_id)
                    INNER JOIN '.$wpdb->prefix.'postmeta AS latitude ON '.$wpdb->prefix.'posts.ID = latitude.post_id
                    INNER JOIN '.$wpdb->prefix.'postmeta AS longitude ON '.$wpdb->prefix.'posts.ID = longitude.post_id
                    WHERE '.$wpdb->prefix.'posts.post_type IN '.self::build_post_types_array_for_sql().'
                        AND '.$wpdb->prefix.'posts.post_status = "publish"
                        AND latitude.meta_key="'.INVENTOR_LISTING_PREFIX.'map_location_latitude"
                        AND longitude.meta_key="'.INVENTOR_LISTING_PREFIX.'map_location_longitude"
					GROUP BY '.$wpdb->prefix.'posts.ID HAVING distance <= '.$distance.';';

            return $wpdb->get_results($sql);
        }

        /**
         * Gets array of post types for SQL.
         *
         * @throws Exception
         *
         * @return string
         */
        public static function build_post_types_array_for_sql()
        {
            $post_types = Inventor_Post_Types::get_listing_post_types();
            if (!is_array($post_types)) {
                throw new Exception('No listing post types found.');
            }
            $string = implode('","', $post_types);

            return sprintf('("%s")', $string);
        }

        /**
         * Tweak for displaying posts without value instead of ignoring them
         * Read more about it here: https://core.trac.wordpress.org/ticket/19653.
         *
         * @param $clauses
         *
         * @return mixed
         */
        public static function filter_get_meta_sql_19653($clauses)
        {
            remove_filter('get_meta_sql', [__CLASS__, 'filter_get_meta_sql_19653']);
            // Change the inner join to a left join,
            // and change the where so it is applied to the join, not the results of the query.
            $clauses['join'] = str_replace('INNER JOIN', 'LEFT JOIN', $clauses['join']).$clauses['where'];
            $clauses['where'] = '';

            return $clauses;
        }
    }

    Inventor_Filter::init();

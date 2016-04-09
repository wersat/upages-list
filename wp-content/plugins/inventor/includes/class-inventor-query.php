<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Query.
     *
     * @class  Inventor_Query
     *
     * @author Pragmatic Mates
     */
    class Inventor_Query
    {
        /**
         * Gets user listings query.
         *
         * @param int $id
         *
         * @return WP_Query
         */
        public static function get_listings_by_user($id)
        {
            return new WP_Query([
                'author' => $id,
                'post_type' => Inventor_Post_Types::get_listing_post_types(),
                'posts_per_page' => -1,
                'post_status' => 'any',
            ]);
        }

        /**
         * Returns listings query by post type.
         *
         * @param string $post_type
         *
         * @return WP_Query
         */
        public static function get_listings_by_post_type($post_type)
        {
            if (!in_array($post_type, Inventor_Post_Types::get_listing_post_types())) {
                return;
            }

            return new WP_Query([
                'post_type' => [$post_type],
                'posts_per_page' => -1,
                'post_status' => 'any',
            ]);
        }

        /**
         * Returns all listings.
         *
         * @return WP_Query
         */
        public static function get_all_listings()
        {
            return self::get_listings();
        }

        /**
         * Returns listings.
         *
         * @return WP_Query
         */
        public static function get_listings($count = -1)
        {
            return new WP_Query([
                'post_type' => Inventor_Post_Types::get_listing_post_types(),
                'posts_per_page' => $count,
                'post_status' => 'any',
            ]);
        }

        /**
         * Sets similar listings into loop.
         *
         * @param null|int $post_id
         */
        public static function loop_listings_similar($post_id = null, $count = 3)
        {
            if (null === $post_id) {
                $post_id = get_the_ID();
            }
            $categories = wp_get_post_terms($post_id, 'listing_categories');
            $categories_ids = [];
            if (!empty($categories) && is_array($categories)) {
                foreach ($categories as $category) {
                    $categories_ids[] = $category->term_id;
                }
            }
            $args = [
                'post_type' => Inventor_Post_Types::get_listing_post_types(),
                'posts_per_page' => $count,
                'orderby' => 'rand',
                'post__not_in' => [$post_id],
            ];
            if (!empty($categories_ids) && is_array($categories_ids) && count($categories_ids) > 0) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'listing_categories',
                        'field' => 'id',
                        'terms' => $categories_ids,
                    ],
                ];
            }
            query_posts($args);
        }

        /**
         * Applies search conditions into current query.
         *
         * @param null|array $params
         */
        public static function loop_listings_filter($params = null)
        {
            global $wp_query;
            $query = Inventor_Filter::filter_query($wp_query, $params);
            $query->posts = $query->get_posts();
            $wp_query = $query;
        }

        /**
         * Gets listing location name.
         *
         * @param null   $post_id
         * @param string $separator
         *
         * @return bool|string
         */
        public static function get_listing_location_name($post_id = null, $separator = '/', $hierarchical = true)
        {
            if (null === $post_id) {
                $post_id = get_the_ID();
            }
            if (!empty($listing_locations[$post_id])) {
                return $listing_locations[$post_id];
            }
            $locations = wp_get_post_terms($post_id, 'locations', [
                'orderby' => 'parent',
                'order' => 'ASC',
            ]);
            if (is_array($locations) && count($locations) > 0) {
                $output = '';
                if (true === $hierarchical) {
                    foreach ($locations as $key => $location) {
                        $output .= '<a href="'.get_term_link($location,
                                'locations').'">'.$location->name.'</a>';
                        if (array_key_exists($key + 1, $locations)) {
                            $output .= ' <span class="separator">'.$separator.'</span> ';
                        }
                    }
                } else {
                    $output = '<a href="'.get_term_link(end($locations),
                            'locations').'">'.end($locations)->name.'</a>';
                }
                $listing_locations[$post_id] = $output;

                return $output;
            }

            return false;
        }

        /**
         * Gets listing category name.
         *
         * @param null $post_id
         *
         * @return bool
         */
        public static function get_listing_category_name($post_id = null)
        {
            $types = wp_get_post_terms($post_id, 'listing_categories');
            if (is_array($types) && count($types) > 0) {
                $depth = -1;
                foreach ($types as $type) {
                    $current_depth = count(get_ancestors($type->term_id, 'listing_categories'));
                    if ($current_depth > $depth) {
                        $listing_type = $type;
                        $depth = $current_depth;
                    }
                }

                return '<a href="'.get_term_link($listing_type).'">'.$listing_type->name.'</a>';
            }

            return false;
        }

        /**
         * Checks if there is another post in query.
         *
         * @return bool
         */
        public static function loop_has_next()
        {
            global $wp_query;
            if ($wp_query->current_post + 1 < $wp_query->post_count) {
                return true;
            }

            return false;
        }
    }

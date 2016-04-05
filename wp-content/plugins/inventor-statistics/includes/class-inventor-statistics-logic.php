<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Statistics_Logic
 *
 * @class Inventor_Statistics_Logic
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Statistics_Logic {
    /**
     * Initialize statistics functionality
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'pre_get_posts', array( __CLASS__, 'save_search_queries' ) );
        add_action( 'template_redirect', array( __CLASS__, 'redirects' ) );
        add_action( 'inventor_listing_content', array( __CLASS__, 'render_listing_popularity' ), 10, 2 );
        add_action( 'inventor_listing_detail', array( __CLASS__, 'render_total_views' ), 2, 1 );
        add_action( 'inventor_submission_list_row', array( __CLASS__, 'render_total_views' ), 2, 1 );

        add_filter( 'inventor_filter_sort_by_choices', array( __CLASS__, 'sort_by_choices' ) );
        add_filter( 'inventor_order_query', array( __CLASS__, 'order_query' ), 10, 2 );
        add_filter( 'the_content', array( __CLASS__, 'save_listing_views' ) );
        add_filter( 'query_vars', array( __CLASS__, 'add_query_vars' ) );
    }
    
    /**
     * Add query vars
     *
     * @access public
     * @param $vars
     * @return array
     */
    public static function add_query_vars( $vars ) {
        $vars[] = 'api-query';
        $vars[] = 'api-listing-views';
        return $vars;
    }

    /**
     * Returns sort by choices form filter form
     *
     * @access public
     * @return array
     */
    public static function sort_by_choices( $choices ) {
        $choices['popularity'] = __( 'Popularity', 'inventor-statistics' );
        return $choices;
    }

    /**
     * Orders query by post views
     *
     * @access public
     * @return object
     */
    public static function order_query( $query, $params ) {
        $sort_by = empty( $params['filter-sort-by'] ) ? null : $params['filter-sort-by'];

        if ( $sort_by == 'popularity' ) {
            $query->set( 'meta_key', INVENTOR_STATISTICS_TOTAL_VIEWS_META );
            $query->set( 'orderby', 'meta_value_num' );

            // Tweak for displaying posts without value instead of ignoring them
            add_filter( 'get_meta_sql', array( 'Inventor_Filter', 'filter_get_meta_sql_19653' ) );
        }

        return $query;
    }

    /**
     * Redirects to functions by query var
     *
     * @access public
     * @return void
     */
    public static function redirects() {
        if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( get_query_var( 'api-query' ) ) {
            header( 'HTTP/1.0 200 OK' );
            header( 'Content-Type: application/json' );

            switch ( $_GET['type'] ) {
                case 'filters_per_day':
                    $data = self::search_queries_filters_per_day();
                    echo json_encode( $data );
                    break;
                case 'price':
                    $data = self::search_queries_price();
                    echo json_encode( $data );
                    break;
                default:
                    $data = self::search_queries_by_key( $_GET['type'] );
                    echo json_encode( $data );
                    break;
            }
            exit();
        }

        if ( get_query_var( 'api-listing-views' ) ) {
            header( 'HTTP/1.0 200 OK' );
            header( 'Content-Type: application/json' );
            $data = self::listing_views_get_statistics_per_day();
            echo json_encode( $data );
            exit();
        }
    }

    /**
     * Saves search query
     *
     * @access public
     * @param $query array
     * @return void
     */
    public static function save_search_queries( $query ) {
        global $wpdb;

        $query_logging = get_theme_mod( 'inventor_statistics_enable_query_logging', false );

        if ( ! $query_logging ) {
            return;
        }

        $suppress_filters = ! empty( $query->query_vars['suppress_filters'] ) ? $query->query_vars['suppress_filters'] : '';
        $listing_post_types = Inventor_Post_Types::get_listing_post_types( true );

        if ( ! is_post_type_archive( $listing_post_types ) || ! $query->is_main_query() || is_admin() || $suppress_filters ) {
            return;
        }

        if ( is_array( $_GET ) && count( $_GET ) > 0 ) {
            foreach ( $_GET as $key => $value ) {
                if ( substr( $key, 0, strlen( 'filter-' ) ) === 'filter-' && ! empty( $value ) ) {
                    $key = str_replace( array( 'filter-', '-' ), array( '', '_' ), $key);

                    $wpdb->insert( $wpdb->prefix . 'query_stats', array(
                        'key'       => $key,
                        'value'     => $value,
                        'created'   => date( 'Y-m-d H:i:s' ),
                    ) );
                }
            }

            $wpdb->insert( $wpdb->prefix . 'query_stats', array(
                'key'       => 'filter',
                'value'     => $_SERVER['REMOTE_ADDR'],
                'created'   => date( 'Y-m-d H:i:s' ),
            ) );
        }
    }

    /**
     * Saves listing view
     *
     * @access public
     * @param $content string
     * @return mixed
     */
    public static function save_listing_views( $content ) {
        global $wpdb;

        $post_id = get_the_ID();

        if ( get_theme_mod( 'inventor_statistics_enable_listing_logging' ) && is_singular( Inventor_Post_Types::get_listing_post_types() ) ) {
            $sql = 'SELECT * FROM ' . $wpdb->prefix . 'listing_stats
            WHERE `key` = "' . $post_id . '" AND
                  `value` = "' . session_id() . '" AND
                  `created` > DATE_SUB(NOW(), INTERVAL 15 MINUTE)';
            $results = $wpdb->get_results( $sql );

            if ( count( $results ) == 0 ) {
                $wpdb->insert( $wpdb->prefix . 'listing_stats', array(
                    'key'       => $post_id,
                    'value'     => session_id(),
                    'ip'        => $_SERVER['REMOTE_ADDR'],
                    'created'   => current_time( 'mysql' ),
                ) );

                // update total views: we need to to be able sort posts by popularity
                update_post_meta( $post_id, INVENTOR_STATISTICS_TOTAL_VIEWS_META, self::listing_views_get_total( $post_id ) );
            }
        }

        return $content;
    }

    /**
     * Search queries price statistics
     *
     * @access public
     * @return array
     */
    public static function search_queries_price() {
        global $wpdb;

        $granularity = 2;

        $data = array(
            array(
                'key'       => __( 'Price from', 'inventor-statistics' ),
                'values'    => array()
            ),
            array(
                'key'       => __( 'Price to', 'inventor-statistics' ),
                'values'    => array()
            ),
        );

        // Price from
        $sql = 'SELECT ROUND(value, -'. $granularity .') as price, COUNT(*) as count FROM ' . $wpdb->prefix . 'query_stats
                WHERE `key` = "price_from"
                GROUP BY price';

        $results = $wpdb->get_results( $sql );

        foreach( $results as $result ) {
            $data[0]['values'][] = array(
                'x'     => (int) $result->count,
                'y'     => (int) $result->price,
                'size'  => (int) $result->count
            );
        }

        // Price to
        $sql = 'SELECT ROUND(value, -'. $granularity .') as price, COUNT(*) as count FROM ' . $wpdb->prefix . 'query_stats
                WHERE `key` = "price_to"
                GROUP BY price';

        $results = $wpdb->get_results( $sql );

        foreach( $results as $result ) {
            $data[1]['values'][] = array(
                'x'     => (int) $result->count,
                'y'     => (int) $result->price,
                'size'  => (int) $result->count
            );
        }

        return $data;
    }

    /**
     * Search queries per day statistics
     *
     * @access public
     * @return array
     */
    public static function search_queries_filters_per_day() {
        global $wpdb;

        $data = array();
        $data[] = array(
            'key'       => __( 'Per day', 'inventor-statistics' ),
            'area'      => true,
            'values'    => array(),
        );

        $sql = 'SELECT DATE(created) as date, COUNT(*) as count FROM ' . $wpdb->prefix . 'query_stats
                WHERE `key` = "filter" AND
                      `created` >= DATE_SUB(NOW(), INTERVAL 2 WEEK)
                GROUP BY date
                ORDER BY date';

        $results = $wpdb->get_results( $sql );

        for ( $i = 13; $i >= 0 ; $i-- ) {
            $date = date( 'Y-m-d', strtotime( '-' . $i . ' days' ) );

            $data[0]['values'][] = array(
                13 - $i, $date, 0
            );
        }

        $index = 1;
        foreach ( $results as $result ) {
            foreach ( $data[0]['values'] as $key => $value ) {
                if ( $value[1] == $result->date ) {
                    $data[0]['values'][$key] = array(
                        $key, $result->date, (int) $result->count
                    );
                }
            }

            $index++;
        }

        return $data;
    }

    /**
     * Search queries statistics by key
     *
     * @access public
     * @return array
     */
    public static function search_queries_by_key( $key ) {
        global $wpdb;

        $sql = 'SELECT name as label, COUNT(*) as value FROM ' . $wpdb->prefix . 'query_stats
                LEFT JOIN wp_terms
                ON value = term_id
                WHERE `key` = "'. $key .'"
                GROUP BY ' . $wpdb->prefix . 'query_stats.value;';

        return $wpdb->get_results( $sql, ARRAY_A );
    }

    /**
     * Listing views popular statistics
     *
     * @access public
     * @param int $count
     * @return mixed
     */
    public static function listing_views_get_popular_listings( $count = 10 ) {
        global $wpdb;

        $sql = 'SELECT `key`, post_title, COUNT(*) as count FROM ' . $wpdb->prefix . 'listing_stats
                LEFT JOIN ' . $wpdb->prefix . 'posts ON ' . $wpdb->prefix . 'posts.ID=' . $wpdb->prefix . 'listing_stats.key
                GROUP BY `key`
                ORDER BY count DESC
                LIMIT ' . $count . ';';

        return $wpdb->get_results( $sql );
    }

    /**
     * Listing views popular locations statistics
     *
     * @access public
     * @param int $count
     * @return mixed
     */
    public static function listing_views_get_popular_locations( $count = 10 ) {
        global $wpdb;

        $sql = 'SELECT wp_term_taxonomy.term_taxonomy_id, taxonomy, COUNT(*) as count FROM ' . $wpdb->prefix . 'listing_stats
                LEFT JOIN ' . $wpdb->prefix . 'term_relationships ON ' . $wpdb->prefix . 'term_relationships.object_id=' . $wpdb->prefix . 'listing_stats.key
                LEFT JOIN ' . $wpdb->prefix . 'term_taxonomy ON ' . $wpdb->prefix . 'term_taxonomy.term_taxonomy_id=' . $wpdb->prefix . 'term_relationships.term_taxonomy_id
                WHERE taxonomy = \'locations\'
                GROUP BY term_taxonomy_id
                ORDER BY count DESC
                LIMIT ' . $count . ';';

        return $wpdb->get_results( $sql );
    }

    /**
     * Listing views per day statistics
     *
     * @access public
     * @return mixed
     */
    public static function listing_views_get_statistics_per_day() {
        global $wpdb;

        $data = array();
        $data[] = array(
            'key'       => __( 'Per day', 'inventor-statistics' ),
            'area'      => true,
            'values'    => array(),
        );

        $sql = 'SELECT DATE(created) as date, COUNT(*) as count FROM ' . $wpdb->prefix . 'listing_stats
                WHERE `created` >= DATE_SUB(NOW(), INTERVAL 2 WEEK)
                GROUP BY date
                ORDER BY date';

        $results = $wpdb->get_results( $sql );

        for ( $i = 13; $i >= 0 ; $i-- ) {
            $date = date( 'Y-m-d', strtotime( '-' . $i . ' days' ) );

            $data[0]['values'][] = array(
                13 - $i, $date, 0
            );
        }

        $index = 1;
        foreach ( $results as $result ) {
            foreach ( $data[0]['values'] as $key => $value ) {
                if ( $value[1] == $result->date ) {
                    $data[0]['values'][$key] = array(
                        $key, $result->date, (int) $result->count
                    );
                }
            }

            $index++;
        }

        return $data;
    }

    /**
     * Gets listing total views
     *
     * @access public
     * @param null $post_id
     * @return int
     */
    public static function listing_views_get_total( $post_id = null ) {
        global $wpdb;

        if ( $post_id == null ) {
            $post_id = get_the_ID();
        }

        $sql = 'SELECT `key`, COUNT(*) as count FROM ' . $wpdb->prefix . 'listing_stats
                WHERE `key` = "' . $post_id . '"
                GROUP BY `key`';

        $results = $wpdb->get_results( $sql );
        if ( is_array( $results ) && count( $results ) > 0 ) {
            return $results[0]->count;
        }

        return 0;
    }

    /**
     * Gets listing weekly progress
     *
     * @access public
     * @param null $post_id
     * @return float|int
     */
    public static function listing_views_get_weekly_progress( $post_id = null ) {
        global $wpdb;

        if ( $post_id == null ) {
            $post_id = get_the_ID();
        }

        // Last week
        $last_week_sql = 'SELECT `key`, COUNT(*) as count FROM ' . $wpdb->prefix . 'listing_stats
                        WHERE   `key` = "' . $post_id . '" AND
                                WEEK(created) = WEEK( current_date ) - 1 AND
                                YEAR(created) = YEAR( current_date );';
        $last_week_results = $wpdb->get_results( $last_week_sql );
        $last_week_count = 0;

        if ( is_array( $last_week_results ) && count( $last_week_results ) > 0 ) {
            $last_week_count = $last_week_results[0]->count;
        }

        // Two weeks ago
        $two_weeks_ago_sql = 'SELECT `key`, COUNT(*) as count FROM ' . $wpdb->prefix . 'listing_stats
                        WHERE   `key` = "' . $post_id . '" AND
                                WEEK(created) = WEEK( current_date ) - 2 AND
                                YEAR(created) = YEAR( current_date );';
        $two_weeks_ago_results = $wpdb->get_results( $two_weeks_ago_sql );

        if ( is_array( $two_weeks_ago_results ) && count( $two_weeks_ago_results ) > 0 ) {
            $two_weeks_ago_count = $two_weeks_ago_results[0]->count;
        }

        if ( $two_weeks_ago_count == 0 && $last_week_count > 0 ) {
            return 100;
        } elseif ( $two_weeks_ago_count == 0 && $last_week_count == 0 ) {
            return 0;
        } elseif ( $two_weeks_ago_count > 0 && $last_week_count == 0 ) {
            return -100;
        } elseif ( $two_weeks_ago_count == $last_week_count ) {
            return 0;
        } elseif ( $two_weeks_ago_count > 0 && $last_week_count > 0 ) {
            return round( ( 100 / $two_weeks_ago_count * $last_week_count ) - 100, 2 );
        }

        return 0;
    }

    /**
     * Renders total post views
     *
     * @access public
     * @param int $listing_id
     * @return void
     */
    public static function render_total_views( $listing_id ) {
        echo Inventor_Template_Loader::load( 'post-total-views', array( 'listing_id' => $listing_id ), $plugin_dir = INVENTOR_STATISTICS_DIR );
    }

    /**
     * Renders listing popularity in archive row
     *
     * @access public
     * @param int $listing_id
     * @param string $display
     * @return void
     */
    public static function render_listing_popularity( $listing_id, $display = null ) {
        echo Inventor_Template_Loader::load( 'listing-archive-views', array( 'listing_id' => $listing_id, 'display' => $display ), $plugin_dir = INVENTOR_STATISTICS_DIR );
    }
}

Inventor_Statistics_Logic::init();
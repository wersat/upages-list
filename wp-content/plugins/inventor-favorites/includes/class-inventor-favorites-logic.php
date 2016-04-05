<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Favorites_Logic
 *
 * @class Inventor_Favorites_Logic
 * @package Inventor_Favorites/Classes
 * @author Pragmatic Mates
 */
class Inventor_Favorites_Logic {
    /**
     * Initialize Favorites functionality
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_filter( 'query_vars', array( __CLASS__, 'add_query_vars' ) );
        add_action( 'template_redirect', array( __CLASS__, 'feed_catch_template' ), 0 );
        add_action( 'wp_ajax_nopriv_inventor_favorites_remove_favorite', array( __CLASS__, 'remove_favorite' ) );
        add_action( 'wp_ajax_inventor_favorites_remove_favorite', array( __CLASS__, 'remove_favorite' ) );
        add_action( 'wp_ajax_nopriv_inventor_favorites_add_favorite', array( __CLASS__, 'add_favorite' ) );
        add_action( 'wp_ajax_inventor_favorites_add_favorite', array( __CLASS__, 'add_favorite' ) );
        add_action( 'inventor_listing_detail', array( __CLASS__, 'render_total_favorite_users' ), 1, 1 );
    }

    /**
     * Adds query vars
     *
     * @access public
     * @param $vars
     * @return array
     */
    public static function add_query_vars( $vars ) {
        $vars[] = 'favorites-feed';
        return $vars;
    }

    /**
     * Removes listing from list
     *
     * @access public
     * @return string
     */
    public static function remove_favorite() {
        header( 'HTTP/1.0 200 OK' );
        header( 'Content-Type: application/json' );

        $data = array();

        if( ! is_user_logged_in() ) {
            $data = array(
                'success' => false,
                'message' => __( 'You need to log in at first.', 'inventor-favorites' ),
            );
        } else if (!empty($_GET['id'])) {
            $favorites = get_user_meta(get_current_user_id(), 'favorites', true);

            if (!empty($favorites) && is_array($favorites)) {
                foreach ($favorites as $key => $listing_id) {
                    if ($listing_id == $_GET['id']) {
                        unset($favorites[$key]);
                    }
                }

                update_user_meta(get_current_user_id(), 'favorites', $favorites);

                $data = array(
                    'success' => true,
                );
            } else {
                $data = array(
                    'success' => false,
                    'message' => __('No favorite listings found.', 'inventor-favorites'),
                );
            }
        } else {
            $data = array(
                'success' => false,
                'message' => __('Listing ID is missing.', 'inventor-favorites'),
            );
        }

        echo json_encode( $data );
        exit();
    }

    /**
     * Adds listing into favorites
     *
     * @access public
     * @return void
     */
    public static function add_favorite() {
        header( 'HTTP/1.0 200 OK' );
        header( 'Content-Type: application/json' );

        $data = array();

        if( ! is_user_logged_in() ) {
            $data = array(
                'success' => false,
                'message' => __( 'You need to log in at first.', 'inventor-favorites' ),
            );
        } else if ( ! empty( $_GET['id'] ) ) {
            $favorites = get_user_meta( get_current_user_id(), 'favorites', true );
            $favorites = ! is_array( $favorites ) ? array() : $favorites;

            if ( empty( $favorites ) ) {
                $favorites = array();
            }

            $post = get_post( $_GET['id'] );
            $post_type = get_post_type( $post->ID );

            if ( ! in_array( $post_type, Inventor_Post_Types::get_listing_post_types() ) ) {
                $data = array(
                    'success' => false,
                    'message' => __( 'This is not listing ID.', 'inventor-favorites' ),
                );
            } else {
                $found = false;

                foreach ( $favorites as $listing_id ) {
                    if ( $listing_id == $_GET['id']) {
                        $found = true;
                        break;
                    }
                }

                if ( ! $found ) {
                    $favorites[] = $post->ID;
                    update_user_meta( get_current_user_id(), 'favorites', $favorites );

                    $data = array(
                        'success' => true,
                    );
                } else {
                    $data = array(
                        'success' => false,
                        'message' => __( 'Listing is already in list', 'inventor-favorites' ),
                    );
                }
            }
        } else {
            $data = array(
                'success' => false,
                'message' => __( 'Listing ID is missing.', 'inventor-favorites' ),
            );
        }

        echo json_encode( $data );
        exit();
    }

    /**
     * Gets list of listings from favorites
     *
     * @access public
     * @return void
     */
    public static function feed_catch_template() {
        if ( get_query_var( 'favorites-feed' ) ) {
            header( 'HTTP/1.0 200 OK' );
            header( 'Content-Type: application/json' );

            $data = array();
            $favorites = get_user_meta( get_current_user_id(), 'favorites', true );

            if ( ! empty( $favorites ) && is_array( $favorites ) ) {
                foreach ( $favorites as $listing_id ) {
                    $post = get_post( $listing_id );

                    $data[] = array(
                        'id'        => $post->ID,
                        'title'     => get_the_title( $post->ID ),
                        'permalink' => get_permalink( $post->ID ),
                        'src'       => wp_get_attachment_url( get_post_thumbnail_id( $post->ID) ),
                    );
                }
            }

            echo json_encode( $data );
            exit();
        }
    }

    /**
     * Checks if listing is in user favorites
     *
     * @access public
     * @param $post_id
     * @return bool
     */
    public static function is_my_favorite( $post_id ) {
        $favorites = get_user_meta( get_current_user_id(), 'favorites', true );
        if ( ! empty( $favorites ) && is_array( $favorites ) ) {
            return in_array( $post_id, $favorites );
        }
        return false;
    }

    /**
     * Gets user favorites
     *
     * @access public
     * @param int $user_id
     * @return WP_Query
     */
    public static function get_favorites_by_user( $user_id = null) {
        if( empty($user_id) ) {
            $user_id = get_current_user_id();
        }
        $favorites = get_user_meta( $user_id, 'favorites', true );
        if( ! is_array( $favorites ) ||  count( $favorites ) == 0 ) {
            $favorites = array( '', );
        }
        return new WP_Query( array(
            'post_type'         => Inventor_Post_Types::get_listing_post_types(),
            'post__in'		    => $favorites,
            'post_status'       => 'any',
        ) );
    }

    /**
     * Sets all user favorites into query
     *
     * @access public
     * @return void
     */
    public static function loop_my_favorites() {
        $paged = ( get_query_var('paged')) ? get_query_var('paged') : 1;
        $favorites = get_user_meta( get_current_user_id(), 'favorites', true );
        if( ! is_array( $favorites ) ||  count( $favorites ) == 0 ) {
            $favorites = array( '', );
        }

        query_posts( array(
            'post_type'     => Inventor_Post_Types::get_listing_post_types(),
            'paged'         => $paged,
            'post__in'		=> $favorites,
            'post_status'   => 'publish',
        ) );
    }

    /**
     * Renders favorite toggle button
     *
     * @access public
     * @param int $listing_id
     * @param bool $hide_if_anonymous
     * @return void
     */
    public static function render_favorite_button( $listing_id, $hide_if_anonymous = false ) {
        if( ! ( ! is_user_logged_in() && $hide_if_anonymous ) ) {
            echo Inventor_Template_Loader::load( 'misc/favorites-button', array( 'listing_id' => $listing_id ), $plugin_dir = INVENTOR_FAVORITES_DIR );
        }
    }

    /**
     * Renders total favorite users info
     *
     * @access public
     * @param int $listing_id
     * @return void
     */
    public static function render_total_favorite_users( $listing_id ) {
        echo Inventor_Template_Loader::load( 'misc/favorites-total', array( 'listing_id' => $listing_id ), $plugin_dir = INVENTOR_FAVORITES_DIR );
    }

    /**
     * Gets count of users who like the post
     *
     * @access public
     * @param int $post_id
     * @return int
     */
    public static function get_post_total_users( $post_id = null ) {
        global $wpdb;

        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        $sql = 'SELECT COUNT(*) as num_users FROM ' . $wpdb->prefix . 'usermeta WHERE meta_key = "favorites" AND meta_value LIKE "%i:' . $post_id . ';%";';

        $results = $wpdb->get_results( $sql );
        if ( ! empty( $results[0] ) ) {
            return $results[0]->num_users;
        }

        return 0;
    }
}

Inventor_Favorites_Logic::init();
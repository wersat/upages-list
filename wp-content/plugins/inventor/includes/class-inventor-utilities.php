<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Utilities
 *
 * @class Inventor_Utilities
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Utilities {
	/**
	 * Initialize utilities
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_filter( 'inventor_listing_title', array( __CLASS__, 'listing_title' ), 10, 2 );
	}

	/**
	 * Alters listing title. Appends verified branding logo.
	 *
	 * @access public
	 * @param string $title
	 * @param int $post_id
	 * @return string
	 */
	public static function listing_title( $title, $post_id ) {
//		$rendered_logo = self::render_logo( $post_id );
		$logo = get_post_meta( $post_id, INVENTOR_LISTING_PREFIX  . 'logo', true );

		if ( ! empty( $logo ) ) {
			$rendered_logo = '<img src="'. $logo .'" class="listing-title-logo">';
			$title = $rendered_logo. ' ' . $title;
		}

		return $title;
	}

	/**
	 * Function checks if the user is signed in and if there is ID attribute
	 * in $_GET, check if the current user is owner.
	 *
	 * @access public
	 * @return void
	 */
	public static function protect() {
		if ( ! is_user_logged_in() ) {
			$login_required_page = get_theme_mod( 'inventor_general_login_required_page', null );
			if ( ! empty( $login_required_page ) ) {
				wp_redirect( get_permalink( $login_required_page ) );
			} else {
				$_SESSION['messages'][] = array( 'warning', __( 'Please sign in before accessing this page.', 'inventor' ) );
				wp_redirect( '/' );
			}
			exit();
		}
		if ( ! empty( $_GET['id'] ) ) {
			$post = get_post( $_GET['id'] );
			if ( $post->post_author != get_current_user_id() ) {
				$_SESSION['messages'][] = array( 'warning', __( 'You are not allowed to access this page.', 'inventor' ) );
				wp_redirect( '/' );
				exit();
			}
		}
	}
	/**
	 * Checks if user allowed to remove post
	 *
	 * @access public
	 * @param $user_id int
	 * @param $item_id int
	 * @return bool
	 */
	public static function is_allowed_to_remove( $user_id, $item_id ) {
		$item = get_post( $item_id );
		if ( ! empty( $item->post_author ) ) {
			if ( $item->post_author == $user_id ) {
				return true;
			}
		}
		return false;
	}
	/**
	 * Gets link for login
	 *
	 * @access public
	 * @return bool|string
	 */
	public static function get_link_for_login() {
		$login_required_page = get_theme_mod( 'inventor_general_login_required_page', null );
		if ( ! empty( $login_required_page ) ) {
			return get_permalink( $login_required_page );
		}
		return false;
	}

	/**
	 * Makes multi dimensional array
	 *
	 * @access public
	 * @param $input array
	 * @return array
	 */
	public static function array_unique_multidimensional( $input ) {
		$serialized = array_map( 'serialize', $input );
		$unique = array_unique( $serialized );
		return array_intersect_key( $input, $unique );
	}

	/**
	 * Gets all pages list
	 *
	 * @access public
	 * @return array
	 */
	public static function get_pages() {
		$pages = array();
		$pages[] = __( 'Not set', 'inventor' );

		foreach ( get_pages() as $page ) {
			$pages[ $page->ID ] = $page->post_title;
		}

		return $pages;
	}

	/**
	 * Sanitize a string from textarea
	 *
	 * check for invalid UTF-8,
	 * Convert single < characters to entity,
	 * strip all tags,
	 * strip octets.
	 *
	 * @param string $str
	 * @return string
	 */
	public static function sanitize_textarea( $str ) {
		$filtered = wp_check_invalid_utf8( $str );

		if ( strpos($filtered, '<') !== false ) {
			$filtered = wp_pre_kses_less_than( $filtered );
			// This will strip extra whitespace for us.
			$filtered = wp_strip_all_tags( $filtered, true );
		}

		$found = false;
		while ( preg_match('/%[a-f0-9]{2}/i', $filtered, $match) ) {
			$filtered = str_replace($match[0], '', $filtered);
			$found = true;
		}

		if ( $found ) {
			// Strip out the whitespace that may now exist after removing the octets.
			$filtered = trim( preg_replace('/ +/', ' ', $filtered) );
		}

		/**
		 * Filter a sanitized textarea string.
		 *
		 * @param string $filtered The sanitized string.
		 * @param string $str      The string prior to being sanitized.
		 */
		return apply_filters( 'sanitize_textarea', $filtered, $str );
	}

	/**
	 * Get UUID
	 *
	 * @access public
	 * @param string $prefix
	 * @return string
	 */
	public static function get_uuid() {
		$chars = md5( uniqid(  rand() ) );
		$uuid  = substr( $chars, 0, 8 ) . '-';
		$uuid .= substr( $chars, 8, 4 ) . '-';
		$uuid .= substr( $chars, 12, 4 ) . '-';
		$uuid .= substr( $chars, 16, 4 ) . '-';
		$uuid .= substr( $chars, 20, 12 );
		return $uuid;
	}

	/**
	 * Short UUID
	 *
	 * @access public
	 * @param string $prefix
	 * @return string
	 */
 	public static function get_short_uuid( $prefix = '') {
	    $uuid = self::get_uuid();
	    $parts = explode( '-', $uuid );
	    return $prefix . $parts[0];
	}
}

Inventor_Utilities::init();
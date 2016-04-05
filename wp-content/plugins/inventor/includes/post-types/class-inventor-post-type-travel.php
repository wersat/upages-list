<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Post_Type_Travel
 *
 * @class Inventor_Post_Type_Travel
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Post_Type_Travel {
	/**
	 * Initialize custom post type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'cmb2_init', array( __CLASS__, 'fields' ) );
		add_filter( 'inventor_shop_allowed_listing_post_types', array( __CLASS__, 'allowed_purchasing' ) );
		add_filter( 'inventor_claims_allowed_listing_post_types', array( __CLASS__, 'allowed_claiming' ) );
	}

	/**
	 * Defines if post type can be claimed
	 *
	 * @access public
	 * @param array $post_types
	 * @return array
	 */
	public static function allowed_claiming( $post_types ) {
		$post_types[] = 'travel';
		return $post_types;
	}

	/**
	 * Defines if post type can be purchased
	 *
	 * @access public
	 * @param array $post_types
	 * @return array
	 */
	public static function allowed_purchasing( $post_types ) {
		$post_types[] = 'travel';
		return $post_types;
	}

	/**
	 * Custom post type definition
	 *
	 * @access public
	 * @return void
	 */
	public static function definition() {
		$labels = array(
			'name'                  => __( 'Travels', 'inventor' ),
			'singular_name'         => __( 'Travel', 'inventor' ),
			'add_new'               => __( 'Add New Travel', 'inventor' ),
			'add_new_item'          => __( 'Add New Travel', 'inventor' ),
			'edit_item'             => __( 'Edit Travel', 'inventor' ),
			'new_item'              => __( 'New Travel', 'inventor' ),
			'all_items'             => __( 'Travels', 'inventor' ),
			'view_item'             => __( 'View Travel', 'inventor' ),
			'search_items'          => __( 'Search Travel', 'inventor' ),
			'not_found'             => __( 'No Travels found', 'inventor' ),
			'not_found_in_trash'    => __( 'No Travels Found in Trash', 'inventor' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Travels', 'inventor' ),
		);

		register_post_type( 'travel',
			array(
				'labels'            => $labels,
				'show_in_menu'	    => 'listings',
				'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author' ),
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => _x( 'travels', 'URL slug', 'inventor' ) ),
				'public'            => true,
				'show_ui'           => true,
				'categories'        => array(),
			)
		);
	}

    /**
     * Defines custom fields
     *
     * @access public
     * @return array
     */
    public static function fields() {
		Inventor_Post_Types::add_metabox( 'travel', array( 'general' ) );

        $cmb = new_cmb2_box( array(
            'id'            => INVENTOR_LISTING_PREFIX . 'travel_details',
            'title'         => __( 'Details', 'inventor' ),
            'object_types'  => array( 'travel' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

		$cmb->add_field( array(
			'name'              => __( 'Travel activities', 'inventor' ),
			'id'                => INVENTOR_LISTING_PREFIX  . 'travel_activity',
			'type'              => 'taxonomy_multicheck_hierarchy',
			'taxonomy'          => 'travel_activities',
		) );

        Inventor_Post_Types::add_metabox( 'travel', array( 'date_interval', 'gallery', 'banner', 'video', 'location', 'date_interval', 'price', 'contact', 'social', 'flags', 'listing_category' ) );
    }
}

Inventor_Post_Type_Travel::init();
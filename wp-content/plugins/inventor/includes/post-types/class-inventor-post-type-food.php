<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Post_Type_Food
 *
 * @class Inventor_Post_Type_Food
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Post_Type_Food {
	/**
	 * Initialize custom post type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'cmb2_init', array( __CLASS__, 'fields' ) );
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
        $post_types[] = 'food';
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
			'name'                  => __( 'Food & Drinks', 'inventor' ),
			'singular_name'         => __( 'Food & Drink', 'inventor' ),
			'add_new'               => __( 'Add New Food & Drink', 'inventor' ),
			'add_new_item'          => __( 'Add New Food & Drink', 'inventor' ),
			'edit_item'             => __( 'Edit Food & Drink', 'inventor' ),
			'new_item'              => __( 'New Food & Drink', 'inventor' ),
			'all_items'             => __( 'Food & Drinks', 'inventor' ),
			'view_item'             => __( 'View Food & Drink', 'inventor' ),
			'search_items'          => __( 'Search Food & Drink', 'inventor' ),
			'not_found'             => __( 'No Food & Drinks found', 'inventor' ),
			'not_found_in_trash'    => __( 'No Food & Drinks Found in Trash', 'inventor' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Food & Drinks', 'inventor' ),
		);

		register_post_type( 'food',
			array(
				'labels'            => $labels,
				'show_in_menu'	    => 'listings',
				'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author' ),
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => _x( 'foods', 'URL slug', 'inventor' ) ),
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
        Inventor_Post_Types::add_metabox( 'food', array( 'general' ) );

        $cmb = new_cmb2_box( array(
            'id'            => INVENTOR_LISTING_PREFIX . 'food_details',
            'title'         => __( 'Details', 'inventor' ),
            'object_types'  => array( 'food' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        $cmb->add_field( array(
            'name'              => __( 'Food kind', 'inventor' ),
            'id'                => INVENTOR_LISTING_PREFIX  . 'food_kind',
            'type'              => 'taxonomy_select',
            'taxonomy'          => 'food_kinds',
        ) );

        $cmb = new_cmb2_box( array(
            'id'            => INVENTOR_LISTING_PREFIX . 'food_menu',
            'title'         => __( 'Meals and drinks menu', 'inventor' ),
            'object_types'  => array( 'food' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        $group = $cmb->add_field( array(
            'id'          => INVENTOR_LISTING_PREFIX . 'food_menu_group',
            'type'        => 'group',
            'options'     => array(
                'group_title'   => __( 'Item', 'inventor' ),
                'add_button'    => __( 'Add Another', 'inventor' ),
                'remove_button' => __( 'Remove', 'inventor' ),
            ),
            'default'     => Inventor_Submission::get_submission_field_value( INVENTOR_LISTING_PREFIX . 'food_menu', INVENTOR_LISTING_PREFIX  . 'food_menu_group' ),
        ) );

        $cmb->add_group_field( $group, array(
            'id'                => INVENTOR_LISTING_PREFIX  . 'food_menu_title',
            'name'              => __( 'Title', 'inventor' ),
            'type'              => 'text',
        ) );

        $cmb->add_group_field( $group, array(
            'id'                => INVENTOR_LISTING_PREFIX  . 'food_menu_description',
            'name'              => __( 'Description', 'inventor' ),
            'type'              => 'text',
        ) );

        $cmb->add_group_field( $group, array(
            'id'                => INVENTOR_LISTING_PREFIX  . 'food_menu_price',
            'name'              => __( 'Price', 'inventor' ),
            'type'              => 'text_money',
            'sanitization_cb'	=> false,
            'before_field'      => Inventor_Price::default_currency_symbol(),
            'description'       => sprintf( __( 'In %s.', 'inventor' ), Inventor_Price::default_currency_code() ),
        ) );

        $cmb->add_group_field( $group, array(
            'id'                => INVENTOR_LISTING_PREFIX  . 'food_menu_serving',
            'name'              => __( 'Serving day', 'inventor' ),
            'type'              => 'text_date_timestamp',
            'description'       => __( 'Leave blank if it is not daily menu', 'inventor' )
        ) );

        $cmb->add_group_field( $group, array(
            'id'                => INVENTOR_LISTING_PREFIX  . 'food_menu_speciality',
            'name'              => __( 'Speciality', 'inventor' ),
            'type'              => 'checkbox',
        ) );

        $cmb->add_group_field($group, array(
            'name'              => __( 'Photo', 'inventor' ),
            'id'                => INVENTOR_LISTING_PREFIX  . 'food_menu_photo',
            'type'              => 'file',
        ) );

        Inventor_Post_Types::add_metabox( 'food', array( 'gallery', 'banner', 'video', 'price', 'flags', 'location', 'opening_hours', 'contact', 'social', 'listing_category' ) );
    }

    /**
     * Gets menu groups
     *
     * @access public
     * @param null $post_id
     * @return array
     */
    public static function get_menu_groups( $post_id = null ) {
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        $groups = array( 'menu' => array(), 'daily_menu' => array() );
        $meals = get_post_meta( $post_id, INVENTOR_LISTING_PREFIX . 'food_menu_group', true );

        if ( is_array( $meals ) ) {
            foreach ( $meals as $meal ) {
                if ( empty( $meal[ INVENTOR_LISTING_PREFIX . 'food_menu_serving' ] ) ) {
                    $groups['menu'][] = $meal;
                } else {
                    $groups['daily_menu'][] = $meal;
                }
            }
        }

        return $groups;
    }
}

Inventor_Post_Type_Food::init();
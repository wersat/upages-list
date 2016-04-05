<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Customizations_General
 *
 * @class Inventor_Customizations_General
 * @package Inventor/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Customizations_General {
	/**
	 * Initialize customization type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'customize_register', array( __CLASS__, 'customizations' ) );
	}

	/**
	 * Customizations
	 *
	 * @access public
	 * @param object $wp_customize
	 * @return void
	 */
	public static function customizations( $wp_customize ) {
		$pages = Inventor_Utilities::get_pages();

		$wp_customize->add_section( 'inventor_general', array(
			'title' 	=> __( 'Inventor General', 'inventor' ),
			'priority' 	=> 1,
		) );	

		// Post Types
		$post_types = Inventor_Post_Types::get_all_listing_post_types();
		$types = array();

		if ( is_array( $post_types ) ) {
			foreach ( $post_types as $obj ) {
				if ( apply_filters( 'inventor_listing_type_supported', true, $obj->name ) ) {
					$types[ $obj->name ] = $obj->labels->name;
				}
			}
		}

		$wp_customize->add_setting( 'inventor_general_post_types', array(
			'default'           => $types,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( 'Inventor_Customize_Control_Checkbox_Multiple', 'sanitize' ),
		) );

		$wp_customize->add_control( new Inventor_Customize_Control_Checkbox_Multiple(
			$wp_customize,
			'inventor_general_post_types',
			array(
				'section'       => 'inventor_general',
				'label'         => __( 'Post types', 'inventor' ),
				'choices'       => $types,
				'description'   => __( 'After changing post types make sure that your resave permalinks in "Settings - Permalinks"', 'inventor' ),
			)
		) );

		// Default listing sorting
		$wp_customize->add_setting( 'inventor_general_default_listing_sort', array(
			'default'           => 'published',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_general_default_listing_sort', array(
			'type'          => 'select',
			'label'         => __( 'Default sorting for listing archive', 'inventor' ),
			'section'       => 'inventor_general',
			'settings'      => 'inventor_general_default_listing_sort',
			'choices'		=> apply_filters( 'inventor_filter_sort_by_choices', array() )
		) );

		// Default listing ordering by
		$wp_customize->add_setting( 'inventor_general_default_listing_order', array(
			'default'           => 'desc',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_general_default_listing_order', array(
			'type'          => 'select',
			'label'         => __( 'Default ordering for listing archive', 'inventor' ),
			'section'       => 'inventor_general',
			'settings'      => 'inventor_general_default_listing_order',
			'choices'		=> array(
				'asc'			=> 'Ascending',
				'desc'			=> 'Descending',
			),
		) );

		// Log in after registration
		$wp_customize->add_setting( 'inventor_log_in_after_registration', array(
			'default'           => null,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_log_in_after_registration', array(
			'type'          => 'checkbox',
			'label'         => __( 'Automatically log user in after registration', 'inventor' ),
			'section'       => 'inventor_general',
			'settings'      => 'inventor_log_in_after_registration',
		) );

		// Show listing archive as grid
		$wp_customize->add_setting( 'inventor_general_show_listing_archive_as_grid', array(
			'default'           => false,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_general_show_listing_archive_as_grid', array(
			'type'      => 'checkbox',
			'label'     => __( 'Show listing archive as grid', 'inventor' ),
			'section'   => 'inventor_general',
			'settings'  => 'inventor_general_show_listing_archive_as_grid',
		) );

		// Purchase code
		$wp_customize->add_setting( 'inventor_purchase_code', array(
			'default'           => null,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_purchase_code', array(
			'type'          => 'text',
			'label'         => __( 'Purchase code', 'inventor' ),
			'section'       => 'inventor_general',
			'settings'      => 'inventor_purchase_code',
		) );

		// Google browser API key
		$wp_customize->add_setting( 'inventor_general_google_browser_key', array(
			'default'           => null,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_general_google_browser_key', array(
			'type'          => 'text',
			'label'         => __( 'Google Browser Key', 'inventor' ),
			'description'   => __( 'Browser API key. Read more <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a>.', 'inventor' ),
			'section'       => 'inventor_general',
			'settings'      => 'inventor_general_google_browser_key',
		) );
	}
}

Inventor_Customizations_General::init();

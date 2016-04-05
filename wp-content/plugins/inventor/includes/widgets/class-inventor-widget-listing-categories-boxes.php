<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Widget_Listing_Categories_Boxes
 *
 * @class Inventor_Widget_Listing_Categories_Boxes
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Widget_Listing_Categories_Boxes extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 * @return void
	 */
	function Inventor_Widget_Listing_Categories_Boxes() {
		parent::__construct(
			'listing_categories_boxes',
			__( 'Listing Categories Boxes', 'inventor' ),
			array(
				'description' => __( 'Displays listing categories in boxes.', 'inventor' ),
			)
		);
	}

	/**
	 * Frontend
	 *
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		$data = array(
			'hide_empty'    => false,
			'parent'        => 0
		);

		if ( ! empty( $instance['listing_categories'] ) && is_array( $instance['listing_categories'] ) && count( $instance['listing_categories'] ) > 0 ) {
			$data['include'] = implode( ',', $instance['listing_categories'] );
		}

		$terms = get_terms( 'listing_categories', $data );
		include Inventor_Template_Loader::locate( 'widgets/listing-categories-boxes' );

		wp_reset_query();
	}

	/**
	 * Update
	 *
	 * @access public
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	/**
	 * Backend
	 *
	 * @access public
	 * @param array $instance
	 * @return void
	 */
	function form( $instance ) {
		include Inventor_Template_Loader::locate( 'widgets/listing-categories-boxes-admin' );
		include Inventor_Template_Loader::locate( 'widgets/advanced-options-admin' );
	}
}
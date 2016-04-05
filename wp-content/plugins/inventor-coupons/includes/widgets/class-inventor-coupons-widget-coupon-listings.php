<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Coupons_Widget_Coupon_Listings
 *
 * @class Inventor_Coupons_Widget_Coupon_Listings
 * @package Inventor_Coupons/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Coupons_Widget_Coupon_Listings extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 * @return void
	 */
	function Inventor_Coupons_Widget_Coupon_Listings() {
		parent::__construct(
			'coupon_listings',
			__( 'Coupon Listing', 'inventor-coupons' ),
			array(
				'description' => __( 'Coupon listing.', 'inventor-coupons' ),
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
		$query = array(
			'post_type'         => 'coupon',
			'posts_per_page'    => ! empty( $instance['count'] ) ? $instance['count'] : 3,
			'meta_query'        => Inventor_Coupons_Logic::get_condition(),
		);

		query_posts( $query );

		include Inventor_Template_Loader::locate( 'widgets/coupon-listings', INVENTOR_COUPONS_DIR );

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
		include Inventor_Template_Loader::locate( 'widgets/coupon-listings-admin', INVENTOR_COUPONS_DIR );
	}
}
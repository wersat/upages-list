<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Widget_Listings
 *
 * @class Inventor_Widget_Listings
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Widget_Listings extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 * @return void
	 */
	function Inventor_Widget_Listings() {
		parent::__construct(
			'listings',
			__( 'Listings', 'inventor' ),
			array(
				'description' => __( 'Displays listings.', 'inventor' ),
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
			'post_type'         => Inventor_Post_Types::get_listing_post_types(),
			'posts_per_page'    => ! empty( $instance['count'] ) ? $instance['count'] : 3,
			'tax_query'         => array(
				'relation'      => 'AND',
			),
		);

		if ( ! empty( $instance['order'] ) ) {
			if ( 'rand' == $instance['order'] ) {
				$query['orderby'] = 'rand';
			}

			if ( 'ids' == $instance['order'] ) {
				$query['orderby'] = 'post__in';
			}
		}

		if ( ! empty( $instance['attribute'] ) ) {
			if ( 'featured' == $instance['attribute'] ) {
				$query['meta_query'][] = array(
					'key'       => INVENTOR_LISTING_PREFIX . 'featured',
					'value'     => 'on',
					'compare'   => '=',
				);
			} elseif ( 'reduced' == $instance['attribute'] ) {
				$query['meta_query'][] = array(
					'key'       => INVENTOR_LISTING_PREFIX . 'reduced',
					'value'     => 'on',
					'compare'   => '=',
				);
			}
		}

		if ( ! empty( $instance['listing_types'] ) && is_array( $instance['listing_types'] ) ) {
			$query['post_type'] = $instance['listing_types'];
		}

		if ( ! empty( $instance['listing_categories'] ) && is_array( $instance['listing_categories'] ) ) {
			$query['tax_query'][] = array(
				'taxonomy'  => 'listing_categories',
				'field'     => 'id',
				'terms'     => $instance['listing_categories'],
			);
		}

		if ( ! empty( $instance['locations'] ) && is_array( $instance['locations'] ) ) {
			$query['tax_query'][] = array(
				'taxonomy'  => 'locations',
				'field'     => 'id',
				'terms'     => $instance['locations'],
			);
		}

		if ( ! empty( $instance['ids'] ) ) {
			$ids = explode( ',', $instance['ids'] );
			$query['post__in'] = $ids;
		}

		query_posts( $query );
		include Inventor_Template_Loader::locate( 'widgets/listings' );

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
		include Inventor_Template_Loader::locate( 'widgets/listings-admin' );
		include Inventor_Template_Loader::locate( 'widgets/advanced-options-admin' );
	}
}
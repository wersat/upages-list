<?php
/**
 * Widget definition file
 *
 * @package Superlist
 * @subpackage Widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Superlist_Widget_Cover
 *
 * @class Superlist_Widget_Cover
 * @package Superlist/Widgets
 * @author Pragmatic Mates
 */
class Superlist_Widget_Video_Cover extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 * @return void
	 */
	function Superlist_Widget_Video_Cover() {
		parent::__construct(
			'video_cover',
			__( 'Video Cover', 'superlist' ),
			array(
				'description' => __( 'Displays small filter with video or image background.', 'superlist' ),
			)
		);
	}

	/**
	 * Frontend
	 *
	 * @access public
	 * @param array $args Widget arguments.
	 * @param array $instance Current widget instance.
	 * @return void
	 */
	function widget( $args, $instance ) {
		include 'templates/widget-video-cover.php';
	}

	/**
	 * Update
	 *
	 * @access public
	 * @param array $new_instance New widget instance.
	 * @param array $old_instance Old widget instance.
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	/**
	 * Backend
	 *
	 * @access public
	 * @param array $instance Current widget instance.
	 * @return void
	 */
	function form( $instance ) {
		include 'templates/widget-video-cover-admin.php';
	}
}

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Shortcodes
 *
 * @class Inventor_Shortcodes
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Shortcodes {
	/**
	 * Initialize shortcodes
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'wp', array( __CLASS__, 'check_logout' ) );

		add_shortcode( 'inventor_breadcrumb', array( __CLASS__, 'breadcrumb' ) );
		add_shortcode( 'inventor_logout', array( __CLASS__, 'logout' ) );
		add_shortcode( 'inventor_login', array( __CLASS__, 'login' ) );
		add_shortcode( 'inventor_reset_password', array( __CLASS__, 'reset_password' ) );
		add_shortcode( 'inventor_register', array( __CLASS__, 'register' ) );
		add_shortcode( 'inventor_password', array( __CLASS__, 'password' ) );
		add_shortcode( 'inventor_payment', array( __CLASS__, 'payment' ) );
		add_shortcode( 'inventor_profile', array( __CLASS__, 'profile' ) );
		add_shortcode( 'inventor_transactions', array( __CLASS__, 'transactions' ) );
		add_shortcode( 'inventor_report_form', array( __CLASS__, 'report_form' ) );
		add_shortcode( 'inventor_submission', array( __CLASS__, 'submission' ) );
		add_shortcode( 'inventor_submission_steps', array( __CLASS__, 'submission_steps' ) );
		add_shortcode( 'inventor_submission_remove', array( __CLASS__, 'submission_remove' ) );
		add_shortcode( 'inventor_submission_list', array( __CLASS__, 'submission_list' ) );
	}

	/**
	 * Logout checker
	 *
	 * @access public
	 * @param $wp
	 * @return void
	 */
	public static function check_logout( $wp ) {
		$post = get_post();

		if ( is_object( $post ) ) {
			if ( strpos( $post->post_content, '[inventor_logout]' ) !== false ) {
				$_SESSION['messages'][] = array( 'success', __( 'You have been successfully logged out.', 'inventor' ) );
				wp_redirect( html_entity_decode( wp_logout_url( home_url( '/' ) ) ) );
				exit();
			}
		}
	}

	/**
	 * Breadcrumb
	 *
	 * @access public
	 * @param $atts|array
	 * @return string
	 */
	public static function breadcrumb( $atts = array() ) {
		return Inventor_Template_Loader::load( 'misc/breadcrumb' );
	}

	/**
	 * Logout
	 *
	 * @access public
	 * @param $atts|array
	 * @return void
	 */
	public static function logout( $atts = array() ) {}

	/**
	 * Login
	 *
	 * @access public
	 * @param $atts|array
	 * @return string
	 */
	public static function login( $atts = array() ) {
		return Inventor_Template_Loader::load( 'accounts/login' );
	}

	/**
	 * Reset
	 *
	 * @access public
	 * @param $atts|array
	 * @return string
	 */
	public static function reset_password( $atts = array() ) {
		return Inventor_Template_Loader::load( 'accounts/reset' );
	}

	/**
	 * Register
	 *
	 * @access public
	 * @param $atts|array
	 * @return string
	 */
	public static function register( $atts = array() ) {
		return Inventor_Template_Loader::load( 'accounts/register' );
	}

	/**
	 * Submission steps
	 *
	 * @param $atts
	 * @param $atts|array
	 * @return string
	 */
	public static function submission_steps( $atts = array() ) {		
		$post_type = ! empty( $_GET['type'] ) ? $_GET['type'] : null;
		$steps = Inventor_Submission::get_submission_steps( $post_type );
		$first_step = ( is_array( $steps ) && count( $steps ) > 0 ) ? $steps[0]['id'] : null;
		$current_step = ! empty( $_GET['step'] ) ? $_GET['step'] : $first_step;

		return Inventor_Template_Loader::load( 'submissions/steps', array(
			'steps'         => $steps,
			'post_type'     => $post_type,
			'current_step'  => $current_step,
		) );
	}

	/**
	 * Submission
	 *
	 * @access public
	 * @param $atts|array
	 * @return string|null
	 */
	public static function submission( $atts = array() ) {
		if ( ! is_user_logged_in() ) {
			echo Inventor_Template_Loader::load( 'misc/not-allowed' );
			return null;
		}

        $object_id = ! empty( $_GET['id'] ) ? $_GET['id'] : false;
        if ( empty( $post_id ) && ! empty( $_POST['object_id'] ) ) {
            $object_id = $_POST['object_id'];
        }

        if ( empty( $object_id ) && ! Inventor_Submission::is_allowed_to_add_submission( get_current_user_id() ) ) {
            echo Inventor_Template_Loader::load( 'misc/not-allowed' , array(
                'message' => __( 'Check your package.', 'inventor' )  // TODO: move to inventor-packages or use filter
            ));

            return null;
        }

        $post_type = ! empty( $_GET['type'] ) ? $_GET['type'] : null;

		// Post type reference in URL not found
		if ( empty( $post_type ) ) {
			return Inventor_Template_Loader::load( 'submissions/type-not-found' );
		}

        // if object_id is empty, user wants to submit new post
        if ( empty( $object_id ) ) {
            $object_id = 'fake-id';
        }

		$steps = Inventor_Submission::get_submission_steps( $post_type );

		// No steps defined for current post type
		if ( is_array( $steps ) && count( $steps ) == 0 ) {
			return Inventor_Template_Loader::load( 'submissions/steps-not-found' );
		}

		$current_step = ! empty( $_GET['step'] ) ? $_GET['step'] : $steps[0]['id'];
		$meta_box = cmb2_get_metabox( $current_step, $object_id );

		$post_type_object = get_post_type_object( $post_type );

		$title = Inventor_Template_Loader::load( 'submissions/step-title', array(
			'steps'         		=> $steps,
			'current_step'  		=> $current_step,
			'listing_type_title'	=> $post_type_object->labels->singular_name
		) );

		$save_button = empty( $_GET['id'] ) ? __( 'Proceed to next step', 'inventor' ) : __( 'Save', 'inventor' );
		$action = empty( $_GET['id'] ) ? '' : '&action=save';

		return cmb2_get_metabox_form( $meta_box, $object_id, array(
			'form_format' => '<form action="//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $action . '" class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"> ' . $title . '<input type="hidden" name="object_id" value="%2$s">%3$s<input type="submit" name="submit-submission" value="%4$s" class="button"></form>',
			'save_button' => $save_button,
		) );
	}

	/**
	 * Remove submission
	 *
	 * @access public
	 * @param $atts|array
	 * @return void
	 */
	public static function submission_remove( $atts = array() ) {
		if ( ! is_user_logged_in() || empty( $_GET['id'] ) ) {
			echo Inventor_Template_Loader::load( 'misc/not-allowed' );
			return;
		}

		$post = get_post( $_GET['id'] );
		if ( empty( $post ) ) {
			echo Inventor_Template_Loader::load( 'misc/object-does-not-exist' );
			return;
		}

		$is_allowed = Inventor_Utilities::is_allowed_to_remove( get_current_user_id(), $_GET['id'] );
		if ( ! $is_allowed ) {
			echo Inventor_Template_Loader::load( 'misc/not-allowed' );
			return;
		}

		$atts = array(
			'listing' => Inventor_Post_Types::get_listing( $_GET['id'] )
		);

		echo Inventor_Template_Loader::load( 'misc/remove-form', $atts );
	}

	/**
	 * Submission index
	 *
	 * @access public
	 * @param $atts
	 * @return void|string
	 */
	public static function submission_list( $atts = array() ) {
        if ( ! is_user_logged_in() ) {
            return Inventor_Template_Loader::load( 'misc/not-allowed' );
		}

        return Inventor_Template_Loader::load( 'submissions/list' );
	}

	/**
	 * Submission payment
	 *
	 * @access public
	 * @param $atts
	 * @return string
	 */
	public static function payment( $atts = array() ) {
		if ( ! is_user_logged_in() ) {
			return Inventor_Template_Loader::load( 'misc/not-allowed' );
		}

		return Inventor_Template_Loader::load( 'payment/payment-form' );
	}

	/**
	 * Transactions
	 *
	 * @access public
	 * @param $atts
	 * @return string
	 */
	public static function transactions( $atts = array() ) {
		if ( ! is_user_logged_in() ) {
			return Inventor_Template_Loader::load( 'misc/not-allowed' );
		}

		return Inventor_Template_Loader::load( 'payment/transactions' );
	}

	/**
	 * Report form
	 *
	 * @access public
	 * @param $atts
	 * @return void
	 */
	public static function report_form( $atts = array() ) {
		$atts = array(
			'listing' => Inventor_Post_Types::get_listing( $_GET['id'] )
		);

		echo Inventor_Template_Loader::load( 'misc/report-form', $atts );
	}

	/**
	 * Change password
	 *
	 * @access public
	 * @param $atts
	 * @return string
	 */
	public static function password( $atts = array() ) {
		if ( ! is_user_logged_in() ) {
			return Inventor_Template_Loader::load( 'misc/not-allowed' );
		}

		return Inventor_Template_Loader::load( 'accounts/password' );
	}

	/**
	 * Change profile
	 *
	 * @access public
	 * @param $atts
	 * @return string
	 */
	public static function profile( $atts = array() ) {
		if ( ! is_user_logged_in() ) {
			return Inventor_Template_Loader::load( 'misc/not-allowed' );
		}

		$form = cmb2_get_metabox_form( INVENTOR_USER_PREFIX  . 'profile', get_current_user_id(), array(
			'form_format' => '<form action="//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<input type="submit" name="submit-profile" value="%4$s" class="button"></form>',
			'save_button' => __( 'Save profile', 'inventor' ),
		) );

		return Inventor_Template_Loader::load( 'accounts/profile', array(
			'form' => $form,
		) );
	}
}

Inventor_Shortcodes::init();

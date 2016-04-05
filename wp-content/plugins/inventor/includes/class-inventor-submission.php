<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Submission
 *
 * @class Inventor_Submission
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Submission {
    /**
     * Initialize submission
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'process_remove_form' ), 9999 );
        add_action( 'cmb2_init', array( __CLASS__, 'process_submission' ), 9999 );
        add_action( 'transition_post_status', array( __CLASS__, 'update_general_metabox_fields' ), 10, 3 );
    }

    /**
     * Checks if user is allowed to add submission
     *
     * @access public
     * @param $user_id
     * @return bool
     */
    public static function is_allowed_to_add_submission( $user_id ) {
        return apply_filters( 'inventor_submission_can_user_create', true, $user_id );
    }

    /**
     * Get list of all steps needed to create new submission
     *
     * @access public
     * @param $post_type
     * @return array
     */
    public static function get_submission_steps( $post_type ) {
        if ( $post_type == null ) {
            return array();
        }

        $meta_boxes = CMB2_Boxes::get_all();
        $steps = array();

        if ( ! empty( $meta_boxes ) ) {
            foreach ( $meta_boxes as $meta_box ) {
                $parts = explode( '_', $meta_box->cmb_id );

                if ( strpos( $meta_box->cmb_id, $post_type ) === strlen( $parts[0] ) + 1 ) {
//                if ( in_array( $post_type, $meta_box->meta_box['object_types'] ) ) {  # TODO: Fix listing slider bug
                    $metabox_key = Inventor_Metaboxes::get_metabox_key( $meta_box->cmb_id, $post_type );

                    // TODO: add setting to hide submission step if not allowed by user package
//                    if ( apply_filters( 'inventor_submission_listing_metabox_allowed', true, $metabox_key, get_current_user_id() ) ) {
                        $steps[] = array(
                            'id'    => $meta_box->cmb_id,
                            'title' => $meta_box->meta_box['title'],
                        );
//                    }
                }
            }
        }

        return $steps;
    }

    /**
     * Get next submission step
     *
     * @access public
     * @param $post_type
     * @param $current_step
     * @return string|bool
     */
    public static function get_next_step( $post_type, $current_step ) {
        $steps = self::get_submission_steps( $post_type );
        $index = 0;

        foreach ( $steps as $step ) {
            if ( $step['id'] == $current_step ) {
                if ( array_key_exists( $index + 1, $steps ) ) {
                    return $steps[$index + 1]['id'];
                }
            }

            $index++;
        }

        return false;
    }

    /**
     * Process submission form
     *
     * @access public
     * @return void
     */
    public static function process_submission() {
        $valid_type = ! empty( $_GET['type'] ) && in_array( $_GET['type'], Inventor_Post_Types::get_listing_post_types() );

        if ( $valid_type ) {
            $steps = self::get_submission_steps( $_GET['type'] );
            $step = ! empty( $_GET['step'] ) ? $_GET['step'] : $steps[0]['id'];
        }

        if ( empty( $step ) ) {
            return;
        }

        self::process_submission_step( $step, $_POST );

        if ( $valid_type && ! empty( $_GET['action'] ) && $_GET['action'] == 'save' ) {
            $post_id = self::process_submission_save( $_GET['type'] );
            $review_before_submission = get_theme_mod( 'inventor_submission_review_before', false );

            $url = home_url();

            if ( $review_before_submission ) {
                // if review before submission, redirect to my listings page (if exists)
                $submission_list_page = get_theme_mod( 'inventor_submission_list_page', false );
                if ( ! empty( $submission_list_page ) ) {
                    $url = get_permalink( $submission_list_page );
                }
            } else {
                // if not review before submission, redirect to post detail
                $url = get_permalink( $post_id );
            }

            wp_redirect( $url );
            exit();
        }

        if ( ! empty( $_POST ) && ! empty( $_POST['submit-submission'] ) ) {
            $next_step = self::get_next_step( $_GET['type'], $step );

            if ( false === $next_step ) {
                if ( ! empty( $_GET['id'] ) ) {
                    $url = sprintf( '?type=%s&action=%s&id=%s', $_GET['type'], 'save', $_GET['id'] );
                } else {
                    $url = sprintf( '?type=%s&action=%s', $_GET['type'], 'save' );
                }
            } else {
                if ( ! empty( $_GET['id'] ) ) {
                    $url = sprintf( '?type=%s&step=%s&id=%s', $_GET['type'], $next_step, $_GET['id'] );
                } else {
                    $url = sprintf( '?type=%s&step=%s', $_GET['type'], $next_step );
                }
            }

            wp_redirect($url);
            exit();
        }
    }

	/**
	 * Save submission
	 *
	 * @access public
	 * @param $post_type
	 * @return int
	 */
    public static function process_submission_save( $post_type ) {
        $post_id       = ! empty( $_GET['id'] ) ? $_GET['id'] : false;
        $review_before = get_theme_mod( 'inventor_submission_review_before', false );
        $post_status   = 'publish';

        if ( $review_before && get_post_status( $post_id ) != 'publish' ) {
            $post_status = 'pending';
        }

        // If we are updating the post get old one. We need old post to set proper
        // post_date value because just modified post will be at the top in archive pages.
        if ( ! empty( $post_id ) ) {
            $old_post  = get_post( $post_id );
            $post_date = $old_post->post_date;
            $comment_status = $old_post->comment_status;
        } else {
            $post_date = '';
            $comment_status = '';
        }

        $description = self::get_submission_field_value( 
            INVENTOR_LISTING_PREFIX . $post_type . '_general', 
            INVENTOR_LISTING_PREFIX  . 'description' 
        );

        $data = array(
            'post_title'        => sanitize_text_field( self::get_submission_field_value( INVENTOR_LISTING_PREFIX . $post_type . '_general', INVENTOR_LISTING_PREFIX  . 'title' ) ),
            'post_author'       => get_current_user_id(),
            'post_status'       => $post_status,
            'post_type'         => $post_type,
            'post_date'         => $post_date,
            'post_content'      => wp_kses( $description, wp_kses_allowed_html( 'post' ) ),
            'comment_status'    => $comment_status
        );

        if ( ! empty( $post_id ) ) {
            $new_post = false;
            $data['ID'] = $post_id;
        } else {
            $new_post = true;
        }

        $post_id = wp_insert_post( $data, true );

        if ( ! empty( $post_id ) ) {
            $_POST['object_id'] = $post_id;
            $post_id = $_POST['object_id'];

            if ( ! empty( $_SESSION['submission'] ) ) {
                foreach ( $_SESSION['submission'] as $key => $value ) {
                    $cmb = cmb2_get_metabox( $key, $post_id );

                    // TODO: check if $cmb is not empty
                    $cmb->save_fields( $post_id, $cmb->object_type(), $_SESSION['submission'][ $key ] );
                }

                // Create featured image
                $featured_image_id = self::get_submission_field_value( INVENTOR_LISTING_PREFIX . $post_type . '_general', INVENTOR_LISTING_PREFIX  . 'featured_image_id' );

                if ( ! empty( $featured_image_id ) ) {
                    set_post_thumbnail( $post_id, $featured_image_id );
                } else {
                    update_post_meta( $post_id, INVENTOR_LISTING_PREFIX  . 'featured_image_id', null );
                    delete_post_thumbnail( $post_id );
                }

                unset( $_SESSION['submission'] );
            }

            if ( $new_post ) {
                // action
                do_action( 'inventor_submission_listing_created', $post_id, $post_type );

                // message
                $_SESSION['messages'][] = array( 'success', __( 'New submission has been successfully created.', 'inventor' ) );
            } else {
                // action
                do_action( 'inventor_submission_listing_updated', $post_id, $post_type );

                // message
                $_SESSION['messages'][] = array( 'success', __( 'Submission has been successfully updated.', 'inventor' ) );
            }
        }

        return $post_id;
    }

    /**
     * Process submission step and save data into session
     *
     * @access public
     * @param $step
     * @param $raw
     * @return void
     */
    public static function process_submission_step( $step, $raw ) {
        $data = array();

        foreach( $raw as $key => $value ) {
            $parts = explode( '_', $key );

            if ( INVENTOR_LISTING_PREFIX == $parts[0] . '_' ) {
                if ( ! empty( $value ) ) {
                    $data[ $key ] = $value;
                }
            }
        }

        if ( is_array( $data ) && count( $data ) > 0 ) {
            $_SESSION['submission'][ $step ] = $data;
        }
    }

    /**
     * Get default field value for front end submission forms.
     * Default value is set for if value was not stored before.
     *
     * @param $meta_box_id
     * @param $field_id
     * @return null|string
     */
    public static function get_submission_field_value( $meta_box_id, $field_id ) {
        if ( ! is_admin() ) {
            if ( ! empty( $_SESSION['submission'] ) && ! empty( $_SESSION['submission'][ $meta_box_id ] ) && ! empty( $_SESSION['submission'][ $meta_box_id ][ $field_id ] ) ) {
                return $_SESSION['submission'][ $meta_box_id ][ $field_id ];
            } elseif ( ! empty( $_GET['id'] ) ) {
                if ( INVENTOR_LISTING_PREFIX . 'title' == $field_id ) {
                    return get_the_title( $_GET['id'] );
                } elseif ( INVENTOR_LISTING_PREFIX . 'description' == $field_id ) {
                    $post = get_post( $_GET['id'] );
                    return $post->post_content;
                } elseif ( INVENTOR_LISTING_PREFIX . 'featured_image' == $field_id ) {
                    return wp_get_attachment_url( get_post_thumbnail_id( $_GET['id'] ) );
                }

                return get_post_meta( $_GET['id'], $field_id, true );
            }
        }

        return null;
    }

    /**
     * General metabox uses native WordPress fields.
     * It is necessary to update CMB2 fields every time listing is updated in WP admin.
     *
     * @access public
     * @param $new_status
     * @param $old_status
     * @param $post
     * @return void
     */
    public static function update_general_metabox_fields( $new_status, $old_status, $post ) {
        if ( ! is_admin() ) {
            return;
        }

        $post_type = get_post_type( $post );
        $listing_post_types = Inventor_Post_Types::get_listing_post_types();

        if ( ! in_array( $post_type, $listing_post_types ) ) {
            return;
        }

        update_post_meta( $post->ID, INVENTOR_LISTING_PREFIX . 'title', get_the_title( $post->ID ) );
        update_post_meta( $post->ID, INVENTOR_LISTING_PREFIX . 'description', $post->post_content );
        update_post_meta( $post->ID, INVENTOR_LISTING_PREFIX . 'featured_image', wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) );
    }

    /**
     * Process remove listing form
     *
     * @access public
     * @return void
     */
    public static function process_remove_form() {
        if ( ! isset( $_POST['remove_listing_form'] ) || empty( $_POST['listing_id'] ) ) {
            return;
        }

        if ( wp_delete_post( $_POST['listing_id'] ) ) {
			$_SESSION['messages'][] = array( 'success', __( 'Item has been successfully removed.', 'inventor' ) );
		} else {
			$_SESSION['messages'][] = array( 'danger', __( 'An error occurred when removing an item.', 'inventor' ) );
		}
    }
}

Inventor_Submission::init();

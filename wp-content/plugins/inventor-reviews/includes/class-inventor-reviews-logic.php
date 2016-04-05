<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Reviews_Logic
 *
 * @class Inventor_Reviews_Logic
 * @package Inventor/Classes
 * @property $allowed_post_types
 * @author Pragmatic Mates
 */
class Inventor_Reviews_Logic {
	/**
	 * List of allowed post types for reviews
	 *
	 * @access public
	 * @return array
	 */
	public static function get_allowed_post_types() {
		return Inventor_Post_Types::get_listing_post_types();
	}

	/**
	 * Initialize review system
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'comments_template', array( __CLASS__, 'get_reviews_template' ) );
		add_action( 'comment_form_default_fields', array( __CLASS__, 'custom_fields' ) );
		add_action( 'comment_post', array( __CLASS__, 'save' ) );
		add_action( 'comment_form_logged_in_after', array( __CLASS__, 'additional_fields' ) );
		add_action( 'inventor_listing_detail', array( __CLASS__, 'render_total_rating' ), 3, 1 );
		add_action( 'add_meta_boxes_comment', array( __CLASS__, 'add_admin_meta_boxes' ), 10, 1 );
		add_action( 'inventor_listing_content', array( __CLASS__, 'render_listing_rating' ), 10, 2 );

		add_filter( 'comment_edit_redirect',  array( __CLASS__, 'save_admin_meta_boxes' ), 10, 2 );
		add_filter( 'manage_edit-comments_columns', array( __CLASS__, 'comment_columns' ) );
		add_filter( 'manage_comments_custom_column', array( __CLASS__, 'rating_column' ), 10, 2 );

		add_filter( 'inventor_filter_field_plugin_dir', array( __CLASS__, 'filter_field_plugin_dir' ), 10, 2 );
		add_filter( 'inventor_filter_fields', array( __CLASS__, 'filter_fields' ) );
		add_filter( 'inventor_filter_sort_by_choices', array( __CLASS__, 'sort_by_choices' ) );
		add_filter( 'inventor_filter_query', array( __CLASS__, 'filter_query' ), 10, 2 );
		add_filter( 'inventor_order_query', array( __CLASS__, 'order_query' ), 10, 2 );
	}

    /**
     * Adds column "Rating"
     *
     * @param $columns
     * @return mixed
     */
    public static function comment_columns( $columns ) {
        $columns['rating'] = __( 'Rating', 'inventor-reviews' );
        return $columns;
    }

	/**
	 * Returns sort by choices form filter form
	 *
	 * @access public
	 * @param $choices
	 * @return array
	 */
	public static function sort_by_choices( $choices ) {
		$choices['rating'] = __( 'Rating', 'inventor-reviews' );
		return $choices;
	}

    /**
     * If comment is review
     *
     * @param $comment_ID
     * @return bool
     */
    public static function is_review( $comment_ID ) {
        $listings_post_types = Inventor_Post_Types::get_listing_post_types();
        $post_type = get_post_type( get_comment( $comment_ID )->comment_post_ID );

        return in_array( $post_type, $listings_post_types );
    }

    /**
     * Renders ratings on admin page
     *
     * @param $column
     * @param $comment_ID
     */
    public static function rating_column( $column, $comment_ID ) {

        // If is listing post type display rating in rating column
        if ( 'rating' == $column && self::is_review( $comment_ID ) ) {
            $rating = get_comment_meta( $comment_ID, 'rating', true);
            echo '<span class="review-rating" data-path="' . plugins_url() . '/inventor-reviews/libraries/raty/images" data-score="' . $rating . '"></span>';
        }
    }

    /**
     * Displays review meta boxes in admin
     *
     * @param $comment
     */
    public static function add_admin_meta_boxes( $comment ) {

        if ( self::is_review( $comment->comment_ID ) ) {
            $quicktags_settings = array( 'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,close' );

            echo Inventor_Template_Loader::load( 'admin/review-admin-field-pros', array( 'comment' => $comment, 'quicktags_settings' => $quicktags_settings ), INVENTOR_REVIEWS_DIR );
            echo Inventor_Template_Loader::load( 'admin/review-admin-field-cons', array( 'comment' => $comment, 'quicktags_settings' => $quicktags_settings ), INVENTOR_REVIEWS_DIR );
            echo Inventor_Template_Loader::load( 'admin/review-admin-field-rating', array( 'comment' => $comment ), INVENTOR_REVIEWS_DIR );

            ?>

            <script>
                jQuery(document).ready(function($) {
                    $('.comment-php #postdiv').css('display', 'none');
                });
            </script>

            <?php
        }
    }

    /**
     * Saves changes in admin
     *
     * @access public
     * @param $location
     * @param $comment_id
     * @return mixed
     */
    public static function save_admin_meta_boxes( $location, $comment_ID ) {

        if ( self::is_review( $comment_ID ) ) {
            update_comment_meta( $comment_ID, 'pros', sanitize_text_field( $_POST['pros'] ) );
            update_comment_meta( $comment_ID, 'cons', sanitize_text_field( $_POST['cons'] ) );
            update_comment_meta( $comment_ID, 'rating', sanitize_text_field( $_POST['rating'] ) );

            $comment = array();
            $comment['comment_ID'] = $comment_ID;
            $comment['comment_content'] = '<table><tr><td><h4>' . __( 'PROS: ', 'inventor-reviews' ) . '</h4>' . sanitize_text_field( $_POST['pros'] ) . '</td><td><h4>' . __( 'CONS: ', 'inventor-reviews' ) . '</h4>' . sanitize_text_field( $_POST['cons'] ) . '</td></tr></table>';
            wp_update_comment( $comment );
        }

        return $location;
    }

	/**
	 * Get review form and reviews template
	 *
	 * @access public
	 * @param $template
	 * @return string
	 */
	public static function get_reviews_template( $template ) {
		if ( in_array( get_post_type(), self::get_allowed_post_types() ) ) {			;
			return Inventor_Template_Loader::locate( 'review-list', INVENTOR_REVIEWS_DIR );			
		}
	
		return $template;
	}

	/**
	 * Get single review template
	 *
	 * @access public
	 * @param $review
	 * @param $args
	 * @param $depth
	 * @return string
	 */
	public static function get_review_template( $review, $args, $depth ) {
		$GLOBALS['comment'] = $review;
		extract( $args, EXTR_SKIP );

		echo Inventor_Template_Loader::load( 'review-single', array(
			'review'    => $review,
			'args'      => $args,
			'depth'     => $depth,
		), INVENTOR_REVIEWS_DIR );
	}

	/**
	 * Gets post total rating
	 *
	 * @access public
	 * @param int $post_id
	 * @return float
	 */
	public static function get_post_total_rating( $post_id = null ) {
		global $wpdb;

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$sql = 'SELECT ROUND(AVG(meta_value), 2) as score FROM ' . $wpdb->prefix . 'comments
	              LEFT JOIN ' . $wpdb->prefix . 'commentmeta ON ' . $wpdb->prefix . 'comments.comment_ID=' . $wpdb->prefix . 'commentmeta.comment_id
                  WHERE comment_post_ID = ' . $post_id .  ' AND
                        comment_approved = 1 AND
                        meta_key = "rating" AND
                        meta_value >= 1 AND
                        meta_value <= 5
                  GROUP BY comment_post_ID;';

		$results = $wpdb->get_results( $sql );
		if ( ! empty( $results[0] ) ) {
			return $results[0]->score;
		}

		return 0;
	}

	/**
	 * Counts reviews for post
	 *
	 * @access public
	 * @param null $post_id
	 * @return int
	 */
	public static function get_post_reviews_count( $post_id = null ) {
		global $wpdb;

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$sql = 'SELECT COUNT(comment_post_ID) as count FROM ' . $wpdb->prefix . 'comments
	              LEFT JOIN ' . $wpdb->prefix . 'commentmeta ON ' . $wpdb->prefix . 'comments.comment_ID=' . $wpdb->prefix . 'commentmeta.comment_id
                  WHERE comment_post_ID = ' . $post_id .  ' AND
                        comment_approved = 1 AND
                        meta_key = "rating"
                  GROUP BY comment_post_ID;';

		$results = $wpdb->get_results( $sql );
		if ( ! empty( $results[0] ) ) {
			return $results[0]->count;
		}

		return 0;
	}

    /**
     * Check if current user has rated the listing
     *
     * @access public
     * @return bool
     */
    public static function current_user_has_rated( $post_id ) {
        global $current_user;

        $user_args = array( 'user_id' => $current_user->ID, 'post_id' => $post_id );
        $user_comment_count = get_comments( $user_args );

        if ( count( $user_comment_count ) >= 1 ){
            return true;
        } else {
            return false;
        }
    }

	/**
	 * Review's custom fields
	 *
	 * @access public
	 * @param $fields
	 * @return mixed
	 */
	public static function custom_fields( $fields ) {
		if ( ! in_array( get_post_type(), self::get_allowed_post_types() ) ) {
			return $fields;
		}

		$commenter = wp_get_current_commenter();

		if ( empty( $commenter['comment_rating'] ) ) {
			$commenter['comment_rating'] = 0;
		}

		return array(
			'author'            => Inventor_Template_Loader::load( 'review-field-author', array( 'commenter' => $commenter ), INVENTOR_REVIEWS_DIR ),
            'email'             => Inventor_Template_Loader::load( 'review-field-email', array( 'commenter' => $commenter ), INVENTOR_REVIEWS_DIR ),
            'url'               => null,
            'pros'              => Inventor_Template_Loader::load( 'review-field-pros', array( 'commenter' => $commenter ), INVENTOR_REVIEWS_DIR ),
            'cons'              => Inventor_Template_Loader::load( 'review-field-cons', array( 'commenter' => $commenter ), INVENTOR_REVIEWS_DIR ),
            'file'              => Inventor_Template_Loader::load( 'review-field-file', array( 'commenter' => $commenter ), INVENTOR_REVIEWS_DIR ),
            'rating'            => Inventor_Template_Loader::load( 'review-field-rating', array( 'commenter' => $commenter ), INVENTOR_REVIEWS_DIR ),
        );
	}

	/**
	 * Additional fields for logged in user
	 *
	 * @access public
	 * @return void
	 */
	public static function additional_fields() {
		if ( in_array( get_post_type(), self::get_allowed_post_types() ) ) {
			$commenter = wp_get_current_commenter();
			echo Inventor_Template_Loader::load('review-field-pros', array('commenter' => $commenter), INVENTOR_REVIEWS_DIR );
			echo Inventor_Template_Loader::load('review-field-cons', array('commenter' => $commenter), INVENTOR_REVIEWS_DIR );
            echo Inventor_Template_Loader::load('review-field-file', array('commenter' => $commenter), INVENTOR_REVIEWS_DIR );
            echo Inventor_Template_Loader::load('review-field-rating', array('commenter' => $commenter), INVENTOR_REVIEWS_DIR );
		}
	}

	/**
	 * Save review
	 *
	 * @access public
	 * @param $comment_id
	 * @return void
	 */
	public static function save( $comment_id ) {
		if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != '' ) ) {
			$rating = wp_filter_nohtml_kses( $_POST['rating'] );
			add_comment_meta( $comment_id, 'rating', $rating );
		}

        if ( ( isset( $_POST['pros'] ) ) && ( $_POST['pros'] != '' ) ) {
            $pros = wp_filter_nohtml_kses( $_POST['pros'] );
            add_comment_meta( $comment_id, 'pros', $pros );
        }

        if ( ( isset( $_POST['cons'] ) ) && ( $_POST['cons'] != '' ) ) {
            $cons = wp_filter_nohtml_kses( $_POST['cons'] );
            add_comment_meta( $comment_id, 'cons', $cons );
        }

        if ( ( isset( $_POST['image'] ) ) && ( $_POST['image'] != '' ) ) {
            $file = esc_attr( $_POST['image'] );
            add_comment_meta( $comment_id, 'image', $file );
        }

        $comment = array();
        $comment['comment_ID'] = $comment_id;

        if ( in_array( get_post_type( $_POST['comment_post_ID'] ), self::get_allowed_post_types() ) ) {
	        $comment_content = sprintf( '<table><tr><td><h4>%s</h4>%s</td><td><h4>%s</h4>%s</td></tr></table>', 
	        	esc_attr__( 'Pros', 'inventor-reviews' ),
	        	! empty( $_POST['pros'] ) ? wp_filter_nohtml_kses( $_POST['pros'] ) : '',
	        	esc_attr__( 'Cons', 'inventor-reviews' ),
				! empty( $_POST['cons'] ) ? wp_filter_nohtml_kses( $_POST['cons'] ) : ''
	        );
	        $comment['comment_content'] = $comment_content;
    	}
        
        wp_update_comment( $comment );

		// update total rating: we need to to be able sort posts by rating
		$post_id = get_comment( $comment_id )->comment_post_ID;
		update_post_meta( $post_id, INVENTOR_REVIEWS_TOTAL_RATING_META, self::get_post_total_rating( $post_id ) );
    }

	/**
	 * Renders total post rating
	 *
	 * @access public
	 * @param int $listing_id
	 * @return void
	 */
	public static function render_total_rating( $listing_id ) {
		echo Inventor_Template_Loader::load( 'review-total-rating', array( 'listing_id' => $listing_id ), $plugin_dir = INVENTOR_REVIEWS_DIR );
	}

	/**
	 * Renders listing rating
	 *
	 * @access public
	 * @param int $listing_id
	 * @param string $display
	 * @return void
	 */
	public static function render_listing_rating( $listing_id, $display = null ) {
		echo Inventor_Template_Loader::load( 'review-listing-rating', array( 'listing_id' => $listing_id, 'display' => $display ), $plugin_dir = INVENTOR_REVIEWS_DIR );
	}

	/**
	 * Adds rating field to filter
	 *
	 * @access public
	 * @param $fields array
	 * @return array
	 */
	public static function filter_fields( $fields ) {
		$fields['rating'] = __( 'Rating', 'inventor-reviews' );
		return $fields;
	}

	/**
	 * Sets rating filter field plugin dir
	 *
	 * @access public
	 * @param $plugin_dir string
	 * @param $template string
	 * @return string
	 */
	public static function filter_field_plugin_dir( $plugin_dir, $template ) {
		if ( $template == 'rating' ) {
			return INVENTOR_REVIEWS_DIR;
		}
		return $plugin_dir;
	}

	/**
	 * Filters query by rating
	 *
	 * @access public
	 * @return array
	 */
	public static function filter_query( $ids, $params ) {
		if ( ! empty( $params['filter-rating'] ) ) {
			$rating_ids = array();
			$rows = self::filter_by_rating( $params['filter-rating'] );

			foreach ( $rows as $row ) {
				$rating_ids[] = $row->ID;
			}

			$ids = Inventor_Filter::build_post_ids( $ids, $rating_ids );
		}

		return $ids;
	}

	/**
	 * Orders query by rating
	 *
	 * @access public
	 * @return object
	 */
	public static function order_query( $query, $params ) {
		$sort_by = empty( $params['filter-sort-by'] ) ? null : $params['filter-sort-by'];

		if ( $sort_by == 'rating' ) {
			$query->set( 'meta_key', INVENTOR_REVIEWS_TOTAL_RATING_META );
			$query->set( 'orderby', 'meta_value_num' );

			// Tweak for displaying posts without value instead of ignoring them
			add_filter( 'get_meta_sql', array( 'Inventor_Filter', 'filter_get_meta_sql_19653' ) );
		}

		return $query;
	}

	/**
	 * Find listings by rating
	 *
	 * @access public
	 * @param $rating
	 *
	 * @return mixed
	 */
	public static function filter_by_rating( $rating ) {
		global $wpdb;

		$sql = 'SELECT comment_post_ID as ID, ROUND(AVG(meta_value), 2) as score FROM ' . $wpdb->prefix . 'comments
	              LEFT JOIN ' . $wpdb->prefix . 'commentmeta ON ' . $wpdb->prefix . 'comments.comment_ID=' . $wpdb->prefix . 'commentmeta.comment_id
                  WHERE comment_approved = 1 AND meta_key = "rating"
                  GROUP BY comment_post_ID HAVING score >= ' . $rating . ';';

		return $wpdb->get_results( $sql );
	}
}

Inventor_Reviews_Logic::init();
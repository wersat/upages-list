<?php if ( ! post_password_required() ) : ?>
    <div id="listing-detail-section-reviews" class="listing-detail-section">        
        <?php if ( have_comments() ) : ?>
            <h2 class="page-header review-title">
                <?php
                    echo esc_attr( sprintf( _n( 'One review on &ldquo;%2$s&rdquo;', '%1$s reviews on &ldquo;%2$s&rdquo;', get_comments_number(), 'inventor-reviews' ), number_format_i18n( get_comments_number() ), get_the_title() ) );
                ?>            
            </h2>

            <ul class="review-list">
                <?php wp_list_comments( array(
                    'style'         => 'ul',
                    'short_ping'    => true,
                    'avatar_size'   => 70,
                    'callback'      => 'Inventor_Reviews_Logic::get_review_template',
                ) ); ?>
            </ul><!-- /.comment-list -->

            <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                <nav id="comment-nav-below" class="navigation review-navigation" role="navigation">
                    <div class="nav-previous"><?php previous_comments_link( __( 'Older Reviews', 'inventor-reviews' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( __( 'Newer Reviews', 'inventor-reviews' ) ); ?></div>
                </nav><!-- /.review-navigation -->
            <?php endif; ?>

            <?php if ( ! comments_open() ) : ?>
                <p class="no-comments"><?php echo __( 'Reviews are closed.', 'inventor-reviews' ); ?></p>
            <?php endif; ?>
        <?php endif; ?>


        <?php if ( empty( $commenter['comment_rating'] ) ) : ?>
            <?php $commenter['comment_rating'] = ''; ?>
        <?php endif; ?>

        <?php if ( ! Inventor_Reviews_Logic::current_user_has_rated( get_the_ID() ) ) : ?>
            <div class="review-form">
                <?php comment_form( array(
                    'title_reply'           => __( 'Post New Review', 'inventor-reviews' ),
                    'label_submit'          => __( 'Submit Review', 'inventor-reviews' ),
                    'comment_notes_after'   => false,
                    'class_submit'          => 'rating-form-submit',
                    'comment_field'         => Inventor_Template_Loader::load( 'review-field-comment', array(), INVENTOR_REVIEWS_DIR ),
                ) ); ?>
            </div><!-- /.review-form -->
        <?php endif; ?>
    </div><!-- #review -->
<?php endif; ?>
<div class="inventor-reviews-total-rating">
    <?php $total_rating = get_post_meta( $listing_id, INVENTOR_REVIEWS_TOTAL_RATING_META, true ); ?>
    <?php $total_rating = empty ( $total_rating ) ? 0 : $total_rating; ?>
    <?php $reviews_count = get_comment_count( $listing_id ); ?>

    <i class="fa fa-star"></i>
    <?php
    echo sprintf( _n(
        '<strong>%.2f / 5 </strong> from <a href="#listing-detail-section-reviews">%d review</a>',
        '<strong>%.2f / 5 </strong> from <a href="#listing-detail-section-reviews">%d reviews</a>',
        $reviews_count['approved'],
        'inventor-reviews'
    ), $total_rating, $reviews_count['approved'] );
    ?>
</div>
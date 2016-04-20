<?php
    $if_allowed_reviews = apply_filters('inventor_submission_listing_metabox_allowed', true, 'reviews',
        get_the_author_meta('ID'));
    if ($if_allowed_reviews || comments_open() || get_comments_number()) {
        comments_template('', true);
    }

<?php
/**
 * Template file
 *
 * @package Superlist
 * @subpackage Templates
 */

?>

<?php $listing_banner = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'banner', true ); ?>

<div class="detail-banner"

    <?php // Default - features image. ?>
    <?php if ( empty( $listing_banner ) || 'banner_featured_image' == $listing_banner ) : ?>
        data-background-image="<?php echo esc_attr( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>"
    <?php endif; ?>

    <?php // Custom image. ?>
    <?php if ( 'banner_image' == $listing_banner ) : ?>
        data-background-image="<?php echo esc_attr( get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'banner_image', true ) ); ?>"
    <?php endif; ?>
    >

    <?php // Video. ?>
    <?php if ( 'banner_video' == $listing_banner ) : ?>
        <?php $banner_video_loop = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'banner_video_loop', true ); ?>
        <video autoplay muted
            <?php echo esc_attr( empty( $banner_video_loop ) ? '' : 'loop' ); ?>>
            <source src="<?php echo esc_attr( get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'banner_video', true ) ); ?>" type="video/mp4">
            <div class="alert alert-danger"><?php esc_attr__( 'Your browser does not support the video html tag.', 'superlist' ); ?></div>
        </video>
    <?php endif; ?>

    <?php // Google map. ?>
    <?php if ( 'banner_map' == $listing_banner ) : ?>
        <?php $banner_latitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_latitude', true );?>
        <?php $banner_longitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_longitude', true );?>
        <?php $banner_map_type = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'banner_map_type', true ); ?>
        <?php $banner_marker = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'banner_map_marker', true ); ?>
        <?php $banner_zoom = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'banner_map_zoom', true ); ?>
        <div id="banner-map"
             data-transparent-marker-image="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/img/transparent-marker-image.png"
             data-latitude="<?php echo esc_attr( $banner_latitude ); ?>"
             data-longitude="<?php echo esc_attr( $banner_longitude ); ?>"
             data-map-type="<?php echo esc_attr( $banner_map_type ); ?>"
             data-marker="<?php echo esc_attr( $banner_marker ); ?>"
             data-zoom="<?php echo esc_attr( empty( $banner_zoom ) ? 17 : $banner_zoom ); ?>"></div>
    <?php endif; ?>

    <?php // Google street view. ?>
    <?php $street_view = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'street_view', true );?>
    <?php if ( 'banner_street_view' == $listing_banner && ! empty( $street_view ) ) : ?>
        <?php $banner_latitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'street_view_location_latitude', true );?>
        <?php $banner_longitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'street_view_location_longitude', true );?>
        <?php $banner_zoom = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'street_view_location_zoom', true ); ?>
        <?php $banner_heading = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'street_view_location_heading', true ); ?>
        <?php $banner_pitch = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'street_view_location_pitch', true ); ?>
        <div id="banner-street-view"
             data-latitude="<?php echo esc_attr( $banner_latitude ); ?>"
             data-longitude="<?php echo esc_attr( $banner_longitude ); ?>"
             data-zoom="<?php echo esc_attr( $banner_zoom ); ?>"
             data-heading="<?php echo esc_attr( $banner_heading ); ?>"
             data-pitch="<?php echo esc_attr( $banner_pitch ); ?>"></div>
    <?php endif; ?>

    <?php // Google inside view. ?>
    <?php $inside_view = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view', true );?>
    <?php if ( 'banner_inside_view' == $listing_banner && ! empty( $inside_view ) ) : ?>
        <?php $banner_latitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_latitude', true );?>
        <?php $banner_longitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_longitude', true );?>
        <?php $banner_zoom = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_zoom', true ); ?>
        <?php $banner_heading = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_heading', true ); ?>
        <?php $banner_pitch = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_pitch', true ); ?>
        <div id="banner-inside-view"
             data-latitude="<?php echo esc_attr( $banner_latitude ); ?>"
             data-longitude="<?php echo esc_attr( $banner_longitude ); ?>"
             data-zoom="<?php echo esc_attr( $banner_zoom ); ?>"
             data-heading="<?php echo esc_attr( $banner_heading ); ?>"
             data-pitch="<?php echo esc_attr( $banner_pitch ); ?>"></div>
    <?php endif; ?>

    <div class="detail-banner-shadow"></div>

    <div class="container">
        <div class="detail-banner-left">
            <div class="detail-banner-info">
                <?php $listing_category = Inventor_Query::get_listing_category_name(); ?>
                <?php if ( ! empty( $listing_category ) ) : ?>
                    <div class="detail-label"><?php echo wp_kses( $listing_category, wp_kses_allowed_html( 'post' ) ); ?></div>
                <?php endif; ?>
            </div><!-- /.detail-banner-info -->

            <h2 class="detail-title">
                <?php echo apply_filters( 'inventor_listing_title', get_the_title(), get_the_ID() ); ?>
            </h2>

            <?php $slogan = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'slogan', true ); ?>
            <?php if ( ! empty( $slogan ) ) : ?>
                <h4 class="detail-banner-slogan">
                    <?php echo esc_attr( $slogan ); ?>
                </h4>
            <?php endif; ?>

            <?php $location = Inventor_Query::get_listing_location_name(); ?>
            <?php if ( ! empty( $location ) ) : ?>
                <div class="detail-banner-address">
                    <i class="fa fa-map-o"></i> <?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?>
                </div><!-- /.detail-banner-address -->
            <?php endif; ?>

            <div class="detail-banner-after">
                <?php do_action( 'superlist_after_listing_banner', get_the_ID() ); ?>
            </div><!-- /.detail-banner-after -->
        </div><!-- /.detail-banner-left -->

        <div class="detail-banner-right">
            <?php $price = Inventor_Price::get_price(); ?>
            <?php $reduced = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'reduced', true ); ?>
            <?php if ( ! empty( $price ) ) : ?>
                <div class="detail-banner-price <?php echo ( ! empty( $reduced ) ) ? 'reduced-price' : '' ;?>">
                    <span class="detail-banner-price-label"><?php echo esc_attr( ! empty( $reduced ) ) ? esc_attr__( 'Reduced Price', 'superlist' ) : esc_attr__( 'Price', 'superlist' );?>:</span>
                    <span class="detail-banner-price-value"><?php echo esc_attr( $price ); ?></span>
                    <?php do_action( 'inventor_after_listing_price', get_the_ID() ); ?>
                </div>
            <?php endif; ?>
        </div><!-- /.detail-banner-right -->

    </div><!-- /.container -->
</div><!-- /.detail-banner -->

<div class="listing-detail-menu-wrapper">
    <div class="listing-detail-menu">
        <div class="container">
            <ul class="nav nav-pills"></ul>
        </div><!-- /.container -->
    </div><!-- /.listing-detail-menu -->
</div><!-- /.listing-detail-menu-wrapper -->

<?php
/**
 * Template file
 *
 * @package Superlist
 * @subpackage Templates
 */

?>

<?php if ( has_post_thumbnail() ) : ?>
	<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' ); ?>
	<div class="listing-box" style="background-image: url('<?php echo esc_attr( $image[0] ); ?>');">
<?php else : ?>
    <div class="listing-box" style="background-image: url('<?php echo esc_attr( plugins_url( 'inventor' ) ); ?>/assets/img/default-item.png');">
<?php endif; ?>
    <a href="<?php the_permalink() ?>" class="listing-box-content-link"></a>

    <div class="listing-box-background">
        <div class="listing-box-content">            

            <?php do_action( 'inventor_listing_content', get_the_ID(), 'box' ); ?>

            <div class="listing-box-actions">
	            <?php do_action( 'superlist_before_card_box_detail' ); ?>
                <a href="<?php the_permalink(); ?>" class="fa fa-eye"></a>
	            <?php do_action( 'superlist_after_card_box_detail', get_the_ID() ); ?>
            </div><!-- /.listing-box-actions -->
        </div><!-- /.listing-box-content -->

        <?php $listing_category = Inventor_Query::get_listing_category_name(); ?>
        <?php if ( ! empty( $listing_category ) ) : ?>
            <div class="listing-box-label-top"><?php echo wp_kses( $listing_category, wp_kses_allowed_html( 'post' ) ); ?></div>
        <?php endif; ?>

        <div class="listing-box-label-bottom"><?php the_title(); ?></div>

    </div><!-- /.listing-box-background -->
</div><!-- /.listing-box -->

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="infobox">
	<div class="infobox-inner">
		<?php $image_url = wp_get_attachment_url( get_post_thumbnail_id() ); ?>
		<div class="infobox-image" <?php if ( ! empty( $image_url ) ) : ?>style="background-image: url('<?php echo esc_attr( $image_url ); ?>');"<?php endif; ?>>
            <?php do_action( 'inventor_google_map_infobox_image', get_the_ID() ); ?>
		</div>

		<div class="infobox-title">
			<h2>
				<a href="<?php the_permalink(); ?>">
					<?php echo the_title(); ?>
				</a>
			</h2>

			<?php $listing_category = Inventor_Query::get_listing_category_name(); ?>
			<?php if ( ! empty ( $listing_category ) ) : ?>
				<div class="infobox-category"><?php echo wp_kses( $listing_category, wp_kses_allowed_html( 'post' ) ); ?></div><!-- /.infobox-category -->
			<?php endif; ?>
		</div><!-- /.infobox-title-->

		<a class="close">x</a>
	</div>
</div>

<?php
/**
 * The template for displaying not found page
 *
 * @package Superlist
 * @since Superlist 1.0.0
 */

get_header(); ?>

<?php $display_as_grid = ( ! empty( $_GET['listing-display'] ) && 'grid' == $_GET['listing-display'] ) ? true : get_theme_mod( 'inventor_general_show_listing_archive_as_grid', null ); ?>
<div class="row">
	<div class="<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>col-sm-8 col-lg-9<?php else : ?>col-sm-12<?php endif; ?>">
		<div id="primary">
            <?php get_template_part( 'templates/document-title' ); ?>

            <?php dynamic_sidebar( 'content-top' ); ?>

			<?php if ( have_posts() ) : ?>
				<?php
				/**
				 * Inventor_before_listing_archive
				 */
				do_action( 'inventor_before_listing_archive' );
				?>

				<?php if ( $display_as_grid ) : ?>
					<div class="listing-box-archive type-box items-per-row-4">
				<?php endif; ?>

				<div class="listings-row">
					<?php $index = 0; ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="listing-container">
							<?php if ( $display_as_grid ) : ?>
								<?php include Inventor_Template_Loader::locate( 'listings/box' ); ?>
							<?php else : ?>
								<?php include Inventor_Template_Loader::locate( 'listings/row' ); ?>
							<?php endif; ?>
						</div><!-- /.listing-container -->

						<?php if ( 0 == ( ( $index + 1 ) % 4 ) && Inventor_Query::loop_has_next() ) : ?>
							</div><div class="listings-row">
						<?php endif; ?>

						<?php $index++; ?>
					<?php endwhile; ?>
				</div><!-- /.listings-row -->

				<?php if ( $display_as_grid ) : ?>
					</div><!-- /.listing-box-archive -->
				<?php endif; ?>

				<?php
				/**
				 * Inventor_after_listing_archive
				 */
				do_action( 'inventor_after_listing_archive' );
				?>

				<?php superlist_pagination(); ?>
			<?php else : ?>
				<?php get_template_part( 'templates/content', 'none' ); ?>
			<?php endif; ?>

			<?php dynamic_sidebar( 'content-bottom' ); ?>
		</div><!-- #primary -->
	</div><!-- /.col-* -->

	<?php get_sidebar() ?>
</div><!-- /.row -->

<?php get_footer(); ?>

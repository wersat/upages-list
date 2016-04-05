<?php
/**
 * The template for displaying pricing tables
 *
 * @package Superlist
 * @since Superlist 1.0.0
 */

get_header(); ?>

<div class="row">
	<div class="<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>col-sm-8 col-lg-9<?php else : ?>col-sm-12<?php endif; ?>">
		<div id="primary">
            <?php get_template_part( 'templates/document-title' ); ?>

            <?php dynamic_sidebar( 'content-top' ); ?>

			<?php if ( have_posts() ) : ?>
				<?php
				/**
				 * Inventor_before_pricing_archive
				 */
				do_action( 'inventor_before_pricing_archive' );
				?>

                <div class="items-per-row-3">

                    <div class="pricing-row">

                        <?php $index = 0; ?>
                        <?php while ( have_posts() ) : the_post(); ?>

                        <?php include Inventor_Template_Loader::locate( 'pricing-table', INVENTOR_PRICING_DIR ); ?>

                        <?php if ( ( $index + 1 ) % 3 == 0 && Inventor_Query::loop_has_next() ) : ?>
                    </div><div class="pricing-row">
                        <?php endif; ?>

                        <?php $index++; ?>
                        <?php endwhile; ?>
                    </div><!-- /.properties-row -->
                </div>

				<?php
				/**
				 * Inventor_after_pricing_archive
				 */
				do_action( 'inventor_after_pricing_archive' );
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

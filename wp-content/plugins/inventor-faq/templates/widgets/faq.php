<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<div class="widget-inner
 <?php echo esc_attr( $instance['classes'] ); ?>
 <?php echo ( empty( $instance['padding_top'] ) ) ? '' : 'widget-pt' ; ?>
 <?php echo ( empty( $instance['padding_bottom'] ) ) ? '' : 'widget-pb' ; ?>"
    <?php if ( ! empty( $instance['background_color'] ) || ! empty( $instance['background_image'] ) ) : ?>
        style="
        <?php if ( ! empty( $instance['background_color'] ) ) : ?>
            background-color: <?php echo esc_attr( $instance['background_color'] ); ?>;
    <?php endif; ?>
        <?php if ( ! empty( $instance['background_image'] ) ) : ?>
            background-image: url('<?php echo esc_attr( $instance['background_image'] ); ?>');
        <?php endif; ?>"
    <?php endif; ?>>

<?php if ( ! empty( $instance['title'] ) ) : ?>
	<?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
	<?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
	<?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
<?php endif; ?>

<?php if ( ! empty( $instance['description'] ) ) : ?>
	<div class="description">
		<?php echo wp_kses( $instance['description'], wp_kses_allowed_html( 'post' ) ); ?>
	</div><!-- /.description -->
<?php endif; ?>

<?php if ( have_posts() ) : ?>

    <div class="faq">

        <?php while ( have_posts() ) : the_post(); ?>

            <div class="faq-item">
                <div class="faq-item-question">
                    <h2><?php the_title(); ?></h2>
                </div>
                <div class="faq-item-answer">
                    <p><?php the_content(); ?></p>
                </div>
            </div><!-- /.faq-item -->

        <?php endwhile; ?>

    </div><!-- /.faq -->

<?php else : ?>

	<div class="alert alert-warning">
		<?php echo __( 'No FAQ found.', 'inventor-faq' ); ?>
	</div><!-- /.alert -->

<?php endif; ?>

</div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <?php echo Inventor_Template_Loader::load( 'listings/row' ); ?>
    <?php endwhile; ?>

    <?php the_posts_pagination( array(
        'prev_text' => __( 'Previous', 'inventor-favorites' ),
        'next_text' => __( 'Next', 'inventor-favorites' ),
        'mid_size'  => 2,
    ) ); ?>
<?php else : ?>
    <div class="alert alert-warning">
        <?php if ( is_user_logged_in() ): ?>
            <?php echo __( "You don't have any favorite listings, yet. Start by adding some.", 'inventor-favorites' ); ?>
        <?php else: ?>
            <?php echo __( 'You need to log in at first.', 'inventor-favorites' ); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
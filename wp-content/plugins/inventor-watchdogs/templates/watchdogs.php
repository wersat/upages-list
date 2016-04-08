<?php if (have_posts()) : ?>
  <div class="listings-row">
    <?php while (have_posts()) : the_post(); ?>
      <div class="listing-container">
        <?php echo Inventor_Template_Loader::load('watchdogs-row', [], $plugin_dir = INVENTOR_WATCHDOGS_DIR); ?>
      </div><!-- /.listing-container -->
    <?php endwhile; ?>
  </div><!-- /.listings-row -->
  <?php the_posts_pagination([
    'prev_text' => __('Previous', 'inventor-watchdogs'),
    'next_text' => __('Next', 'inventor-watchdogs'),
    'mid_size'  => 2,
  ]); ?>
<?php else : ?>
  <div class="alert alert-warning">
    <?php if (is_user_logged_in()): ?>
      <p><?php echo __("You don't have any watchdogs, yet. Start by adding some.", 'inventor-watchdogs'); ?></p>
    <?php else: ?>
      <p><?php echo __('You need to log in at first.', 'inventor-watchdogs'); ?></p>
    <?php endif; ?>
  </div>
<?php endif; ?>

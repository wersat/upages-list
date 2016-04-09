<?php
  if ( ! defined('ABSPATH')) {
    exit;
  }
  /*
   * The template for archive page
   * @package Inventor
   * @since   Inventor 0.1.0
   */
  get_header(); ?>

<?php $display_as_grid = ( ! empty($_GET['listing-display']) && 'grid' === $_GET['listing-display']) ? true
  : get_theme_mod('inventor_general_show_listing_archive_as_grid', null); ?>
<div class="row">
  <div class="<?php if (is_active_sidebar('sidebar-1')) : ?>col-lg-8 col-xl-9<?php else : ?>col-sm-12<?php endif; ?>">
    <?php dynamic_sidebar('content-top'); ?>
    <div class="content">
      <?php
        /**
         * inventor_before_listing_archive.
         */
        do_action('inventor_before_listing_archive');
      ?>

      <?php if (have_posts()) : ?>
        <?php if ($display_as_grid) : ?>
          <div class="listing-box-archive type-box items-per-row-4">
        <?php endif; ?>

        <div class="listings-row">
        <?php $index = 0; ?>
        <?php while (have_posts()) :
        the_post(); ?>
        <div class="listing-container">
          <?php if ($display_as_grid) : ?>
            <?php include Inventor_Template_Loader::locate('listings/box'); ?>
          <?php else : ?>
            <?php include Inventor_Template_Loader::locate('listings/row'); ?>
          <?php endif; ?>
        </div>
        <?php if (0 === (($index + 1) % 4) && Inventor_Query::loop_has_next()) : ?>
        </div>
        <div class="listings-row">
      <?php endif; ?>
        <?php ++$index; ?>
      <?php endwhile; ?>
        </div>

        <?php if ($display_as_grid) : ?>
          </div>
        <?php endif; ?>
        <?php
        /**
         * inventor_after_listing_archive.
         */
        do_action('inventor_after_listing_archive');
        ?>
        <?php the_posts_pagination([
          'prev_text' => __('Previous', 'inventor'),
          'next_text' => __('Next', 'inventor'),
          'mid_size'  => 2,
        ]); ?>
      <?php else : ?>
        <?php get_template_part('templates/content', 'none'); ?>
      <?php endif; ?>
    </div>
    <?php dynamic_sidebar('content-bottom'); ?>
  </div>
  <?php get_sidebar() ?>
</div>
<?php get_footer(); ?>

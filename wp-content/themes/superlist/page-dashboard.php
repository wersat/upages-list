<?php
  /**
   * The template for displaying dashboard
   * Template name: Dashboard
   * @package Superlist
   * @since   Superlist 1.0.0
   */
  get_header(); ?>
<div class="row">
  <div class="<?php if (is_user_logged_in()) : ?>col-sm-8 col-lg-9<?php else : ?>col-sm-12<?php endif; ?>">
    <div id="primary">
      <?php get_template_part('templates/document-title'); ?>
      <?php dynamic_sidebar('content-top'); ?>
      <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
          <?php get_template_part('templates/content-page'); ?>
        <?php endwhile; ?>
        <?php superlist_pagination(); ?>
      <?php else : ?>
        <?php get_template_part('templates/content', 'none'); ?>
      <?php endif; ?>
      <?php dynamic_sidebar('content-bottom'); ?>
    </div>
  </div>
  <?php if (is_user_logged_in()) : ?>
    <div class="col-sm-4 col-lg-3">
      <div class="sidebar">
        <?php if (is_active_sidebar('dashboard-top')) : ?>
          <?php dynamic_sidebar('dashboard-top'); ?>
        <?php endif; ?>
        <div class="widget widget_dashboard_navigation">
          <div class="widget-inner">
            <h2 class="widgettitle"><?php echo esc_attr__('Navigation', 'superlist'); ?></h2>
          </div>
          <ul>
            <?php $create_listing_id = get_theme_mod('inventor_submission_create_page', false); ?>
            <?php if ( ! empty($create_listing_id)) : ?>
              <li>
                <a href="<?php echo esc_attr(get_permalink($create_listing_id)); ?>"><?php echo esc_attr(get_the_title($create_listing_id)); ?></a>
              </li>
            <?php endif; ?>

            <?php $submission_list_id = get_theme_mod('inventor_submission_list_page', false); ?>
            <?php if ( ! empty($submission_list_id)) : ?>
              <li>
                <a href="<?php echo esc_attr(get_permalink($submission_list_id)); ?>"><?php echo esc_attr(get_the_title($submission_list_id)); ?></a>
              </li>
            <?php endif; ?>

            <?php $favorites_id = get_theme_mod('inventor_favorites_page', false); ?>
            <?php if ( ! empty($favorites_id)) : ?>
              <li>
                <a href="<?php echo esc_attr(get_permalink($favorites_id)); ?>"><?php echo esc_attr(get_the_title($favorites_id)); ?></a>
              </li>
            <?php endif; ?>

            <?php $watchdogs_id = get_theme_mod('inventor_watchdogs_page', false); ?>
            <?php if ( ! empty($watchdogs_id)) : ?>
              <li>
                <a href="<?php echo esc_attr(get_permalink($watchdogs_id)); ?>"><?php echo esc_attr(get_the_title($watchdogs_id)); ?></a>
              </li>
            <?php endif; ?>

            <?php $invoices_id = get_theme_mod('inventor_invoices_page', false); ?>
            <?php if ( ! empty($invoices_id)) : ?>
              <li>
                <a href="<?php echo esc_attr(get_permalink($invoices_id)); ?>"><?php echo esc_attr(get_the_title($invoices_id)); ?></a>
              </li>
            <?php endif; ?>

            <?php $transactions_id = get_theme_mod('inventor_general_transactions_page', false); ?>
            <?php if ( ! empty($transactions_id)) : ?>
              <li>
                <a href="<?php echo esc_attr(get_permalink($transactions_id)); ?>"><?php echo esc_attr(get_the_title($transactions_id)); ?></a>
              </li>
            <?php endif; ?>

            <?php $profile_id = get_theme_mod('inventor_general_profile_page', false); ?>
            <?php if ( ! empty($profile_id)) : ?>
              <li>
                <a href="<?php echo esc_attr(get_permalink($profile_id)); ?>"><?php echo esc_attr(get_the_title($profile_id)); ?></a>
              </li>
            <?php endif; ?>

            <?php $change_password_id = get_theme_mod('inventor_general_password_page', false); ?>
            <?php if ( ! empty($change_password_id)) : ?>
              <li>
                <a href="<?php echo esc_attr(get_permalink($change_password_id)); ?>"><?php echo esc_attr(get_the_title($change_password_id)); ?></a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
        <?php if (class_exists('Inventor_Packages')): ?>
          <?php echo do_shortcode('[inventor_package_info]'); ?>
        <?php endif; ?>

        <?php if (is_active_sidebar('dashboard-bottom')) : ?>
          <?php dynamic_sidebar('dashboard-bottom'); ?>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>
</div>
<?php get_footer(); ?>

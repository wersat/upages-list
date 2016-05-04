<?php
  /**
   * The template for displaying header
   * @package Superlist
   * @since   Superlist 1.0.0
   */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <?php if (class_exists('Inventor_Template_Loader')) : ?>
      <?php echo Inventor_Template_Loader::load('misc/messages'); ?>
    <?php endif; ?>
    <div class="page-wrapper">
      <header class="header header-minimal">
        <?php if (is_active_sidebar('header-topbar-left') || is_active_sidebar('header-topbar-right')) : ?>
          <div class="header-bar">
            <div class="container">
              <div class="header-bar-inner">
                <?php if (is_active_sidebar('header-topbar-left')) : ?>
                  <div class="header-bar-left">
                    <?php dynamic_sidebar('header-topbar-left'); ?>
                  </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('header-topbar-right')) : ?>
                  <div class="header-bar-right">
                    <?php dynamic_sidebar('header-topbar-right'); ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endif; ?>
        <div class="header-wrapper affix-top">
          <div class="container">
            <div class="header-inner">
              <div class="header-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                  <?php if (get_theme_mod('superlist_logo')) : ?>
                    <img src="<?php echo esc_attr(get_theme_mod('superlist_logo')); ?>" alt="<?php bloginfo('name'); ?>">
                  <?php else : ?>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 562.5 539.063">
                      <path d="M279.644 8.928c-49.142.505-97.845 16.195-138.92 42.99-26.268 17.784-49.78 39.97-68.514 65.592-21.5 30.865-37.614 65.78-44.638 102.86-4.1 18.364-4.907 37.205-4.36 55.968.153 16.23.992 32.658 5.092 48.198 6.864 33.12 19.8 65.17 39.21 92.964 22.34 32.866 51.812 61.178 86.51 80.74 40.708 23.33 87.62 36.532 134.704 34.78 30.423.388 60.7-6.128 89.17-16.567 7.133-1.62 10.435-4.154 3.31-9.183-10.725-12.866-17.702-28.358-21.12-44.643-2.482-4.285-8.07.79-11.592 1.055-55.227 18.037-117.96 11.552-167.866-18.832-57.933-33.372-96.034-97.68-98.722-164.078-3.342-56.412 19.374-113.112 59.454-153.06 11.784-12.244 25.838-22.153 40.257-31.13 30.47-17.422 65.36-27.955 100.34-27.894 66.59-1.864 132.53 32.153 170.36 87.166 23.81 34.274 37.07 76.19 35.63 118.11.27 24.993-4.68 49.812-14.11 73.087-1.87 3.12-.25 6.61 3.46 6.77 16.42 4.13 31.16 13.31 43.65 24.53 4.59 2.51 5.3-4.93 6.79-7.64 12.87-33.22 21.01-68.75 19.09-104.55-.07-36.68-8.53-73.15-24.29-106.25-33.79-72.76-102.52-128.31-181.11-145-20.28-4.41-41.08-6.2-61.82-5.96z" id="a" class="yellow"></path>
                      <path xlink:href="#b" d="M129.072 163.89c-1.774.052 4.307 1.403 17.7 4.07 116.547 23.198 139.62 30.19 168.75 51.124 6.446 4.633 11.84 8.422 11.987 8.422 1.18 0-3.21-5.254-10.42-12.466-18.15-18.144-35.17-25.983-72.65-33.452-19.5-3.886-53.25-9.37-85.95-13.966-18.02-2.533-27.65-3.782-29.42-3.73zm11.138 8.35c-2.74.035-1.424.82 7.97 4.766 109.335 45.93 143.92 66.04 185.056 107.598 10.836 10.948 22.577 23.985 50.256 55.812 16.318 18.765 25.663 25.952 36.03 27.708 6.18 1.046 9.252 1.07 9.868.072.728-1.178-57.896-79.678-76.682-102.68-34.76-42.562-54.432-56.18-101.45-70.224-29.702-8.873-98.752-23.206-111.048-23.05zm50.625 27.602c0 .177 5.59 3.807 12.422 8.067 23.906 14.9 37.56 25.47 50.534 39.1 10.57 11.1 14.86 19.45 14.86 28.91 0 11.7-3.75 18.56-12.36 22.58-6.29 2.94-12.77 3.96-34.5 5.47-18.93 1.3-30.01 3.16-30.01 5.01 0 1.33 27.75 7.95 40.78 9.72 6.96.94 24.86.53 30.74-.72 9.14-1.94 14.85-5.42 25.28-15.4 9.9-9.48 16.41-17.51 20.11-24.81l2.33-4.59-3.59-3.71c-7.74-8.01-32.45-26.22-50-36.87-13.43-8.16-66.56-34.33-66.56-32.8z" class="black"></path>
                      <path d="M454.787 389.46c-28.482-.323-54.63 25.913-53.292 54.703-.387 16.13 11.06 29.1 19.233 41.91 10.948 15.298 22.465 30.36 34.498 44.896 15.188-19.07 31.23-37.65 44.35-58.23 7.872-13 13.958-29.07 8.164-44.09-6.85-22.67-28.988-39.94-52.953-39.19zm1.53 14.78c20.29-.18 39.828 18.187 37.917 39.026 1.935 16.12-9.637 30.96-23.93 37.092-13.718 6.16-30.882 2.883-41.57-7.668-8.237-8.263-13.945-19.83-12.52-31.734.54-20.344 20.028-37.355 40.104-36.715z" class="black"></path>
                    </svg>
                  <?php endif; ?>

                  <?php if (display_header_text()) : ?>
                    <span><?php bloginfo('name'); ?></span>
                  <?php endif; ?>
                </a>
              </div>
              <div class="header-content">
                <div class="header-bottom">
                  <?php if (has_nav_menu('main')) : ?>
                    <?php wp_nav_menu([
                      'container_class' => 'header-nav-container',
                      'fallback_cb'     => '',
                      'theme_location'  => 'main',
                      'menu_class'      => 'header-nav-primary nav nav-pills collapse navbar-collapse',
                    ]); ?>
                  <?php endif; ?>

                  <?php if (get_theme_mod('superlist_general_action')) : ?>
                    <div class="header-action">
                      <a href="<?php echo esc_attr(get_permalink(get_theme_mod('superlist_general_action'))); ?>" class="header-action-inner" title="<?php echo esc_attr(get_theme_mod('superlist_general_action_text')); ?>" data-toggle="tooltip" data-placement="left">
                        <i class="fa fa-plus"></i>
                      </a>
                    </div>
                  <?php endif; ?>
                  <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".header-nav-primary">
                    <span class="sr-only"><?php echo esc_attr__('Toggle navigation', 'superlist'); ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <?php if (class_exists('Inventor_Post_Types')) : ?>
            <div class="header-post-types">
              <div class="container">
                <?php $post_types = Inventor_Post_Types::get_listing_post_types(); ?>
                <?php $page_id = get_theme_mod('inventor_submission_create_page'); ?>
                <?php $page_permalink = get_permalink($page_id); ?>

                <?php if ( ! empty($post_types)) : ?>
                  <ul>
                    <?php foreach ($post_types as $post_type) : ?>
                      <li>
                        <a href="<?php echo esc_attr($page_permalink); ?>?type=<?php echo esc_attr($post_type); ?>">
                          <?php echo esc_attr(get_post_type_object($post_type)->labels->singular_name); ?>
                        </a>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </header>
      <?php if (class_exists('Inventor_Post_Types')) : ?>
        <?php $post_types = Inventor_Post_Types::get_listing_post_types(); ?>
        <?php if (is_singular($post_types)) : ?>
          <?php get_template_part('templates/content-listing-banner'); ?>
        <?php endif; ?>
      <?php endif; ?>
      <div class="main">
        <?php dynamic_sidebar('top-fullwidth'); ?>
        <div class="main-inner">
          <div class="container">
            <?php dynamic_sidebar('top'); ?>

<?php
/**
 * The template for displaying header
 *
 * @package Superlist
 * @since Superlist 1.0.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); } ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if ( class_exists( 'Inventor_Template_Loader' ) ) :   ?>
    <?php echo Inventor_Template_Loader::load( 'misc/messages' ); ?>
<?php endif; ?>

<div class="page-wrapper">
    <header class="header header-minimal">
        <?php if ( is_active_sidebar( 'header-topbar-left' ) || is_active_sidebar( 'header-topbar-right' ) ) : ?>
            <div class="header-bar">
                <div class="container">
                    <div class="header-bar-inner">
                        <?php if ( is_active_sidebar( 'header-topbar-left' ) ) : ?>
                            <div class="header-bar-left">
                                <?php dynamic_sidebar( 'header-topbar-left' ); ?>
                            </div><!-- /.header-bar-left -->
                        <?php endif; ?>

                        <?php if ( is_active_sidebar( 'header-topbar-right' ) ) : ?>
                            <div class="header-bar-right">
                                <?php dynamic_sidebar( 'header-topbar-right' ); ?>
                            </div><!-- /.header-bar-right -->
                        <?php endif; ?>
                    </div><!-- /.header-bar-inner -->
                </div><!-- /.container -->
            </div><!-- /.header-bar -->
        <?php endif; ?>

        <div class="header-wrapper affix-top">
            <div class="container">
                <div class="header-inner">
                    <div class="header-logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <?php if ( get_theme_mod( 'superlist_logo' ) ) : ?>
                                <img src="<?php echo esc_attr( get_theme_mod( 'superlist_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                            <?php else : ?>
                                <i class="superlist-logo"></i>
                            <?php endif; ?>

                            <?php if ( display_header_text() ) : ?>
                                <span><?php bloginfo( 'name' ); ?></span>
                            <?php endif; ?>
                        </a>
                    </div><!-- /.header-logo -->

                    <div class="header-content">
                        <div class="header-bottom">
                            <?php if ( has_nav_menu( 'main' ) ) : ?>
                                <?php wp_nav_menu( array(
									'container_class'   => 'header-nav-container',
									'fallback_cb'		=> '',
									'theme_location'    => 'main',
									'menu_class'        => 'header-nav-primary nav nav-pills collapse navbar-collapse',
								) ); ?>
                            <?php endif; ?>

                            <?php if ( get_theme_mod( 'superlist_general_action' ) ) : ?>
                                <div class="header-action">
                                    <a href="<?php echo esc_attr( get_permalink( get_theme_mod( 'superlist_general_action' ) ) ); ?>" class="header-action-inner" title="<?php echo esc_attr( get_theme_mod( 'superlist_general_action_text' ) ); ?>" data-toggle="tooltip" data-placement="left">
                                        <i class="fa fa-plus"></i>
                                    </a><!-- /.header-action-inner -->
                                </div><!-- /.header-action -->
                            <?php endif; ?>

                            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".header-nav-primary">
                                <span class="sr-only"><?php echo esc_attr__( 'Toggle navigation', 'superlist' ); ?></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div><!-- /.header-bottom -->
                    </div><!-- /.header-content -->
                </div><!-- /.header-inner -->
            </div><!-- /.container -->

            <?php if ( class_exists( 'Inventor_Post_Types' ) ) : ?>
                <div class="header-post-types">
                    <div class="container">
                        <?php $post_types = Inventor_Post_Types::get_listing_post_types(); ?>
                        <?php $page_id = get_theme_mod( 'inventor_submission_create_page' ); ?>
                        <?php $page_permalink = get_permalink( $page_id ); ?>

                        <?php if ( ! empty( $post_types ) ) : ?>
                            <ul>
                                <?php foreach ( $post_types as $post_type ) : ?>
                                    <li>
                                        <a href="<?php echo esc_attr( $page_permalink ); ?>?type=<?php echo esc_attr( $post_type ); ?>">
                                            <?php echo esc_attr( get_post_type_object( $post_type )->labels->singular_name ); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div><!-- /.container -->
                </div><!-- /.header-post-types -->
            <?php endif; ?>
        </div><!-- /.header-wrapper -->
    </header><!-- /.header -->

    <?php if ( class_exists( 'Inventor_Post_Types' ) ) : ?>
        <?php $post_types = Inventor_Post_Types::get_listing_post_types(); ?>
        <?php if ( is_singular( $post_types ) ) : ?>
            <?php get_template_part( 'templates/content-listing-banner' ); ?>
        <?php endif; ?>
    <?php endif; ?>

    <div class="main">

        <?php dynamic_sidebar( 'top-fullwidth' ); ?>

        <div class="main-inner">
            <div class="container">
                <?php dynamic_sidebar( 'top' ); ?>

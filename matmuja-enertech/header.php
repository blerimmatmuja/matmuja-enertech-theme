<?php
/**
 * Theme header
 *
 * @package matmuja-tiefbau
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container site-header__inner">
        <a class="site-header__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php if ( has_custom_logo() ) {
                the_custom_logo();
            } else {
                bloginfo( 'name' );
            } ?>
        </a>
        <nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'matmuja-tiefbau' ); ?>">
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'site-nav__list',
                'fallback_cb'    => '__return_empty_string',
                'depth'          => 1,
            ] );
            ?>
        </nav>
    </div>
</header>

<main class="site-main">

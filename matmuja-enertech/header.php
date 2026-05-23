<?php
/**
 * Theme header — v5
 *
 * @package matmuja-tiefbau
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#f7f8fa">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" role="banner">
    <div class="shell">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="wordmark" rel="home">
            M&amp;M EnerTech
        </a>

        <button class="nav-toggle" aria-label="Menü öffnen" aria-expanded="false" type="button">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 7h16M4 12h16M4 17h16"/>
            </svg>
        </button>

        <nav class="primary-nav" aria-label="Hauptnavigation">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                ] );
            } else {
                ?>
                <a href="#phases">Prozess</a>
                <a href="#team">Über uns</a>
                <a href="#faq">FAQ</a>
                <?php
            }
            ?>
            <a class="nav-cta" href="#cta">Kontakt aufnehmen</a>
        </nav>
    </div>
</header>

<main class="site-main">

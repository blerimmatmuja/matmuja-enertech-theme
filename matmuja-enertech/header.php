<?php
/**
 * Theme header — v6 "Enfaser"
 *
 * @package matmuja-tiefbau
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#13102B">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" role="banner">
    <div class="shell">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="wordmark" rel="home" aria-label="M&amp;M Enfaser — Startseite">
            <svg viewBox="-100 -100 200 200" fill="none" aria-hidden="true">
                <defs>
                    <linearGradient id="mm-mark" x1="-82" y1="34" x2="82" y2="-56" gradientUnits="userSpaceOnUse">
                        <stop offset="0" stop-color="#B3A6F7"/><stop offset=".55" stop-color="#8B7BF0"/><stop offset="1" stop-color="#E6C25E"/>
                    </linearGradient>
                </defs>
                <g stroke-linecap="round" transform="scale(.9)">
                    <path d="M-82,34 C-44,-54 -14,58 12,-4 C32,-46 56,-40 82,-56" stroke="url(#mm-mark)" stroke-width="9"/>
                    <circle cx="-82" cy="34" r="6" fill="#E6C25E"/>
                    <circle cx="82" cy="-56" r="7" fill="#fff"/>
                </g>
            </svg>
            <span>M<span class="amp">&amp;</span>M&nbsp;Enfaser</span>
        </a>

        <button class="nav-toggle" aria-label="Menü öffnen" aria-expanded="false" aria-controls="primary-nav" type="button">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M4 7h16M4 12h16M4 17h16"/>
            </svg>
        </button>

        <nav class="primary-nav" id="primary-nav" aria-label="Hauptnavigation">
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
                <a href="#process">Prozess</a>
                <a href="#team">Über uns</a>
                <a href="#faq">FAQ</a>
                <?php
            }
            ?>
            <a class="nav-cta" href="#cta">Kontakt&nbsp;→</a>
        </nav>
    </div>
</header>

<main class="site-main">

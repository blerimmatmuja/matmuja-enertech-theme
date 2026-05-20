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
            // If a custom menu is assigned to the primary location, use it.
            // Otherwise render a sensible fallback so the header is never empty.
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'site-nav__list',
                    'depth'          => 1,
                ] );
            } else {
                $home   = esc_url( home_url( '/' ) );
                $links  = [
                    [ $home . '#prozess',  __( 'Prozess', 'matmuja-tiefbau' ) ],
                    [ esc_url( home_url( '/ueber-uns' ) ), __( 'Über uns', 'matmuja-tiefbau' ) ],
                    [ $home . '#faq',      __( 'FAQ', 'matmuja-tiefbau' ) ],
                    [ $home . '#kontakt',  __( 'Kontakt', 'matmuja-tiefbau' ) ],
                ];
                echo '<ul class="site-nav__list">';
                foreach ( $links as $link ) {
                    printf( '<li><a href="%s">%s</a></li>', esc_url( $link[0] ), esc_html( $link[1] ) );
                }
                echo '</ul>';
            }
            ?>
        </nav>
    </div>
</header>

<main class="site-main">

<?php
/**
 * Header Template
 * @package matmuja-tiefbau
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <div class="container">
        <nav class="navbar" aria-label="Main Navigation">

            <?php // ─── LOGO ─────────────────── ?>
            <a href="<?php echo esc_url( home_url('/') ); ?>" class="site-logo" rel="home">
                <?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
                <span class="logo-text">
                    M&M EnerTech
                    <small class="logo-sub">Tiefbau Gesellschaft mbH</small>
                </span>
                <?php endif; ?>
            </a>

            <?php // ─── NAVIGATION ───────────── ?>
            <div class="nav-menu" id="nav-menu">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'fallback_cb'    => function() {
                        ?>
                        <div class="nav-dropdown">
                            <a href="#"><?php _e('Dienstleistungen', 'matmuja-tiefbau'); ?></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><?php _e('Befahrung und Adressvalidierung', 'matmuja-tiefbau'); ?></a></li>
                                <li><a href="#"><?php _e('Planung und Design', 'matmuja-tiefbau'); ?></a></li>
                                <li><a href="#"><?php _e('Projektmanagement', 'matmuja-tiefbau'); ?></a></li>
                                <li><a href="#"><?php _e('Tiefbau und Verlegung', 'matmuja-tiefbau'); ?></a></li>
                                <li><a href="#"><?php _e('Installation und Inbetriebnahme', 'matmuja-tiefbau'); ?></a></li>
                                <li><a href="#"><?php _e('Kundenaktivierung', 'matmuja-tiefbau'); ?></a></li>
                                <li><a href="#"><?php _e('Wartung und Support', 'matmuja-tiefbau'); ?></a></li>
                            </ul>
                        </div>
                        <a href="<?php echo esc_url(home_url('/ueber-uns')); ?>"><?php _e('Über Uns', 'matmuja-tiefbau'); ?></a>
                        <a href="<?php echo esc_url(home_url('/karriere')); ?>"><?php _e('Karriere', 'matmuja-tiefbau'); ?></a>
                        <a href="<?php echo esc_url(home_url('/aktuelles')); ?>"><?php _e('Aktuelles', 'matmuja-tiefbau'); ?></a>
                        <a href="<?php echo esc_url(home_url('/kontakt')); ?>" class="btn btn-gold"><?php _e('Kontakt', 'matmuja-tiefbau'); ?></a>
                        <?php
                    },
                ]);
                ?>
            </div>

            <?php // ─── MOBILE TOGGLE ─────────── ?>
            <button class="nav-toggle" id="nav-toggle" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle Menu', 'matmuja-tiefbau'); ?>">
                <span></span><span></span><span></span>
            </button>

        </nav>
    </div>
</header>

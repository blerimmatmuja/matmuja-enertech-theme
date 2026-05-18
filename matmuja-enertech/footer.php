<?php
/**
 * Theme footer
 *
 * @package matmuja-tiefbau
 */
?>
</main><!-- .site-main -->

<?php
$phone     = get_theme_mod( 'matmuja_phone',     '' );
$email     = get_theme_mod( 'matmuja_email',     '' );
$instagram = get_theme_mod( 'matmuja_instagram', '' );
$linkedin  = get_theme_mod( 'matmuja_linkedin',  '' );
?>
<footer class="site-footer">
    <div class="container site-footer__inner">
        <div class="site-footer__brand">
            &copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
            <?php if ( $phone || $email ) : ?>
                <span class="site-footer__contact">
                    <?php if ( $phone ) : ?>
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
                    <?php endif; ?>
                    <?php if ( $phone && $email ) echo ' · '; ?>
                    <?php if ( $email ) : ?>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                    <?php endif; ?>
                </span>
            <?php endif; ?>
        </div>
        <div class="site-footer__right">
            <?php if ( $instagram || $linkedin ) : ?>
                <nav class="site-footer__social" aria-label="<?php esc_attr_e( 'Social media', 'matmuja-tiefbau' ); ?>">
                    <?php if ( $instagram && '#' !== $instagram ) : ?>
                        <a href="<?php echo esc_url( $instagram ); ?>" rel="noopener" target="_blank">Instagram</a>
                    <?php endif; ?>
                    <?php if ( $linkedin && '#' !== $linkedin ) : ?>
                        <a href="<?php echo esc_url( $linkedin ); ?>" rel="noopener" target="_blank">LinkedIn</a>
                    <?php endif; ?>
                </nav>
            <?php endif; ?>
            <nav class="site-footer__legal" aria-label="<?php esc_attr_e( 'Legal', 'matmuja-tiefbau' ); ?>">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'site-footer__legal-list',
                    'fallback_cb'    => '__return_empty_string',
                    'depth'          => 1,
                ] );
                ?>
            </nav>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

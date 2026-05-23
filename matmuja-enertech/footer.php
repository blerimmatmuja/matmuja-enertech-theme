<?php
/**
 * Theme footer — v5
 *
 * @package matmuja-tiefbau
 */
$phone = get_theme_mod( 'matmuja_phone', '' );
$email = get_theme_mod( 'matmuja_email', 'info@matmuja.de' );
$address = get_theme_mod( 'matmuja_address', '' );
$instagram = get_theme_mod( 'matmuja_instagram', '' );
$linkedin  = get_theme_mod( 'matmuja_linkedin', '' );
?>
</main><!-- .site-main -->

<footer class="site-footer" role="contentinfo">
    <div class="shell">
        <div class="footer-brand">
            <div class="wordmark">M&amp;M EnerTech</div>
            <p class="tagline">FTTH end-to-end. Vom Spaten bis zur Buchse.</p>
        </div>
        <div class="footer-contact">
            <h4>Kontakt</h4>
            <ul>
                <?php if ( $phone ) : ?>
                    <li><a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></li>
                <?php endif; ?>
                <li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
                <?php if ( $address ) : ?>
                    <li><?php echo nl2br( esc_html( $address ) ); ?></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="footer-links">
            <h4>Rechtliches</h4>
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/impressum' ) ); ?>">Impressum</a></li>
                <li><a href="<?php echo esc_url( home_url( '/datenschutz' ) ); ?>">Datenschutz</a></li>
                <li><a href="#cta">Kontakt</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <div>© <?php echo esc_html( date( 'Y' ) ); ?> M&amp;M EnerTech UG</div>
        <div class="footer-social">
            <?php if ( $instagram ) : ?>
                <a href="<?php echo esc_url( $instagram ); ?>" aria-label="Instagram" target="_blank" rel="noopener">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="4"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.5" fill="currentColor"/></svg>
                </a>
            <?php endif; ?>
            <?php if ( $linkedin ) : ?>
                <a href="<?php echo esc_url( $linkedin ); ?>" aria-label="LinkedIn" target="_blank" rel="noopener">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="8" y1="10" x2="8" y2="17"/><circle cx="8" cy="7" r="0.5" fill="currentColor"/><path d="M12 17v-4a2 2 0 0 1 4 0v4M12 10v7"/></svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>

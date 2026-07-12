<?php
/**
 * Theme footer — v6 "Enfaser"
 *
 * @package matmuja-tiefbau
 */
$phone     = get_theme_mod( 'matmuja_phone', '' );
$email     = get_theme_mod( 'matmuja_email', 'info@matmuja.de' );
$addr1     = get_theme_mod( 'matmuja_address_line1', '' );
$addr2     = get_theme_mod( 'matmuja_address_line2', '' );
$instagram = get_theme_mod( 'matmuja_instagram', '' );
$linkedin  = get_theme_mod( 'matmuja_linkedin', '' );
?>
</main><!-- .site-main -->

<footer class="site-footer" role="contentinfo">
    <div class="shell">
        <div class="footer-brand">
            <div class="wordmark">
                <svg viewBox="-100 -100 200 200" fill="none" aria-hidden="true" style="width:28px;height:28px">
                    <g stroke-linecap="round" transform="scale(.9)">
                        <path d="M-82,34 C-44,-54 -14,58 12,-4 C32,-46 56,-40 82,-56" stroke="url(#mm-mark)" stroke-width="9"/>
                        <circle cx="-82" cy="34" r="6" fill="#E6C25E"/><circle cx="82" cy="-56" r="7" fill="#fff"/>
                    </g>
                </svg>
                <span>M<span class="amp">&amp;</span>M&nbsp;Enfaser</span>
            </div>
            <p class="tagline">FTTH end-to-end. Vom Spaten bis zur Buchse.</p>
        </div>
        <div class="footer-contact">
            <h4>Kontakt</h4>
            <ul>
                <?php if ( $phone ) : ?>
                    <li><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
                <?php endif; ?>
                <li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
                <?php if ( $addr1 || $addr2 ) : ?>
                    <li><?php echo esc_html( trim( $addr1 . ' · ' . $addr2, ' ·' ) ); ?></li>
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
        <div>© <?php echo esc_html( date( 'Y' ) ); ?> M&amp;M Enfaser · Deutscher FTTH-Tiefbaubetrieb</div>
        <div class="footer-social">
            <?php if ( $instagram && '#' !== $instagram ) : ?>
                <a href="<?php echo esc_url( $instagram ); ?>" aria-label="Instagram" target="_blank" rel="noopener">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="4"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.5" fill="currentColor"/></svg>
                </a>
            <?php endif; ?>
            <?php if ( $linkedin && '#' !== $linkedin ) : ?>
                <a href="<?php echo esc_url( $linkedin ); ?>" aria-label="LinkedIn" target="_blank" rel="noopener">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="8" y1="10" x2="8" y2="17"/><circle cx="8" cy="7" r="0.5" fill="currentColor"/><path d="M12 17v-4a2 2 0 0 1 4 0v4M12 10v7"/></svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>

<?php
/**
 * Theme footer
 *
 * @package matmuja-tiefbau
 */
?>
</main><!-- .site-main -->

<footer class="site-footer">
    <div class="container site-footer__inner">
        <div class="site-footer__brand">
            &copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
        </div>
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
</footer>

<?php wp_footer(); ?>
</body>
</html>

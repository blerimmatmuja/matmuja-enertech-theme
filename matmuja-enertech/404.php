<?php
/**
 * 404 Page Template
 * @package matmuja-tiefbau
 */
get_header();
?>
<div style="padding-top:70px;">
    <div class="container error-404">
        <div>
            <h1>404</h1>
            <h2><?php _e('Seite nicht gefunden', 'matmuja-tiefbau'); ?></h2>
            <p><?php _e('Die von Ihnen gesuchte Seite konnte leider nicht gefunden werden.', 'matmuja-tiefbau'); ?></p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary"><?php _e('Zurück zur Startseite', 'matmuja-tiefbau'); ?></a>
        </div>
    </div>
</div>
<?php get_footer(); ?>

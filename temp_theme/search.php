<?php
/**
 * Search Results Template
 * @package matmuja-tiefbau
 */
get_header();
?>
<div class="archive-header">
    <div class="container">
        <h1><?php printf( __('Suchergebnisse für: %s', 'matmuja-tiefbau'), '<em>' . get_search_query() . '</em>' ); ?></h1>
    </div>
</div>
<div class="container" style="padding:3rem 0;">
    <?php if ( have_posts() ) : ?>
    <div class="news-grid">
        <?php while ( have_posts() ) : the_post(); ?>
        <article class="news-card">
            <?php if (has_post_thumbnail()): ?><?php the_post_thumbnail('matmuja-card',['class'=>'news-card-img']); ?><?php else: ?><div class="news-card-img-placeholder"></div><?php endif; ?>
            <div class="news-card-body">
                <h3 class="news-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <p class="news-card-excerpt"><?php echo esc_html(matmuja_excerpt(18)); ?></p>
                <a href="<?php the_permalink(); ?>" class="news-card-link"><?php _e('Mehr lesen','matmuja-tiefbau'); ?></a>
            </div>
        </article>
        <?php endwhile; ?>
    </div>
    <?php the_posts_pagination(['prev_text'=>'&larr;','next_text'=>'&rarr;','class'=>'pagination']);
    else: echo '<p>'.__('Keine Ergebnisse gefunden.','matmuja-tiefbau').'</p>'; endif; ?>
</div>
<?php get_footer(); ?>

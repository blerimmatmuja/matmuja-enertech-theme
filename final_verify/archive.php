<?php
/**
 * Archive Template
 * @package matmuja-tiefbau
 */
get_header();
?>
<div class="archive-header">
    <div class="container">
        <h1><?php the_archive_title(); ?></h1>
        <?php the_archive_description('<p>','</p>'); ?>
    </div>
</div>
<div class="container">
    <div class="archive-grid">
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
        <article class="news-card">
            <?php if (has_post_thumbnail()): the_post_thumbnail('matmuja-card',['class'=>'news-card-img']); else: ?><div class="news-card-img-placeholder"></div><?php endif; ?>
            <div class="news-card-body">
                <?php $cats=get_the_category(); if($cats): ?><span class="news-card-tag"><?php echo esc_html($cats[0]->name); ?></span><?php endif; ?>
                <h2 class="news-card-title" style="font-size:1.1rem;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p class="news-card-excerpt"><?php echo esc_html(matmuja_excerpt(18)); ?></p>
                <a href="<?php the_permalink(); ?>" class="news-card-link"><?php _e('Mehr lesen','matmuja-tiefbau'); ?></a>
            </div>
        </article>
        <?php endwhile;
        the_posts_pagination(['prev_text'=>'&larr;','next_text'=>'&rarr;','class'=>'pagination']);
        else: echo '<p>'.__('Keine Beiträge gefunden.','matmuja-tiefbau').'</p>';
        endif; ?>
    </div>
</div>
<?php get_footer(); ?>

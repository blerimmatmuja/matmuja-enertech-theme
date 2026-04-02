<?php
/**
 * Main Index / Blog Template
 * @package matmuja-tiefbau
 */
get_header();
?>

<div class="archive-header">
    <div class="container">
        <h1><?php _e('Aktuelles', 'matmuja-tiefbau'); ?></h1>
        <p><?php _e('Neuigkeiten und Beiträge von M&M EnerTech', 'matmuja-tiefbau'); ?></p>
    </div>
</div>

<div class="container">
    <div style="display:grid;grid-template-columns:1fr 300px;gap:3rem;padding:3rem 0;" class="blog-layout">

        <main id="main" class="site-main">
            <?php if ( have_posts() ) : ?>
            <div class="archive-grid" style="padding:0;grid-template-columns:1fr 1fr;">
                <?php while ( have_posts() ) : the_post(); ?>
                <article class="news-card">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('matmuja-card', ['class' => 'news-card-img']); ?>
                        </a>
                    <?php else : ?>
                        <div class="news-card-img-placeholder"></div>
                    <?php endif; ?>
                    <div class="news-card-body">
                        <?php $cats = get_the_category(); if ($cats): ?>
                        <span class="news-card-tag"><?php echo esc_html($cats[0]->name); ?></span>
                        <?php else: ?>
                        <span class="news-card-tag"><?php _e('Informationen','matmuja-tiefbau'); ?></span>
                        <?php endif; ?>
                        <h2 class="news-card-title" style="font-size:1.1rem;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p class="news-card-excerpt"><?php echo esc_html(matmuja_excerpt(18)); ?></p>
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.8rem;color:var(--color-text-light);">
                            <span><?php matmuja_posted_on(); ?></span>
                            <a href="<?php the_permalink(); ?>" class="news-card-link"><?php _e('Mehr lesen', 'matmuja-tiefbau'); ?></a>
                        </div>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>
            <?php
            the_posts_pagination([
                'prev_text' => '&larr;',
                'next_text' => '&rarr;',
                'class'     => 'pagination',
            ]);
            else :
                echo '<p style="padding:2rem 0;color:var(--color-text-light);">' . __('Noch keine Beiträge vorhanden.', 'matmuja-tiefbau') . '</p>';
            endif;
            ?>
        </main>

        <aside class="sidebar">
            <?php dynamic_sidebar('sidebar-1'); ?>
        </aside>

    </div>
</div>

<?php get_footer(); ?>

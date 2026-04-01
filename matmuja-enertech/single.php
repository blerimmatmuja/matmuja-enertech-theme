<?php
/**
 * Single Post Template
 * @package matmuja-tiefbau
 */
get_header();
while ( have_posts() ) : the_post();
?>

<div class="single-hero">
    <div class="container">
        <div class="post-meta">
            <?php $cats = get_the_category(); if ($cats): ?>
            <span class="post-tag"><?php echo esc_html($cats[0]->name); ?></span>
            <?php endif; ?>
            <span><?php matmuja_posted_on(); ?></span> &mdash;
            <span><?php matmuja_posted_by(); ?></span>
        </div>
        <h1 style="max-width:800px;margin-top:1rem;"><?php the_title(); ?></h1>
    </div>
</div>

<div class="container">
    <article class="single-content">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail('matmuja-hero', ['style' => 'border-radius:16px;width:100%;']); ?>
        <?php endif; ?>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </article>

    <?php
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    if ( $prev_post || $next_post ) : ?>
    <nav class="post-navigation" style="display:flex;justify-content:space-between;padding:2rem 0;border-top:1px solid var(--color-border);max-width:800px;margin:0 auto;">
        <?php if ($prev_post): ?>
        <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" style="color:var(--color-primary);font-weight:600;font-size:0.9rem;">
            &larr; <?php echo esc_html(get_the_title($prev_post)); ?>
        </a>
        <?php endif; ?>
        <?php if ($next_post): ?>
        <a href="<?php echo esc_url(get_permalink($next_post)); ?>" style="color:var(--color-primary);font-weight:600;font-size:0.9rem;margin-left:auto;">
            <?php echo esc_html(get_the_title($next_post)); ?> &rarr;
        </a>
        <?php endif; ?>
    </nav>
    <?php endif; ?>

    <?php if ( comments_open() || get_comments_number() ) : ?>
    <div style="max-width:800px;margin:0 auto;">
        <?php comments_template(); ?>
    </div>
    <?php endif; ?>
</div>

<?php endwhile; get_footer(); ?>

<?php
/**
 * Default Page Template
 * @package matmuja-tiefbau
 */
get_header();
while ( have_posts() ) : the_post();
?>

<div class="page-hero">
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <?php if ( has_excerpt() ) : ?>
        <p><?php the_excerpt(); ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <div class="page-content">
        <?php if ( has_post_thumbnail() ) : ?>
        <?php the_post_thumbnail('matmuja-hero', ['style' => 'border-radius:16px;margin-bottom:2rem;width:100%;']); ?>
        <?php endif; ?>
        <?php the_content(); ?>
    </div>
</div>

<?php endwhile; get_footer(); ?>

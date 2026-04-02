<?php
/**
 * Template Tags
 * @package matmuja-tiefbau
 */

if ( ! function_exists( 'matmuja_pagination' ) ) :
function matmuja_pagination() {
    the_posts_pagination([
        'prev_text' => '&larr; ' . __( 'Vorherige', 'matmuja-tiefbau' ),
        'next_text' => __( 'Nächste', 'matmuja-tiefbau' ) . ' &rarr;',
        'mid_size'  => 2,
        'class'     => 'pagination',
    ]);
}
endif;

if ( ! function_exists( 'matmuja_breadcrumbs' ) ) :
function matmuja_breadcrumbs() {
    if ( is_front_page() ) return;
    echo '<nav class="breadcrumbs" style="padding:1rem 0;font-size:0.85rem;color:rgba(255,255,255,0.6);">';
    echo '<a href="' . esc_url(home_url('/')) . '" style="color:rgba(255,255,255,0.6);">' . __('Startseite','matmuja-tiefbau') . '</a>';
    echo ' <span style="margin:0 0.5rem;">/</span> ';
    if ( is_singular() ) {
        echo '<span style="color:var(--color-gold);">' . get_the_title() . '</span>';
    } elseif ( is_archive() ) {
        echo '<span style="color:var(--color-gold);">' . get_the_archive_title() . '</span>';
    }
    echo '</nav>';
}
endif;

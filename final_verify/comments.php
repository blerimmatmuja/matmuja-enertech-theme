<?php
/**
 * Comments Template
 * @package matmuja-tiefbau
 */
if ( post_password_required() ) return;
?>
<div class="comments-area">
    <?php if ( have_comments() ) : ?>
    <h3><?php comments_number(__('Keine Kommentare','matmuja-tiefbau'),__('1 Kommentar','matmuja-tiefbau'),__('%d Kommentare','matmuja-tiefbau')); ?></h3>
    <ol class="comment-list" style="padding:0;list-style:none;">
        <?php wp_list_comments(['style'=>'ol','short_ping'=>true,'avatar_size'=>48]); ?>
    </ol>
    <?php the_comments_navigation(); ?>
    <?php endif; ?>
    <?php comment_form(['class_form'=>'comment-form']); ?>
</div>

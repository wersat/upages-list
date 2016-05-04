<?php global $post;

if ($post->post_content === '') { ?>
    <div class="listing-detail-section" id="listing-detail-section-description">
      <h2 class="page-header"><?= $section_title; ?></h2>
        <?php the_content(); ?>
    </div>
<?php }

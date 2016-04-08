<div class="submission-step-title">
  <h1><?php echo $listing_type_title; ?></h1>
  <h2>
    <?php $index = 1; ?>
    <?php foreach ($steps as $step) : ?>
      <?php if ($step['id'] == $current_step) : ?>
        <span><?php echo esc_attr($index); ?>. <?php echo __('step'); ?></span> <?php echo $step['title']; ?>
      <?php endif; ?>
      <?php ++$index; ?>
    <?php endforeach; ?>
  </h2>
</div>

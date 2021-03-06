<?php if (! empty($steps)) : ?>
  <ul class="submission-steps">
    <?php $clickable = true; ?>
    <?php $index = 0; ?>
    <?php $found = false; ?>

    <?php foreach ($steps as $step) : ?>
      <li class="submission-step <?php if ($found === false || ! empty($_GET['id'])) : ?>processed<?php else : ?>awaiting<?php 
     endif; ?> <?php if ($step['id'] === $current_step) :
            $found = true; ?>current<?php 
     endif; ?>">
        <?php if ($clickable) : ?>
        <a href="?type=<?php echo esc_attr($post_type); ?>&step=<?php echo esc_attr($step['id']); ?><?php if (! empty($_GET['id'])) {
            echo esc_attr('&id=' . $_GET['id']);
}; ?>">
            <?php else : ?>
          <a class="inactive">
            <?php endif; ?>
            <span class="submission-step-index"><?php echo esc_attr($index) + 1; ?>
              <span class="dot">.</span></span>
            <?php echo esc_attr($step['title']); ?>
          </a>
            <?php ++$index; ?>
      </li>
        <?php if ($step['id'] === $current_step && empty($_GET['id'])) : ?>
        <?php $clickable = false; ?>
        <?php endif; ?>
    <?php endforeach; ?>
  </ul>
<?php else : ?>
    <?php echo __('Nothing to show.', 'inventor'); ?>
<?php endif; ?>

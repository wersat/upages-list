<?php
  $reports_config = Inventor_Reports::get_config();
  $report_page = $reports_config['page'];
if (! empty($report_page)) : ?>
  <div class="listing-report">
    <a href="<?= get_permalink($report_page); ?>?id=<?php the_ID(); ?>" class="listing-report-btn">
      <i class="fa fa-flag-o"></i>
      <span><?= __('Report spam, abuse, or inappropriate content', 'inventor'); ?></span>
    </a>
  </div>
<?php endif; ?>

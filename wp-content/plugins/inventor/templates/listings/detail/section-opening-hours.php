<?php
  $if_allowed_opening_hours = apply_filters('inventor_submission_listing_metabox_allowed', true, 'opening_hours',
    get_the_author_meta('ID'));
  if ($if_allowed_opening_hours):
    $opening_hours = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'opening_hours', true);
    $visible                = Inventor_Post_Types::opening_hours_visible();
    if ( ! empty($opening_hours) && $visible) : ?>
      <div class="listing-detail-section" id="listing-detail-section-opening-hours">
        <h2 class="page-header"><?= $section_title; ?></h2>
        <table class="opening-hours horizontal">
          <?php
            $day_names = [
              'MONDAY'    => __('Monday', 'inventor'),
              'TUESDAY'   => __('Tuesday', 'inventor'),
              'WEDNESDAY' => __('Wednesday', 'inventor'),
              'THURSDAY'  => __('Thursday', 'inventor'),
              'FRIDAY'    => __('Friday', 'inventor'),
              'SATURDAY'  => __('Saturday', 'inventor'),
              'SUNDAY'    => __('Sunday', 'inventor')
            ];
            // preserve first day of week setting
            $opening_hours = array_merge(array_splice($opening_hours, get_option('start_of_week') - 1), $opening_hours);
          ?>
          <thead>
            <tr>
              <?php foreach ((array)$opening_hours as $day): ?>
                <th>
                  <?= $day_names[$day['listing_day']]; ?>
                </th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php foreach ((array)$opening_hours as $day): ?>
                <td class="<?= Inventor_Post_Types::opening_hours_status(get_the_ID(), $day['listing_day']); ?>">
                  <?= Inventor_Post_Types::opening_hours_format_day($day, true); ?>
                </td>
              <?php endforeach; ?>
            </tr>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  <?php endif; ?>

<?php
  if ( ! defined('ABSPATH')) {
    exit;
  }
?>
<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
<?php query_posts([
  'post_type' => 'transaction',
  'paged'     => $paged,
  'author'    => get_current_user_id(),
]); ?>
<?php if (have_posts()) : ?>
  <table class="transactions-table">
    <thead>
      <th><?php echo __('ID', 'inventor'); ?></th>
      <th><?php echo __('Price', 'inventor'); ?></th>
      <th><?php echo __('Gateway', 'inventor'); ?></th>
      <th><?php echo __('Object', 'inventor'); ?></th>
      <th><?php echo __('Payment Type', 'inventor'); ?></th>
      <th><?php echo __('Status', 'inventor'); ?></th>
      <th><?php echo __('Date', 'inventor'); ?></th>
    </thead>
    <tbody>
      <?php while (have_posts()) : the_post(); ?>
        <?php
        $data            = get_post_meta(get_the_ID(), INVENTOR_TRANSACTION_PREFIX . 'data', true);
        $data            = unserialize($data);
        $object_id       = get_post_meta(get_the_ID(), INVENTOR_TRANSACTION_PREFIX . 'object_id', true);
        $gateway         = get_post_meta(get_the_ID(), INVENTOR_TRANSACTION_PREFIX . 'gateway', true);
        $success         = Inventor_Post_Type_Transaction::is_successful(get_the_ID());
        $payment_type    = get_post_meta(get_the_ID(), INVENTOR_TRANSACTION_PREFIX . 'payment_type', true);
        $price_formatted = empty($data['price_formatted']) ? '' : $data['price_formatted'];
        ?>
        <tr>
          <td>
            <b>#<?php the_ID(); ?></b>
          </td>
          <td><?php echo wp_kses($price_formatted, wp_kses_allowed_html('post')); ?></td>
          <td><?php echo esc_html($gateway); ?></td>
          <td><?php echo sprintf('<a href="%s">%s</a>', get_permalink($object_id), get_the_title($object_id)); ?></td>
          <td>
            <?php
              switch ($payment_type) {
                case 'package':
                  echo __('Package', 'inventor');
                  break;
                default:
                  echo esc_html($payment_type);
                  break;
              }
            ?>
          </td>
          <td>
            <?php
              if ($success) {
                echo '<div class="dashicons-before dashicons-yes green"></div>';
              } else {
                echo '<div class="dashicons-before dashicons-no red"></div>';
              }
            ?>
          </td>
          <td><?php echo get_the_date(); ?> <em>
              <small><?php echo get_the_time(); ?></small>
            </em></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php the_posts_pagination([
    'prev_text'          => __('Previous page', 'inventor'),
    'next_text'          => __('Next page', 'inventor'),
    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'inventor') . ' </span>',
  ]); ?>
<?php else : ?>
  <div class="alert alert-warning"><?php echo __('No transactions found.', 'inventor'); ?></div>
<?php endif; ?>
<?php wp_reset_query(); ?>

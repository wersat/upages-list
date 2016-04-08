<?php
  if (!defined('ABSPATH')) {
      exit;
  }
?>

<?php $create_page_id = get_theme_mod('inventor_submission_create_page', null); ?>

<?php if (!empty($create_page_id)) : ?>
  <?php if (Inventor_Submission::is_allowed_to_add_submission(get_current_user_id())) : ?>
    <a href="<?php echo get_permalink($create_page_id); ?>" class="listing-create"><?php echo __('Create listing',
        'inventor'); ?></a>
  <?php endif; ?>
<?php endif; ?>

<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>

<?php query_posts([
  'post_type' => Inventor_Post_Types::get_listing_post_types(),
  'post_status' => 'any',
  'paged' => $paged,
  'author' => get_current_user_id(),
]); ?>

<?php if (have_posts()) : ?>
  <ul class="listings-system-legend">
    <li class="published"><?php echo esc_attr__('Listing published', 'inventor'); ?></li>
    <li class="in-review"><?php echo esc_attr__('Waiting for review', 'inventor'); ?></li>
    <li class="disabled"><?php echo esc_attr__('Listing disabled', 'inventor'); ?></li>
  </ul>
  <div class="listings-system">
    <?php while (have_posts()) : the_post(); ?>
      <div class="listing-system">
        <div class="listing-system-row">
          <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium'); ?>
          <div class="listing-system-row-image">
            <a href="<?php the_permalink(); ?>" style="background-image: url('<?php if (has_post_thumbnail()) : ?><?php echo esc_attr($image[0]); ?><?php else : ?><?php echo plugins_url('inventor'); ?>/assets/img/default-item.png<?php endif; ?>')">
              <?php if (get_post_status() == 'pending') : ?>
                <div class="ribbon warning">
                  <?php echo esc_attr__('Pending', 'inventor'); ?>
                </div>
              <?php elseif (get_post_status() == 'publish') : ?>
                <div class="ribbon publish">
                  <?php echo esc_attr__('Published', 'inventor'); ?>
                </div>
              <?php elseif (get_post_status() == 'draft') : ?>
                <div class="ribbon draft">
                  <?php echo esc_attr__('Disabled', 'inventor'); ?>
                </div>
              <?php endif; ?>
            </a>
          </div>
          <div class="listing-system-row-info">
            <div class="listing-system-row-title">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </div>
            <?php $post_type = get_post_type(); ?>
            <?php $post_type_object = get_post_type_object($post_type); ?>
            <?php $listing_type = $post_type_object->labels->singular_name; ?>

            <?php if (!empty($listing_type)) : ?>
              <div class="listing-system-row-listing-type <?php echo $post_type; ?>">
                <?php echo wp_kses($listing_type, wp_kses_allowed_html('post')); ?>
              </div>
            <?php endif; ?>

            <?php $location = Inventor_Query::get_listing_location_name(); ?>
            <?php if (!empty($location)) : ?>
              <div class="listing-system-row-location">
                <?php echo wp_kses($location, wp_kses_allowed_html('post')); ?>
              </div>
            <?php endif; ?>
            <div class="listing-system-row-additional">
              <?php do_action('inventor_submission_list_row', get_the_ID()); ?>
            </div>
          </div>
          <div class="listing-system-row-actions">
            <?php $edit_page_id = get_theme_mod('inventor_submission_edit_page', null); ?>
            <?php $remove_page_id = get_theme_mod('inventor_submission_remove_page', null); ?>

            <?php if (!empty($edit_page_id)) : ?>
              <a href="<?php echo get_permalink($edit_page_id); ?>?type=<?php echo get_post_type(); ?>&id=<?php the_ID(); ?>" class="listing-table-action">
                <i class="fa fa-pencil"></i> <?php echo __('Edit', 'inventor'); ?>
              </a>
            <?php endif; ?>

            <?php if (!empty($remove_page_id)) : ?>
              <a href="<?php echo get_permalink($remove_page_id); ?>?id=<?php the_ID(); ?>" class="listing-table-action listing-button-delete">
                <i class="fa fa-close"></i> <?php echo __('Remove', 'inventor'); ?>
              </a>
            <?php endif; ?>

            <?php do_action('inventor_submission_list_row_actions', get_the_ID()); ?>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
  <?php the_posts_pagination([
    'prev_text' => __('Previous page', 'inventor'),
    'next_text' => __('Next page', 'inventor'),
    'before_page_number' => '<span class="meta-nav screen-reader-text">'.__('Page', 'inventor').' </span>',
  ]); ?>
  <?php wp_reset_query(); ?>
<?php else : ?>
  <div class="alert alert-warning">
    <?php echo __('You don\'t have any listings, yet. Start by creating new one.') ?>
  </div>
<?php endif; ?>

<?php if (apply_filters('inventor_submission_listing_metabox_allowed', true, 'contact', get_the_author_meta('ID'))): ?>
  <?php $email = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX.'email', true); ?>
  <?php $website = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX.'website', true); ?>
  <?php $phone = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX.'phone', true); ?>
  <?php $address = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX.'address', true); ?>
  <?php if (!empty($email) || !empty($website) || !empty($phone) || !empty($address)) : ?>
    <div class="listing-detail-section" id="listing-detail-section-contact">
      <h2 class="page-header"><?php echo __('Contact', 'inventor'); ?></h2>
      <div class="listing-detail-contact">
        <div class="row">
          <div class="col-md-6">
            <ul>
              <?php if (!empty($email)): ?>
                <li class="email">
                  <strong class="key"><?php echo __('E-mail', 'inventor'); ?></strong>
                                        <span class="value">
                                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_attr($email); ?></a>
                                        </span>
                </li>
              <?php endif; ?>
              <?php if (!empty($website)): ?>
                <li class="website">
                  <strong class="key"><?php echo __('Website', 'inventor'); ?></strong>
                                        <span class="value">
                                            <a href="<?php echo esc_attr($website); ?>"><?php echo esc_attr($website); ?></a>
                                        </span>
                </li>
              <?php endif; ?>
              <?php if (!empty($phone)): ?>
                <li class="phone">
                  <strong class="key"><?php echo __('Phone', 'inventor'); ?></strong>
                  <span class="value"><?php echo wp_kses($phone, wp_kses_allowed_html('post')); ?></span>
                </li>
              <?php endif; ?>
            </ul>
          </div>
          <div class="col-md-6">
            <ul>
              <?php if (!empty($address)): ?>
                <li class="address">
                  <strong class="key"><?php echo __('Address', 'inventor'); ?></strong>
                  <span class="value"><?php echo wp_kses(nl2br($address), wp_kses_allowed_html('post')); ?></span>
                </li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
<?php endif; ?>

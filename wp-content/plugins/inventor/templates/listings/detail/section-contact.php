<?php
  $if_allowed_contact = apply_filters('inventor_submission_listing_metabox_allowed', true, 'contact',
    get_the_author_meta('ID'));
  if ($if_allowed_contact) {
    $email   = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'email', true);
    $website = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'website', true);
    $phone   = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'phone', true);
    $address = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'address', true);
    ?>
    <div class="listing-detail-section" id="listing-detail-section-contact">
      <h2 class="page-header"><?= $section_title; ?></h2>
      <div class="listing-detail-contact">
        <div class="row">
          <div class="col-md-6">
            <ul>
              <?php if ($email !== null) { ?>
                <li class="email">
                  <strong class="key"><?= __('E-mail', 'inventor'); ?></strong>
                  <span class="value">
                    <a href="#"><?php echo antispambot(esc_attr($email)); ?></a>
                  </span>
                </li>
              <?php }
                if ($website !== null) { ?>
                  <li class="website">
                    <strong class="key"><?= __('Website', 'inventor'); ?></strong>
                  <span class="value">
                    <a href="<?php echo esc_attr($website); ?>"><?= esc_attr($website); ?></a>
                  </span>
                  </li>
                <?php }
                if ($phone !== null) { ?>
                  <li class="phone">
                    <strong class="key"><?= __('Phone', 'inventor'); ?></strong>
                    <span class="value"><?= wp_kses($phone, wp_kses_allowed_html('post')); ?></span>
                  </li>
                <?php } ?>
            </ul>
          </div>
          <div class="col-md-6">
            <ul>
              <?php if ($address !== null): ?>
                <li class="address">
                  <strong class="key"><?= __('Address', 'inventor'); ?></strong>
                  <span class="value"><?= wp_kses(nl2br($address), wp_kses_allowed_html('post')); ?></span>
                </li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <?php
  }

<?php $faqs = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'faq', true);
if (! empty($faqs) && is_array($faqs)) { ?>
    <div class="listing-detail-section" id="listing-detail-section-faq">
      <h2 class="page-header"><?= $section_title; ?></h2>
      <dl class="listing-detail-section-faq-list">
        <?php foreach ((array)$faqs as $faq) { ?>
          <dt><?= esc_attr($faq[INVENTOR_LISTING_PREFIX . 'question']); ?></dt>
          <dd><?= esc_attr($faq[INVENTOR_LISTING_PREFIX . 'answer']); ?></dd>
        <?php } ?>
      </dl>
    </div>
<?php }

<?php
  $food_menu_speciality_class = ! empty($meal[INVENTOR_LISTING_PREFIX . 'food_menu_speciality'])??'speciality';
  $food_menu_serving_class    = date('Ymd') === date('Ymd',
      $meal[INVENTOR_LISTING_PREFIX . 'food_menu_serving'])??'today';
?>
<div class="listing-detail-food <?= $food_menu_speciality_class ?>">
  <?php
    if ( ! empty($meal[INVENTOR_LISTING_PREFIX . 'food_menu_photo_id'])) {
      $image_url = wp_get_attachment_image_src($meal[INVENTOR_LISTING_PREFIX . 'food_menu_photo_id'], 'thumbnail');
      $image_url = $image_url[0];
    } else {
      $image_url = plugins_url('inventor') . '/assets/img/default-item.png';
    } ?>
  <div class="listing-detail-food-photo" style="background-image: url('<?= $image_url; ?>')"></div>
  <div class="listing-detail-food-content">
    <?php
      if ( ! empty($meal[INVENTOR_LISTING_PREFIX . 'food_menu_serving'])) { ?>
        <div class="listing-detail-food-serving <?= $food_menu_serving_class ?>">
          <?= date(get_option('date_format'), $meal[INVENTOR_LISTING_PREFIX . 'food_menu_serving']); ?>
        </div>
      <?php }
      if ( ! empty($meal[INVENTOR_LISTING_PREFIX . 'food_menu_title'])) { ?>
        <h4>
          <?= esc_attr($meal[INVENTOR_LISTING_PREFIX . 'food_menu_title']); ?>
        </h4>
      <?php }
      if ( ! empty($meal[INVENTOR_LISTING_PREFIX . 'food_menu_speciality'])) { ?>
        <div class="listing-detail-food-speciality">
          <?= esc_attr__('Speciality', 'inventor'); ?>
        </div>
      <?php }
      if ( ! empty($meal[INVENTOR_LISTING_PREFIX . 'food_menu_description'])) { ?>
        <div class="listing-detail-food-description">
          <p><?= esc_attr($meal[INVENTOR_LISTING_PREFIX . 'food_menu_description']) ?></p>
        </div>
      <?php } ?>
  </div>
  <?php if ( ! empty($meal[INVENTOR_LISTING_PREFIX . 'food_menu_price'])) { ?>
    <div class="listing-detail-food-price">
      <?= esc_attr(Inventor_Price::format_price($meal[INVENTOR_LISTING_PREFIX . 'food_menu_price'])); ?>
    </div>
  <?php } ?>
</div>

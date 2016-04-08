<div class="listing-detail-food <?php if (!empty($meal[INVENTOR_LISTING_PREFIX.'food_menu_speciality'])) : ?>speciality<?php endif; ?>">
  <?php if (!empty($meal[INVENTOR_LISTING_PREFIX.'food_menu_photo_id'])) : ?>
    <?php $image_url = wp_get_attachment_image_src($meal[INVENTOR_LISTING_PREFIX.'food_menu_photo_id'],
      'thumbnail'); ?>
    <?php $image_url = $image_url[0]; ?>
  <?php else : ?>
    <?php $image_url = plugins_url('inventor').'/assets/img/default-item.png'; ?>
  <?php endif; ?>
  <div class="listing-detail-food-photo" style="background-image: url('<?php echo $image_url; ?>')"></div>
  <div class="listing-detail-food-content">
    <?php if (!empty($meal[INVENTOR_LISTING_PREFIX.'food_menu_serving'])) : ?>
      <div class="listing-detail-food-serving <?php if (date('Ymd') == date('Ymd',
          $meal[INVENTOR_LISTING_PREFIX.'food_menu_serving'])
      ) : ?>today<?php endif; ?>">
        <?php echo date(get_option('date_format'), $meal[INVENTOR_LISTING_PREFIX.'food_menu_serving']); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($meal[INVENTOR_LISTING_PREFIX.'food_menu_title'])) : ?>
      <h4>
        <?php echo esc_attr($meal[INVENTOR_LISTING_PREFIX.'food_menu_title']); ?>
      </h4>
    <?php endif; ?>

    <?php if (!empty($meal[INVENTOR_LISTING_PREFIX.'food_menu_speciality'])) : ?>
      <div class="listing-detail-food-speciality">
        <?php echo esc_attr__('Speciality', 'inventor'); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($meal[INVENTOR_LISTING_PREFIX.'food_menu_description'])) : ?>
      <div class="listing-detail-food-description">
        <p><?php echo esc_attr($meal[INVENTOR_LISTING_PREFIX.'food_menu_description']) ?></p>
      </div>
    <?php endif; ?>
  </div>
  <?php if (!empty($meal[INVENTOR_LISTING_PREFIX.'food_menu_price'])) : ?>
    <div class="listing-detail-food-price">
      <?php echo esc_attr(Inventor_Price::format_price($meal[INVENTOR_LISTING_PREFIX.'food_menu_price'])); ?>
    </div>
  <?php endif; ?>
</div>

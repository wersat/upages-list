<?php $attributes   = Inventor_Post_Types::get_attributes();
  $attributes_count = count($attributes);
if ($attributes_count > 0 && is_array($attributes)) { ?>
    <div class="listing-detail-section" id="listing-detail-section-attributes">
      <h2 class="page-header"><?= $section_title; ?></h2>
      <div class="listing-detail-attributes">
        <ul>
            <?php foreach ($attributes as $key => $attribute) {
            ?>
            <li class="<?= esc_attr($key); ?>">
              <strong class="key">
                <?= wp_kses($attribute['name'], wp_kses_allowed_html('post')); ?>
              </strong>
            <span class="value">
                <?= wp_kses($attribute['value'], wp_kses_allowed_html('post')); ?>
            </span>
            </li>
            <?php
            } ?>
        </ul>
      </div>
    </div>
<?php }

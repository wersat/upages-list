<?php
  $meals                   = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'food_menu_group', true);
  $groups                  = Inventor_Post_Type_Food::get_menu_groups();
  $groups_daily_menu       = count($groups['menu']);
  $groups_daily_menu_count = count($groups['daily_menu']);
if (! empty($meals)) { ?>
    <div class="listing-detail-section" id="listing-detail-section-meals-and-drinks">
      <h2 class="page-header"><?= $section_title; ?></h2>
      <div class="listing-detail-food-wrapper">
        <?php
        if (is_array($groups['daily_menu']) && $groups_daily_menu_count > 0) { ?>
            <h3>
              <span><?= esc_attr__('Daily Menu', 'inventor'); ?></span>
            </h3>
            <div class="listing-detail-food-inner">
                <?php
                foreach ($groups['daily_menu'] as $meal) {
                    echo Inventor_Template_Loader::load(
                        'post-types/food/menu-item', [
                        'meal' => $meal
                        ]
                    );
                } ?>
            </div>
        <?php }
        if (is_array($groups['menu']) && $groups_daily_menu > 0) { ?>
            <h3>
              <span><?= esc_attr__('Menu', 'inventor'); ?></span>
            </h3>
            <div class="listing-detail-food-inner">
                <?php foreach ($groups['menu'] as $meal) {
                    echo Inventor_Template_Loader::load(
                        'post-types/food/menu-item', [
                        'meal' => $meal
                        ]
                    );
} ?>
            </div>
        <?php } ?>
      </div>
    </div>
<?php }

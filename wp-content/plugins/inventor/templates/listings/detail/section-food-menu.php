<?php $meals = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX.'food_menu_group', true); ?>
<?php if (!empty($meals)) : ?>
  <div class="listing-detail-section" id="listing-detail-section-meals-and-drinks">
    <h2 class="page-header"><?php echo $section_title; ?></h2>
    <div class="listing-detail-food-wrapper">
      <?php $groups = Inventor_Post_Type_Food::get_menu_groups(); ?>

      <?php if (is_array($groups['daily_menu']) && count($groups['daily_menu']) > 0) : ?>
        <h3>
          <span><?php echo esc_attr__('Daily Menu', 'inventor'); ?></span>
        </h3>
        <div class="listing-detail-food-inner">
          <?php foreach ($groups['daily_menu'] as $meal) : ?>
            <?php echo Inventor_Template_Loader::load('post-types/food/menu-item', [
              'meal' => $meal,
            ]); ?>
          <?php endforeach ?>
        </div>
      <?php endif; ?>

      <?php if (is_array($groups['menu']) && count($groups['menu']) > 0) : ?>
        <h3>
          <span><?php echo esc_attr__('Menu', 'inventor'); ?></span>
        </h3>
        <div class="listing-detail-food-inner">
          <?php foreach ($groups['menu'] as $meal) : ?>
            <?php echo Inventor_Template_Loader::load('post-types/food/menu-item', [
              'meal' => $meal,
            ]); ?>
          <?php endforeach ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>

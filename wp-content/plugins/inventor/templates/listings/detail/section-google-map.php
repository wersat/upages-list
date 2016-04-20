<?php
  $if_allowed_location = apply_filters('inventor_submission_listing_metabox_allowed', true, 'location',
    get_the_author_meta('ID'));
  if ($if_allowed_location) {
    $map_latitude  = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_latitude', true);
    $map_longitude = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_longitude', true);
    $map_polygon   = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_polygon', true);
    $map           = $map_latitude !== null || $map_longitude !== null;
    $street_view   = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'street_view', true);
    $inside_view   = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view', true);
    if (class_exists('Inventor_Google_Map')) {
      if ($map !== null || $street_view !== null) { ?>
        <div class="listing-detail-section" id="listing-detail-section-location">
          <h2 class="page-header"><?= $section_title; ?></h2>
          <div class="listing-detail-location-wrapper">
            <ul id="listing-detail-location" class="nav nav-tabs" role="tablist">
              <li role="presentation" class="nav-item active">
                <a href="#simple-map-panel" aria-controls="simple-map-panel" role="tab" data-toggle="tab" class="nav-link">
                  <i class="fa fa-map"></i><?= __('Map', 'inventor'); ?>
                </a>
              </li>
              <li role="presentation" class="nav-item <?= $map !== null ? '' : 'active'; ?>">
                <a href="#street-view-panel" aria-controls="street-view-panel" role="tab" data-toggle="tab" class="nav-link">
                  <i class="fa fa-street-view"></i><?= __('Street View', 'inventor'); ?>
                </a>
              </li>
              <?php
                if ($inside_view !== null) : ?>
                  <li role="presentation" class="nav-item <?= ($map === null && $street_view === null) ? 'active'
                    : ''; ?>">
                    <a href="#inside-view-panel" aria-controls="inside-view-panel" role="tab" data-toggle="tab" class="nav-link">
                      <i class="fa fa-home"></i><?= __('See Inside', 'inventor'); ?>
                    </a>
                  </li>
                <?php endif; ?>
              <li class="nav-item directions">
                <a href="https://maps.google.com?daddr=<?= esc_attr($map_latitude); ?>,<?= esc_attr($map_longitude); ?>" class="nav-link">
                  <i class="fa fa-level-down"></i><?= __('Directions', 'inventor') ?>
                </a>
              </li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade in active" id="simple-map-panel">
                <div class="detail-map">
                  <div class="map-position">
                    <div id="listing-detail-map"
                         data-transparent-marker-image="<?= get_template_directory_uri(); ?>/assets/img/transparent-marker-image.png"
                         data-latitude="<?= esc_attr($map_latitude); ?>"
                         data-longitude="<?= esc_attr($map_longitude); ?>"
                         data-polygon-path="<?= esc_attr($map_polygon); ?>"
                         data-marker-style="simple">
                    </div>
                  </div>
                </div>
              </div>
              <?php
                $street_view_latitude  = get_post_meta(get_the_ID(),
                  INVENTOR_LISTING_PREFIX . 'street_view_location_latitude', true);
                $street_view_longitude = get_post_meta(get_the_ID(),
                  INVENTOR_LISTING_PREFIX . 'street_view_location_longitude', true);
                $street_view_heading   = get_post_meta(get_the_ID(),
                  INVENTOR_LISTING_PREFIX . 'street_view_location_heading', true);
                $street_view_pitch     = get_post_meta(get_the_ID(),
                  INVENTOR_LISTING_PREFIX . 'street_view_location_pitch', true);
                $street_view_zoom      = get_post_meta(get_the_ID(),
                  INVENTOR_LISTING_PREFIX . 'street_view_location_zoom', true);
              ?>
              <div role="tabpanel"
                   class="tab-pane fade <?= $map === null ? 'in active' : ''; ?>"
                   id="street-view-panel">
                <div id="listing-detail-street-view"
                     data-latitude="<?= esc_attr($street_view_latitude); ?>"
                     data-longitude="<?= esc_attr($street_view_longitude); ?>"
                     data-heading="<?= esc_attr($street_view_heading); ?>"
                     data-pitch="<?= esc_attr($street_view_pitch); ?>"
                     data-zoom="<?= esc_attr($street_view_zoom); ?>">
                </div>
              </div>
              <?php
                if ($inside_view !== null) :
                  $inside_view_latitude = get_post_meta(get_the_ID(),
                    INVENTOR_LISTING_PREFIX . 'inside_view_location_latitude', true);
                  $inside_view_longitude = get_post_meta(get_the_ID(),
                    INVENTOR_LISTING_PREFIX . 'inside_view_location_longitude', true);
                  $inside_view_heading = get_post_meta(get_the_ID(),
                    INVENTOR_LISTING_PREFIX . 'inside_view_location_heading', true);
                  $inside_view_pitch = get_post_meta(get_the_ID(),
                    INVENTOR_LISTING_PREFIX . 'inside_view_location_pitch', true);
                  $inside_view_zoom = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_zoom',
                    true); ?>
                  <div role="tabpanel"
                       class="tab-pane fade <?= $map === null && $street_view === null ? 'in active' : ''; ?>"
                       id="inside-view-panel">
                    <div id="listing-detail-inside-view"
                         data-latitude="<?= esc_attr($inside_view_latitude); ?>"
                         data-longitude="<?= esc_attr($inside_view_longitude); ?>"
                         data-heading="<?= esc_attr($inside_view_heading); ?>"
                         data-pitch="<?= esc_attr($inside_view_pitch); ?>"
                         data-zoom="<?= esc_attr($inside_view_zoom); ?>">
                    </div>
                  </div>
                <?php endif; ?>
            </div>
          </div>
        </div>
      <?php }
    }
  }

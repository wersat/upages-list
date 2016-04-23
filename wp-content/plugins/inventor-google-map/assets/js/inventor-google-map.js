jQuery(document).ready(function($) {
  'use strict';

  /**
   * Switch
   */
  $('.map-switch').on('click', function() {
    $(this).closest('.map-wrapper').find('.map-inner').toggleClass('closed');
    var id = $(this).closest('.widget').attr('id');

    if ($(this).closest('.map-wrapper').find('.map-inner').hasClass('closed')) {
      Cookies.set('map-toggle-' + id, 'closed', {expires: 7});
    } else {
      Cookies.set('map-toggle-' + id, 'open', {expires: 7});
    }
  });

  /**
   * Google Map
   */
  var map = $('#map');

  if (map.length) {
    var styles = map.data('styles');
    var markerStyle = map.data('marker-style');

    var marker = {
      height: 38,
      width: 24
    };

    if (markerStyle == 'inventor-poi') {
      marker = {
        height: 40,
        width: 40
      }
    }

    var data = {
      'action': 'inventor_filter_listings',
      'orderby': map.data('orderby'),
      'max-pins': map.data('max-pins'),
      'marker-style': map.data('marker-style')
    };

    var post_type = map.data('post-type');
    if (post_type) {
      data['post-type'] = post_type;
    }

    var post_id = map.data('post-id');
    if (post_id) {
      data['post-id'] = post_id;
    }

    var term = map.data('term');
    var term_taxonomy = map.data('term-taxonomy');
    if (term && term_taxonomy) {
      data['term'] = term;
      data['term-taxonomy'] = term_taxonomy;
    }

    var filter_query = map.data('filter-query');
    if (filter_query) {
      data = $.param(data) + '&' + filter_query;
    }

    var show_all_markers = map.data('show-all-markers') == 'on';

    $.ajax({
      url: map.data('ajax-action'),
      data: data,
      success: function(data) {
        map.google_map({
          fitBounds: show_all_markers,
          geolocation: map.data('geolocation'),
          infowindow: {
            borderBottomSpacing: 0,
            height: 260,
            width: 200,
            offsetX: -131,
            offsetY: -265
          },
          center: {
            latitude: map.data('latitude'),
            longitude: map.data('longitude')
          },
          zoom: map.data('zoom'),
          marker: {
            height: marker.height,
            width: marker.width
          },
          cluster: {
            height: 40,
            width: 40,
            gridSize: map.data('grid-size')
          },
          styles: styles,
          markers: data,
          transparentMarkerImage: map.data('transparent-marker-image'),
          transparentClusterImage: map.data('transparent-marker-image')
        });
      }
    });

    $('form.auto-submit-filter :input', '.map-wrapper').on('change', function(e) {
      if (!$(this).parent().hasClass('form-group-geolocation')) {
        reloadData(map, e);
      }
    });

    $('form.live', '.map-wrapper').submit(function(e) {
      e.preventDefault();
      reloadData(map, e)
    });
  }

  function reloadData(map, e) {
    var data = {
      'action': 'inventor_filter_listings',
      'orderby': map.data('orderby'),
      'max-pins': map.data('max-pins'),
      'marker-style': map.data('marker-style')
    };
    var fields = $('.map-wrapper form').serialize();

    $.ajax({
      url: map.data('ajax-action'),
      data: $.param(data) + '&' + fields,
      success: function(data) {
        map.google_map('removeMarkers');
        map.google_map('addMarkers', {
          markers: data
        });
      }
    });
  }

  /**
   * Listing Detail Location
   */

  mapInit('listing-detail-map');
  streetViewInit('listing-detail-street-view');
  streetViewInit('listing-detail-inside-view');

  /**
   * Listing Detail Location Tabs
   */
  $('#listing-detail-location a').on('shown.bs.tab', function() {
    var target = $(this).attr('href');

    if (target == '#street-view-panel' || target == '#inside-view-panel') {
      streetViewInit($(target).children().attr('id'));
    } else if (target == '#simple-map-panel') {
      mapInit('listing-detail-map');
    }
  });

  /**
   * Listing Detail Map
   */
  function mapInit(mapId) {
    var mapDetail = $('#' + mapId);

    if (mapDetail.attr('initialized')) return;
    mapDetail.attr('initialized', true);

    if (mapDetail.length) {
      var fitBounds = false;
      var polygon = null;
      var polygon_path = mapDetail.data('polygon-path');

      if (polygon_path) {
        fitBounds = true;
        var decodedPath = google.maps.geometry.encoding.decodePath(polygon_path);

        polygon = new google.maps.Polygon({
          paths: decodedPath,
          strokeColor: '#fff',
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: '#fff',
          fillOpacity: 0.35
        });
      }

      var mapDetail_obj = mapDetail.google_map({
        center: {
          latitude: mapDetail.data('latitude'),
          longitude: mapDetail.data('longitude')
        },
        zoom: mapDetail.data('zoom'),
        marker: {
          height: 38,
          width: 24
        },
        polygon: polygon,
        fitBounds: fitBounds,
        transparentMarkerImage: mapDetail.data('transparent-marker-image'),
        zoomControl: true
      });

      mapDetail_obj.google_map('removeMarkers');
      mapDetail_obj.google_map('addMarkers', {
        markers: [{
          latitude: mapDetail.data('latitude'),
          longitude: mapDetail.data('longitude'),
          marker_content: '<div class="simple-marker"></div>'
        }]
      });
    }
  }

  /**
   * Listing Detail Street and Inside View
   */
  function streetViewInit(streetViewId) {
    var streetViewElement = $('#' + streetViewId);

    if (streetViewElement.length) {
      new google.maps.StreetViewPanorama(document.getElementById(streetViewId), {
        position: {
          lat: streetViewElement.data('latitude'),
          lng: streetViewElement.data('longitude')
        },
        pov: {
          heading: streetViewElement.data('heading'),
          pitch: streetViewElement.data('pitch')
        },
        zoom: streetViewElement.data('zoom'),
        linksControl: true,
        panControl: false,
        addressControl: false,
        visible: true
      }
  );
    }
  }
});

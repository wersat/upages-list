jQuery(document).ready(function($) {
    'use strict';

    /**
     * Filter sorting options
     */
    $('.filter-sorting-inner a').on('click', function(e) {
        e.preventDefault();

        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('input', this).attr('disabled', 'disabled');
        } else {
            $(this).closest('ul').find('input').attr('disabled', 'disabled');
            $(this).closest('ul').find('a').removeClass('active');
            $(this).find('input').removeAttr('disabled');
            $(this).addClass('active');
        }

        $(this).closest('form').submit();
    });

    /**
     * Background image
     */
    $('*[data-background-image]').each(function() {
        $(this).css({
            'background-image': 'url(' + $(this).data('background-image') + ')'
        });
    });

    /**
     * Ratings
     */
    var fontawesome = {
        starType: 'i',
        starOn: 'fa fa-star',
        starHalf: 'fa fa-star-half-o',
        starOff: 'fa fa-star-o'
    };

    if ($('.review-rating-total').length !== 0) {
        $('.review-rating-total').each(function () {
            var rating = $(this);
            var opts = {
                path: rating.data('path'),
                score: rating.data('score'),
                readOnly: true
            };

            if ($(this).data('fontawesome') !== undefined) {
                $.extend(opts, fontawesome);
            }

            rating.raty(opts);
        });
    }

    if ($('.review-rating').length !== 0) {
        $('.review-rating').each(function () {
            var rating = $(this);
            var opts = {
                path: rating.data('path'),
                score: rating.data('score'),
                readOnly: true
            };

            if ($(this).data('fontawesome') !== undefined) {
                $.extend(opts, fontawesome);
            }

            rating.raty(opts);
        });
    }

    if ($('.review-form-rating').length !== 0) {
        var opts = {
            path: $('.review-form-rating').data('path'),
            targetScore: '#rating'
        };

        if ($('.review-form-rating').data('fontawesome') !== undefined) {
            $.extend(opts, fontawesome);
        }

        $('.review-form-rating').raty(opts);
    }

    /**
     * Payment form gateway proceed button toggler
     */
    $(".payment-form input[id^='gateway-']").change(function() {
        var gateway_contents = $('.gateway-content');
        var proceed = $(this).data('proceed');
        var submit_title = $(this).data('submit-title');
        var form = $(this).parents('form:first');
        var submit = form.find('[name="process-payment"]');
        var gateway_header = $(this).closest('.gateway-header');
        var terms = form.find("input[name=agree_terms]");
        var terms_agreed = terms.length == 0 || terms.is(':checked');

        if ($(this).is( ':checked' )) {
            gateway_contents.hide();
            var gateway_content = gateway_header.next('.gateway-content');
            gateway_content.show();

            if (proceed && terms_agreed) {
                submit.removeClass( 'hidden' );
            } else {
                submit.addClass( 'hidden' );
            }

            if (submit_title) {
                submit.html( submit_title );
            }
        }
    }).change();

    $(".payment-form input[name=agree_terms]").change(function() {
        var form = $(this).parents('form:first');
        var active_gateway = form.find("input[id^='gateway-']:checked");
        var submit = form.find('button[type=submit]');
        var stripe_submit = form.find('.stripe-button-el');

        if ($(this).is( ':checked' )) {
            if (active_gateway.attr('id') == 'gateway-stripe-checkout') {
                stripe_submit.removeClass('hidden');
            } else {
                submit.removeClass( 'hidden' );
            }
        } else {
            submit.addClass( 'hidden' );
        }
    }).change();

    /**
     * Payment
     */
    $('.payment-process').on('click', function(e) {
        e.preventDefault();
        $('.payment-form').submit();
    });

    /**
     * Masonry
     */
    var layoutPattern = [[2,1],[1,2],[1,1],[1,1],[1,2],[2,1],[1,1],[1,1]];

    $( window ).load(function() {
        masonryInit('.widget_listings .type-masonry .listings-row', '.listing-masonry-container', 3, 767);
    });
    $( window ).resize(function() {
        masonryInit('.widget_listings .type-masonry .listings-row', '.listing-masonry-container', 3, 767);
    });

    function masonryInit( wrapper, item, columns, oneColumnResolution) {
        var itemHeight = 300;
        columns = columns || 2;
        oneColumnResolution = oneColumnResolution || 991;

        if ( $( window ).width() <= oneColumnResolution ) {
            columns = 1;
        }

        var containerWidth = $(wrapper).width();
        var itemWidth = ( containerWidth ) / columns;

        if (itemWidth != 0) {
            itemWidth = (Math.round(itemWidth * 10) - 2) / 10;
        }

        if ( $( window ).width() > oneColumnResolution ) {
            var marginBottom = parseInt($('.listing-masonry-container').css('margin-bottom'));

            var index = 0;
            $(item).each(function(){
                $(this).css('width', itemWidth * layoutPattern[index][0]);
                $(this).css('height', itemHeight * layoutPattern[index][1] + marginBottom * layoutPattern[index][1] - marginBottom);

                if (layoutPattern.length == ++index) {
                    index = 0;
                }
            });
        } else {
            $(item).each(function(){
                $(this).css('width', '100%');
                $(this).css('height', itemHeight);
            });
        }

        $(wrapper).masonry({
            itemSelector: item,
            columnWidth: itemWidth,
            gutter: 0
        });
    }

    /**
     * Street View init
     */
    $('.cmb-type-street-view').each(function(){
        $(this).streetView();
    });

    /**
     * Submission form banner
     */
    var banner_input = $('.cmb2-id-listing-banner .cmb2-list input');

    banner_input.each(function(){
        if($(this).attr("checked") == "checked") {
            banner_extra_field($(this));
        }
    });

    banner_input.on('click', function(){
        banner_extra_field($(this));
    });

    function banner_extra_field(inputElement) {
        $('.banner-image, .banner-video, .banner-map, .banner-street-view, .banner-inside-view').addClass('inactive');

        // custom image
        if(inputElement.attr('value') == 'banner_image') {
            $('.banner-image').removeClass('inactive');
        }
        // video
        else if(inputElement.attr('value') == 'banner_video') {
            $('.banner-video').removeClass('inactive');
        }
        // google map
        else if(inputElement.attr('value') == 'banner_map') {
            $('.banner-map').removeClass('inactive');
        }
        // street view
        else if(inputElement.attr('value') == 'banner_street_view') {
            $('.banner-street-view').removeClass('inactive');
        }
        // inside view
        else if(inputElement.attr('value') == 'banner_inside_view') {
            $('.banner-inside-view').removeClass('inactive');
        }
    }

    /**
     * Submission - Enable Street View
     */
    street_view_enable('.cmb2-id-listing-street-view input', '.cmb2-id-listing-street-view-location');
    street_view_enable('.cmb2-id-listing-inside-view input', '.cmb2-id-listing-inside-view-location');

    function street_view_enable(checkbox, elemToDisable) {

        if ($(checkbox).attr("checked") != "checked") {
            $(elemToDisable).addClass('inactive');
        }
        $(checkbox).on('click', function(){
            $(elemToDisable).toggleClass('inactive');
        });
    }

});
jQuery(document).ready(
    function($) {
        'use strict';

        /**
     * Street View init
     */
        $('.cmb-type-street-view').each(
            function(){
                $(this).streetView();
            }
        );

        /**
     * Verify purchase code
     */
        $('.inventor-update-plugin-message-submit').on(
            'click', function(e) {
                e.preventDefault();

                var button = $(this);
                var action = $(this).data('action');
                var purchase_code = $(this).parent().find('input').val();
                var preloader = $(this).data('preloader');

                button.text('Verifying ...');
                button.prepend('<img src="' + preloader + '" alt="">');
                $.ajax(
                    {
                        type: 'GET',
                        url: action,
                        data: {
                            action: 'inventor_verify_purchase_code',
                            'purchase-code': purchase_code
                        },
                        success: function(data) {
                            if (data.error === true) {
                                $('img', button).remove();
                                button.text('Error occured. Try again later.');
                            } else {
                                if (data.valid === false) {
                                    $('img', button).remove();
                                    button.text('Code invalid. Retry.')
                                } else if (data.valid === true) {
                                    location.reload();
                                    button.text('Code valid. Redirecting.')
                                }
                            }
                        }
                    }
                )
            }
        );

        /**
     * Submission form banner
     */
        var banner_input = $('.cmb2-id-listing-banner .cmb2-list input');

        banner_input.each(
            function(){
                if($(this).attr("checked") == "checked") {
                    banner_extra_field($(this));
                }
            }
        );

        banner_input.on(
            'click', function(){
                banner_extra_field($(this));
            }
        );

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
     * Enable Street View
     */
        street_view_enable('.cmb2-id-listing-street-view input', '.cmb2-id-listing-street-view-location');
        street_view_enable('.cmb2-id-listing-inside-view input', '.cmb2-id-listing-inside-view-location');

        function street_view_enable(checkbox, elemToDisable) {
            if ($(checkbox).attr("checked") != "checked") {
                $(elemToDisable).addClass('inactive');
            }

            $(checkbox).on(
                'click', function(){
                    $(elemToDisable).toggleClass('inactive');
                }
            );
        }
    }
);

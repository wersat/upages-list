jQuery(document).ready(function($) {
    'use strict';

    $('input[type="checkbox"]#user_package_infinite').on('change', function() {
        var infinite = $(this).is(":checked");
        var validity = $('.cmb2-id-user-package-valid');

        if ( infinite ) {
            validity.hide();
        } else {
            validity.show();
        }
    }).change();
});
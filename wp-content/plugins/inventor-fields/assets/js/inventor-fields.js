jQuery(document).ready(function($) {
  'use strict';

  $('#field_settings #field_type').on('change', function() {
    var type = $(this).val();

    var field_options = $('#field_settings .cmb2-id-field-options');
    var choices_types = ['multicheck', 'multicheck_inline', 'radio', 'radio_inline', 'select'];
    if (choices_types.indexOf(type) == -1) {
      field_options.hide();
    } else {
      field_options.show();
    }

    var value_type = $('#field_settings .cmb2-id-field-value-type');
    var text_types = ['text', 'text_small', 'text_medium'];
    if (text_types.indexOf(type) == -1) {
      value_type.hide();
    } else {
      value_type.show();
    }
  }).change();
});

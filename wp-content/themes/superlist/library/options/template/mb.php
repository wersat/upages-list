<?php
    return [
        [
            'type'        => 'date',
            'name'        => 'dt_3',
            'label'       => __('Use Filtering', 'vp_textdomain'),
            'description' => __('The range can be exact date or formatted string to define the offset from today, for example "+1D" will be parsed as tommorow date, or "+1D +1W", please refer to [jQueryUI Datepicker Docs](http://jqueryui.com/datepicker/#min-max)', 'vp_textdomain'),
            'min_date' => '1-1-2000',
            'max_date' => 'today',
            'format' => 'yy-mm-dd',
            'default' => '-1W',
        ],
    ];

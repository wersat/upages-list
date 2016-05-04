<?php
    return [
        ////////////////////////////////////////
        // Localized JS Message Configuration //
        ////////////////////////////////////////
        /*
         * Validation Messages
         */
        'validation' => [
            'alphabet' => __('Value needs to be Alphabet', 'upages'),
            'alphanumeric' => __('Value needs to be Alphanumeric', 'upages'),
            'numeric' => __('Value needs to be Numeric', 'upages'),
            'email' => __('Value needs to be Valid Email', 'upages'),
            'url' => __('Value needs to be Valid URL', 'upages'),
            'maxlength' => __('Length needs to be less than {0} characters', 'upages'),
            'minlength' => __('Length needs to be more than {0} characters', 'upages'),
            'maxselected' => __('Select no more than {0} items', 'upages'),
            'minselected' => __('Select at least {0} items', 'upages'),
            'required' => __('This is required', 'upages'),
        ],
        /*
         * Import / Export Messages
         */
        'util' => [
            'import_success' => __('Import succeed, option page will be refreshed..', 'upages'),
            'import_failed' => __('Import failed', 'upages'),
            'export_success' => __('Export succeed, copy the JSON formatted options', 'upages'),
            'export_failed' => __('Export failed', 'upages'),
            'restore_success' => __('Restoration succeed, option page will be refreshed..', 'upages'),
            'restore_nochanges' => __('Options identical to default', 'upages'),
            'restore_failed' => __('Restoration failed', 'upages'),
        ],
        /*
         * Control Fields String
         */
        'control' => [
            // select2 select box
            'select2_placeholder' => __('Select option(s)', 'upages'),
            // fontawesome chooser
            'fac_placeholder' => __('Select an Icon', 'upages'),
        ],
    ];

    /*
     * EOF
     */

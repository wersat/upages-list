<?php
    function my_init_metaboxes()
    {
        $mb = new VP_Metabox([
            'id'          => 'my_mb',
            'types'       => ['post'],
            'title'       => __('VP Metabox', 'vp_textdomain'),
            'priority'    => 'high',
            'is_dev_mode' => true,
            'template'    => OPTION_DIR . '/template/mb.php'
        ]);
    }

    add_action('after_setup_theme', 'my_init_metaboxes');

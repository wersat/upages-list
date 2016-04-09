<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Inventor_Packages_Post_Types.
 *
 * @class Inventor_Packages_Post_Types
 *
 * @author Pragmatic Mates
 */
class Inventor_Packages_Post_Types
{
    /**
     * Initialize post types.
     */
    public static function init()
    {
        self::includes();
    }

    /**
     * Loads post types.
     */
    public static function includes()
    {
        require_once INVENTOR_PACKAGES_DIR.'includes/post-types/class-inventor-packages-post-type-package.php';
    }
}

Inventor_Packages_Post_Types::init();

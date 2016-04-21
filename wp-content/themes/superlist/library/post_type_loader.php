<?php
    use Upages_Post_Type\Claim_Post_Type;
    use Upages_Post_Type\Faq_Post_Type;

    spl_autoload_register(function ($widgets) {
        $widgets = ltrim($widgets, '\\');
        if (0 !== stripos($widgets, 'Upages_Post_Type\\')) {
            return;
        }
        $parts_class = explode('\\', $widgets);
        array_shift($parts_class);
        $last_class    = array_pop($parts_class);
        $last_class    = 'class-' . $last_class . '.php';
        $parts_class[] = $last_class;
        $class         = POST_TYPE_DIR . '/' . str_replace('_', '-', strtolower(implode($parts_class, '/')));
        if (file_exists($class)) {
            require_once $class;
        }
    });
    new Claim_Post_Type();
    new Faq_Post_Type();

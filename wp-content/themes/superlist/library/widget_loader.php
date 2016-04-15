<?php
    use Upages_Widgets\Widgets_Boxes;

    spl_autoload_register(function ($widgets) {
        $widgets = ltrim($widgets, '\\');
        if (0 !== stripos($widgets, 'Upages_Widgets\\')) {
            return;
        }
        $parts_class = explode('\\', $widgets);
        array_shift($parts_class);
        $last_class    = array_pop($parts_class);
        $last_class    = 'class-' . $last_class . '.php';
        $parts_class[] = $last_class;
        $class         = WIDGETS_DIR . '/' . str_replace('_', '-', strtolower(implode($parts_class, '/')));
        if (file_exists($class)) {
            require_once $class;
        }
    });
    new Widgets_Boxes();

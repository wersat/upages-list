<?php
    use Upages_Widgets\Widget_Boxes;
    use Upages_Widgets\Widget_Call_To_Action;
    use Upages_Widgets\Widget_Last_News;
    use Upages_Widgets\Widget_Simple_Map;
    use Upages_Widgets\Widget_Video_Home_Cover;

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
    new Widget_Boxes();
    new Widget_Call_To_Action();
    new Widget_Simple_Map();
    new Widget_Video_Home_Cover();
    new Widget_Last_News();

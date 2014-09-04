<?php

class Autoloader
{

    private static $classes = [];


    public static function add_class($class, $path)
    {
        //todo Ведь мы же договаривались, что функции через_нижние_подчеркивания?
        static::$classes[$class] = $path;
    }

    /**
     * @param array $array ['SimpleClass' => 'path/to/SimpleClass.php']
     */
    public static function add_classes($array)
    {
        foreach ($array as $class => $path) {
            static::$classes[$class] = $path;
        }
    }

    public static function register()
    {
        spl_autoload_register('Autoloader::load', true, true);
    }

    public static function load($class)
    {
        if (!isset(static::$classes[$class])) {
            return false;
        }

        require static::$classes[$class];

        return true;
    }

} 
<?php

/**
 * Class Autoloader
 */
class Autoloader
{

    /**
     * @var array
     */
    private static $classes = [];

    /**
     * @param string $class
     * @param string $path
     */
    public static function addClass($class, $path)
    {
        static::$classes[$class] = $path;
    }

    /**
     * @param array $array ['SimpleClass' => 'path/to/SimpleClass.php']
     */
    public static function addClasses($array)
    {
        foreach ($array as $class => $path) {
            static::$classes[$class] = $path;
        }
    }

    public static function register()
    {
        spl_autoload_register('Autoloader::load', true, true);
    }

    /**
     * @param string $class
     * @return bool
     */
    public static function load($class)
    {
        if (!isset(static::$classes[$class])) {
            return false;
        }

        require static::$classes[$class];

        return true;
    }

} 
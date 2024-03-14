<?php

namespace Core;
class Autoloader
{
    public static function registrate(string $dir): void
    {

        $autoloader = function (string $className) use ($dir) {
            $path = str_replace('\\', DIRECTORY_SEPARATOR, $className);

            $path = $dir . '/' . $path . '.php';

            if (file_exists($path)) {

                require_once $path;
                return true;

            }

            return false;
        };

        spl_autoload_register($autoloader);
    }
}
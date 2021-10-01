<?php
namespace Kernel;

class Autoloader
{
    static public function register()
    {
        spl_autoload_register(function ($name) {
            $name = str_replace('\\', DS, $name);
            $file = ROOT . $name . '.php';

            if (file_exists($file))
            {
                require $file;
            };
        });
    }
}

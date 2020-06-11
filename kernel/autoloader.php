<?php
namespace Kernel;

class Autoloader
{
    static public function register()
    {
        spl_autoload_register(function ($name) {
            $file = ROOT . $name . '.php';

            //var_dump($file);

            if (file_exists($file))
            {
                require $file;
            };
        });
    }
}

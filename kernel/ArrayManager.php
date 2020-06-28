<?php


namespace Kernel;


trait ArrayManager
{
    static public function recursiveInarray($needle, $haystack)
    {
        if (!is_array($haystack))
            return false;

        foreach ($haystack as $key => $value)
        {
            if (!in_array($needle, $value))
                return false;

            self::recursiveInarray($needle, $value);
        }
    }
}
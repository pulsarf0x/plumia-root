<?php
function dump($var)
{
    $debug = debug_backtrace();
    echo '<pre style="padding: 20px; color: #00cbff; background-color: #001d34; border-radius: 5px">';
    echo '<b>' . $debug['0']['file'] . ':<span style="color: #00ffff">' . $debug['0']['line'] . '</span>' . PHP_EOL . PHP_EOL . '</b>';

    $args = func_get_args();

    foreach ($args as $arg)
    {
        echo '(' . gettype($arg) . ') ';
        print_r($arg);
        echo PHP_EOL . PHP_EOL;
    }

    echo '</pre>';
}
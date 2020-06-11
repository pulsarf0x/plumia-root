<?php
namespace Kernel;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);

require_once 'kernel/autoloader.php';
Autoloader::register();

$app = new App();
$app->welcome();
$test = $app->getDb()->query('SELECT * FROM test');
var_dump($test);
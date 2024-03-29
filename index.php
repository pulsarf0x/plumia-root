<?php
namespace Kernel;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);
define('CONTROLLERS_DIR', ROOT . 'app' . DS . 'Controllers' . DS);
define('VIEWS_DIR', ROOT . 'app' . DS . 'views' . DS);
define('DEBUG', true);

require_once('kernel/helpers.php');
require_once('kernel/Autoloader.php');

Autoloader::register();

$app = new App();
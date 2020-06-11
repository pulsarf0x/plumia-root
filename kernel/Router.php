<?php


namespace Kernel;


class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = include 'config/routes.php';
    }

    public function match($route)
    {
        $path = ROOT . DS. 'app' . DS . 'Controllers' . DS;

        if (!array_key_exists($route, $this->routes))
            return false;

        $destination = $this->routes[$route];

        $explode = explode('.', $destination);
        $controller = $explode[0];
        $method = $explode[1];

        if (!file_exists($path . $controller . '.php'))
            return false;

        include $path . $controller . '.php';

        $object = new $controller();

        if (!method_exists($controller, $method))
            return false;

        return $object->$method();
    }

    public function redirect($url)
    {
        header('Location:' . $url);
    }
}
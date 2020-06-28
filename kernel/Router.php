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

        $destination = $this->browse($route);

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

    public function browse($route)
    {
        $explode = explode('/', $route);

        $routes = $this->routes;

        for ($i = 0 ; $i <= sizeof($explode) ; $i++)
        {
            $path = $explode[$i];

            if (!is_array($routes[$path]))
                return $routes[$path];

            echo '<hr>';

            if (!array_key_exists($path, $routes))
                return false;

            $routes = $routes[$path];

        }

        return false;
    }

    public function redirect($url)
    {
        header('Location:' . $url);
    }
}
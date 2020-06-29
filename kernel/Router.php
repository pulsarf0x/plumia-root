<?php


namespace Kernel;

class Router
{
    private $routes;
    private $debug;

    public function __construct($debug = false)
    {
        $this->routes = include('config/routes.php');
        $this->debug = $debug;
    }

    public function match($route)
    {
        $destination = $this->browse($route);

        if ($this->debug)
            dump($destination);

        $explode = explode('.', $destination);
        $controller = $explode[0];
        $method = $explode[1];

        if ($this->debug)
            dump($controller, $method);

        return ['controller' => $controller, 'method' => $method];
    }

    public function parse($url)
    {
        $params = explode('/', $url);

    }

    public function browse($url)
    {
        $explode = explode('/', $url);

        var_dump($explode);
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
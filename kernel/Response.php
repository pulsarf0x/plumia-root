<?php

namespace Kernel;

class Response
{
    private $view;
    private $params;
    private $layout;

    public function __construct()
    {
        //$this->view = file_get_contents(VIEWS_DIR . $view . '.html');
        //$this->params = $params;
        $this->layout = 'default';
    }

    public function render($view, $params = false)
    {
        echo file_get_contents(VIEWS_DIR . $view . '.html');
    }

    public function redirect($url)
    {
        header('Location: ' . $url);
    }

    public function json($array)
    {
        header('Content-Type: application/json');;
        return json_encode($array);
    }

    public function error404()
    {
        header("HTTP/1.0 404 Not Found");
        return $this->render('errors/404');
    }

    public function error500()
    {
        header("HTTP/1.0 500 Internal Server Error");
        return $this->render('errors/500');
    }
}
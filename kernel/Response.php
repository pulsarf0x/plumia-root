<?php

namespace Kernel;

class Response
{
    private $layout;
    private $view;
    private $params;

    public function __construct()
    {
        //$this->view = file_get_contents(VIEWS_DIR . $view . '.html');
        //$this->params = $params;
        $this->layout = 'default';
    }

    public function render()
    {
        $layout = file_get_contents(VIEWS_DIR . DS . 'layouts' . DS . $this->layout . '.html');
        $content = file_get_contents(VIEWS_DIR . $this->view . '.html');

        echo str_replace('@content', $content, $layout);
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

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     * @return Response
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param mixed $view
     * @return Response
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     * @return Response
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }
}
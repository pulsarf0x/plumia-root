<?php
namespace Kernel;

abstract class Controller
{
    public function render($view, array $params = null)
    {
        echo file_get_contents(ROOT . 'app' . DS . 'views' . DS . $view . '.html');
    }

    public function json()
    {

    }
}
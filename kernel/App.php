<?php
namespace Kernel;

class App
{
    private $db;
    private $request;
    private $router;
    private $response;
    private $session;
    private $repository;

    public function __construct()
    {
        $this->db = new Database();
        $this->request = new Request();
        $this->router = new Router();
        $this->response = new Response();
        $this->session = new Session();

        $this->init();
    }

    public function init()
    {
        $action = $this->router->match("index");
        //$action = $this->router->match($this->request->getUrl());

        $controller = $this->loadController($action['controller']);

        dump($action['method']);

        $object = $controller->{$action['method']}();
    }

    public function loadController($controller)
    {
        $controllerFile = CONTROLLERS_DIR . $controller . '.php';

        if (!file_exists($controllerFile))
            return false;

        require_once($controllerFile);

        return new $controller($this);
    }

    public function render($view)
    {
        return $this->response->render($view);
    }

    public function welcome()
    {
        echo 'Hello world.';
    }

    // Getters & Setters

    /**
     * @return Database
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param Database $db
     * @return App
     */
    public function setDb($db)
    {
        $this->db = $db;
        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     * @return App
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param Router $router
     */
    public function setRouter($router)
    {
        $this->router = $router;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Response $response
     * @return App
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param Session $session
     * @return App
     */
    public function setSession($session)
    {
        $this->session = $session;
        return $this;
    }
}
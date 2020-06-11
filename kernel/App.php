<?php
namespace Kernel;

class App
{
    private $db;
    private $router;

    public function __construct()
    {
        $this->db = new Database();
        $this->router = new Router();
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


}
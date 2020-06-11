<?php
namespace Kernel;

class App
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function welcome()
    {
        echo 'Hello world.';
    }

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


}
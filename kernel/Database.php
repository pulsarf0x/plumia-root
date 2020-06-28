<?php
namespace Kernel;

class Database
{
    private $pdo;

    public function __construct()
    {
        $config = include 'config/database.php';

        $this->pdo = new \PDO('mysql:dbname=' . $config['dev']['name'] . ';host=' . $config['dev']['host'], $config['dev']['user'], $config['dev']['password']);
    }

    public function query($req)
    {
        return $this->pdo->query($req)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return \PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @param \PDO $pdo
     * @return Database
     */
    public function setPdo($pdo)
    {
        $this->pdo = $pdo;
        return $this;
    }
}
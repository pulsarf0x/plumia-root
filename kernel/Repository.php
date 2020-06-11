<?php


namespace Kernel;


abstract class Repository
{
    private $db;

    const TABLE = '';
    const ENTITY = '';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }
}
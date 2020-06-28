<?php
namespace Kernel;

abstract class Repository
{
    private $db;

    const TABLE = '';
    const ENTITY = '';

    public function __construct(Database $db)
    {
        $this->db = $db->getPdo();
    }

    public function findAll()
    {
        $q = $this->db->query('SELECT * FROM ' . static::TABLE);
        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::ENTITY);

        return $q->fetchAll();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $q = $this->findRequest($criteria, $orderBy, $limit, $offset);

        // Return result as array if entity not exists.
        if (empty(static::ENTITY))
            return $q->fetchAll(\PDO::FETCH_ASSOC);

        // Return result as entity object.
        return $q->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::ENTITY);
    }

    public function findOneBy(array $criteria)
    {
        $q = $this->findRequest($criteria, null, 1);

        // Return result as array if entity not exists.
        if (empty(static::ENTITY))
            return $q->fetch(\PDO::FETCH_ASSOC);

        // Return result as entity object.
        return $q->fetch(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::ENTITY);
    }

    public function find($id)
    {
        $id = (int) $id;

        $q = $this->db->prepare('SELECT * FROM ' . static::TABLE . ' WHERE id = :id');
        $q->bindParam(':id', $id, \PDO::PARAM_INT);
        $q->execute();

        if (empty(static::ENTITY))
            return $q->fetch(\PDO::FETCH_ASSOC);

        return $q->fetch(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::ENTITY);
    }

    public function findRequest(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $sql = 'SELECT * FROM ' . static::TABLE;

        // WHERE
        if (!empty($criteria))
        {
            $sql .= ' WHERE ';

            $criteria = count($criteria);
            $i = 1;

            foreach ($criteria as $param => $value):
                if ($i > 1)
                    $sql .= ' AND ';

                if (is_int($value)):
                    $sql .= $param . ' LIKE :' . $param;
                else:
                    $sql .= $param . ' = :' . $param;
                endif;

                $i++;
            endforeach;
        }

        // ORDER BY
        if (!empty($orderBy))
        {
            $sql .= ' ORDER BY ';

            $orderBy = new \CachingIterator(new \ArrayIterator($orderBy));

            foreach ($orderBy as $param => $value)
            {
                $sql .= $param . ' ' . $value;

                if ($orderBy->hasNext())
                    $sql .= ', ';
            }
        }

        if (!empty($limit))
            $sql .= ' LIMIT ' . $limit;

        $q = $this->db->prepare($sql);

        if (!empty($criteria))
        {
            foreach ($criteria as $param => $value)
                $q->bindValue(':' . $param, $value, is_int($value) ? \PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $q->execute();

        return $q;
    }
}
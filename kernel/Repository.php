<?php
namespace Kernel;

abstract class Repository
{
    /**
     * @var \PDO
     */
    private $db;

    const TABLE = '';
    const ENTITY = '';

    /**
     * Repository constructor.
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $q = $this->db->query('SELECT * FROM ' . static::TABLE);
        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::ENTITY);

        return $q->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::ENTITY);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $q = $this->findRequest($criteria, $orderBy, $limit, $offset);

        // Return result as array if entity not exists.
        if (empty(static::ENTITY))
            return $q->fetchAll(\PDO::FETCH_ASSOC);

        // Return result as entity object.
        return $q->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::ENTITY);
    }

    /**
     * @param array $criteria
     * @return mixed
     */
    public function findOneBy(array $criteria)
    {
        $q = $this->findRequest($criteria, null, 1);

        // Return result as array if entity not exists.
        if (empty(static::ENTITY))
            return $q->fetch(\PDO::FETCH_ASSOC);

        // Return result as entity object.
        return $q->fetch(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::ENTITY);
    }

    /**
     * @param $id
     * @return mixed
     */
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

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return bool|\PDOStatement
     */
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

    /**
     * @param Entity $entity
     * @return bool
     * Choose if create or update
     */
    public function save(Entity $entity)
    {
        if ($entity->isNew())
            $this->create($entity);
        else
            $this->update($entity);

        return true;
    }

    /**
     * @param Entity $entity
     * @return bool
     */
    public function create(Entity $entity)
    {
        $attrs = $entity->arraySerialize();
        unset($attrs['id']);

        $fields = [];
        foreach ($attrs as $key => $value)
            $fields[] = $key . ' = :' . $key;

        $sql = "INSERT INTO " . static::TABLE . " SET " . implode(', ', $fields);
        $q = $this->db->prepare($sql);

        foreach ($attrs as  $key => $value)
            $q->bindValue(':' . $key, $value);

        $q->execute();

        $entity->setId($this->db->lastInsertId());

        return true;
    }

    /**
     * @param Entity $entity
     * @return bool
     * Update an entity into the database
     */
    public function update(Entity $entity)
    {
        $fields = [];

        $attrs = $entity->arraySerialize();
        foreach ($attrs as $key => $value)
            if ($key != 'id' && $key != 'created_at')
                $fields[] = "$key = :$key";


        $sql = "UPDATE " . static::TABLE . " SET " . implode(', ', $fields) . " WHERE id = :id";
        $q = $this->db->prepare($sql);

        foreach ($attrs as $key => $value)
            if ($key != 'created_at')
                $q->bindValue(':' . $key, $value);

        $q->execute();

        return true;
    }
}
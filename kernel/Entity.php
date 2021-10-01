<?php


namespace Kernel;


abstract class Entity
{
    protected $id;

    public function __construct($values = [])
    {
        if (!empty($values))
            $this->set($values);
    }

    public function isNew()
    {
        return empty($this->id);
    }

    public function arraySerialize()
    {
        $array = [];

        foreach ($this as $attr => $value)
            $array[$attr] = $value;

        return $array;
    }

    public function jsonify()
    {
        return json_encode($this->arraySerialize());
    }

    public function set($values)
    {
        foreach ($values as $key => $value)
        {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

            $this->$method(trim($value));
        }

        return $this;
    }

    // Getters & Setters

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
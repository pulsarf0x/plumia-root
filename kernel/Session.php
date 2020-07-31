<?php


namespace Kernel;


class Session
{
    public function __construct()
    {
        session_start();
    }

    public function add($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function setFlash($type, $message)
    {
        $_SESSION['flash'] = array(
            'type' => $type,
            'message' => $message,
        );
    }

    public function getFlash($type = null)
    {
        if ($type)
            return $_SESSION['flash'][$type];

        return $_SESSION['flash'];
    }
}
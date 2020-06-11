<?php

use Kernel\Entity;

class User extends Entity
{
    private $email;
    private $password;
    private $nickname;
    private $firstname;
    private $lastname;
    private $birthdate;
    private $created_at;
}
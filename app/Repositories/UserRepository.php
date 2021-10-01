<?php

namespace App\Repositories;

use Kernel\Repository;
use App\Entities\User;

class UserRepository extends Repository
{
    const TABLE = 'user';
    const ENTITY = User::class;
}
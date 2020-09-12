<?php
use Kernel\Controller;
use App\Repositories\UserRepository;
use App\Entities\User;

class PublicController extends Controller
{
    public function index()
    {
        return $this->app->getResponse()
            ->setLayout('app')
            ->setView('index')
            ->render()
        ;
    }
}
<?php
use Kernel\Controller;
use App\Repositories\UserRepository;
use App\Entities\User;

class PublicController extends Controller
{
    public function index()
    {
        $rp = new UserRepository($this->app->getDb()->getPdo());
        $user = new User();
        $user->setEmail('pascal@plumia.net');
        $user->setPassword('password');
        $user->setFirstname('Pascal');
        $user->setNickname('PulsarFox');
        dump($user);
        $rp->save($user);
        $user->setNickname('xXxX--DaRkPaScAldu83--XxXx');
        dump($user);
        $rp->save($user);
        return $this->app->render('index');
    }
}
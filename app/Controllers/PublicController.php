<?php
use Kernel\Controller;

class PublicController extends Controller
{
    public function index()
    {
        return $this->app->render('index');
    }
}
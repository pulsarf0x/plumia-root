<?php
namespace Kernel;

abstract class Controller
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }
}
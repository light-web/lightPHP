<?php

namespace  zeni18\container\build;

abstract class ServiceProvider implements \zeni18\container\build\ServiceProviderInterface
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }
}

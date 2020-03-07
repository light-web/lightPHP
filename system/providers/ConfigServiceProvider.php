<?php

class ConfigServiceProvider extends \zeni18\container\build\ServiceProvider
{
    public function register()
    {
        $this->app->bind('config', function ($app) {
            $config = \zeni18\config\Config::single();
            $config->loadFiles(
                $app->get('path.config')
            );

            return $config;
        });
    }
}

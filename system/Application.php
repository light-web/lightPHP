<?php

namespace  zeni18\system;

use zeni18\container\Container;

class Application extends Container
{
    public $basePath;

    public $monologConfigurator;

    /**
     * Application constructor.
     *
     * @param null|mixed $basePath
     */
    public function __construct($basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }

        $this->registerBaseBindings();
        $this->registerBaseServiceProviders();

    }

    public function hasMonologConfigurator()
    {
        return !is_null($this->monologConfigurator);
    }

    /**
     * Get the custom Monolog configurator for the application.
     *
     * @return callable
     */
    public function getMonologConfigurator()
    {
        return $this->monologConfigurator;
    }

    public function registerBaseServiceProviders()
    {
        foreach (glob($this->systemPath('providers/*')) as $providerPath) {
            require_once $providerPath;

            $className = pathinfo($providerPath)['filename'];

            $this->register(new $className($this));
        }
    }

    public function registerBaseBindings()
    {
        $this->instance('app', $this);

        $this->instance(Container::class, $this);
    }

    /**
     * @param mixed $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;

        $this->defineDirPath();

        return  $this;
    }

    public function configureMonologUsing(callable $callback)
    {
        $this->monologConfigurator = $callback;

        return $this;
    }

    public function path($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'app'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function basePath($path = '')
    {
        return $this->basePath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function configPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'config'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function langPath($path = '')
    {
        return $this->storagePath().DIRECTORY_SEPARATOR.'lang'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function publicPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'public'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function storagePath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'storage'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function databasePath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'database'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function resourcePath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'resource'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function bootstrapPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'bootstrap'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function systemPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'system'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Bind all of the application paths in the container.
     */
    protected function defineDirPath()
    {
        $this->set('path', $this->path());
        $this->set('path.base', $this->basePath());
        $this->set('path.lang', $this->langPath());
        $this->set('path.config', $this->configPath());
        $this->set('path.public', $this->publicPath());
        $this->set('path.storage', $this->storagePath());
        $this->set('path.database', $this->databasePath());
        $this->set('path.resources', $this->resourcePath());
        $this->set('path.bootstrap', $this->bootstrapPath());
        $this->set('path.system', $this->systemPath());
    }
}

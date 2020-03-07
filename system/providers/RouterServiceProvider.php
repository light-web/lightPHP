<?php

class RouterServiceProvider extends \zeni18\container\build\ServiceProvider
{
    public function register()
    {
        $this->app->bind('router', function ($app) {
            return  new zeni18\router\Router(
                $this->createRouteCollector()
            );
        });
    }

    public function createRouteCollector()
    {
        //
        //
        // $options += [
        //     'routeParser' => 'FastRoute\\RouteParser\\Std',
        //     'dataGenerator' => 'FastRoute\\DataGenerator\\GroupCountBased',
        //     'dispatcher' => 'FastRoute\\Dispatcher\\GroupCountBased',
        //     'routeCollector' => 'FastRoute\\RouteCollector',
        // ];
        //
        // /** @var RouteCollector $routeCollector */
        // $routeCollector = new $options['routeCollector'](
        //     new $options['routeParser'], new $options['dataGenerator']
        // );
        // $routeDefinitionCallback($routeCollector);
        //
        // return new $options['dispatcher']($routeCollector->getData());

        return new \FastRoute\RouteCollector(
            new FastRoute\RouteParser\Std(),
            new \FastRoute\DataGenerator\GroupCountBased()
        );
    }
}

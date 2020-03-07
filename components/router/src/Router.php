<?php

namespace  zeni18\router;

use FastRoute\Dispatcher\GroupCountBased;
use FastRoute\RouteCollector;
use Symfony\Component\HttpFoundation\Response;
use zeni18\request\Request;

class Router
{
    public $routeParser;

    public $dataGenerator;

    public $dispatcher;
    public $collector;

    public $methods = [
        'GET',
        'POST',
        'PUT',
        'DELETE',
        'PATCH',
        'HEAD',
    ];

    public function __construct(RouteCollector $collector)
    {
        $this->collector = $collector;
    }

    public function __call($name, $arguments)
    {
        $action = strtoupper($name);
        if (in_array($action, $this->methods)) {
            return $this->addRoute($action, $arguments);
        }

        throw  new RouterException(sprintf('不支持的动作: %s', $name));
    }

    public function addRoute($action, $arguments)
    {
        $this->collector->addRoute($action, ...$arguments);
    }

    public function dispatch(Request $request)
    {
        $dispatcher = new GroupCountBased($this->collector->getData());

        return $this->runRoute($request, $dispatcher->dispatch($request->getMethod(), $request->getRequestUri()));
    }

    public function runRoute(Request $request, $route)
    {
        if (is_callable($route[1])) {
            $content = app()->callFunction($route[1]);
        } else {
            $action = explode('@', $route[1]);
            $controller = app()->config->get('app.controllerNameSpace').$action[0];

            $content = app()->callMethod($controller, $action[1]);
        }

        return (new Response())->setContent($content);
    }

    public function controllerDispatcher()
    {
        if (app()->bound(ControllerDispatcher::class)) {
            return app()->make(ControllerDispatcher::class);
        }

        return app()->get(ControllerDispatcher::class);
    }

    public function run()
    {
        return $this->controllerDispatcher()->dispatch(
            $this,
            $this->getController(),
            $this->getControllerMethod()
        );
    }

    /**
     * Get the controller instance for the route.
     *
     * @return mixed
     */
    public function getController()
    {
        if (!$this->controller) {
            $class = $this->parseControllerCallback()[0];

            $this->controller = $this->container->make(ltrim($class, '\\'));
        }

        return $this->controller;
    }

    /**
     * Checks whether the route's action is a controller.
     *
     * @return bool
     */
    protected function isControllerAction()
    {
        return is_string($this->action['uses']);
    }

    protected function runController()
    {
        return $this->controllerDispatcher()->dispatch(
            $this,
            $this->getController(),
            $this->getControllerMethod()
        );
    }
}

<?php

namespace  zeni18\system;


class HttpKernel implements KernelInterface
{
    public $app;

    public function bootstrap()
    {
        $this->app = app();
        $this->router = $this->app->router;

        $this->loadRoute();
    }

    public function loadRoute()
    {


        foreach (glob($this->app->basePath('router/*')) as $route) {

            require_once $route;
        }
    }

    public function handle($request)
    {
        try {
            $request->enableHttpMethodParameterOverride();

            $response = $this->sendRequestThroughRouter($request);
        } catch (\Exception $e) {
            throw  new \Exception($e->getMessage());
        }

        return $response;
    }

    public function terminate($request, $response)
    {
        // TODO: Implement terminate() method.
    }

    public function getApplication()
    {
        // TODO: Implement getApplication() method.
    }

    /**
     * Send the given request through the middleware / router.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendRequestThroughRouter($request)
    {
        $this->bootstrap();

        $this->app->instance('request', $request);

        return $this->router->dispatch($request)
        ;
    }

    /**
     * Get the route dispatcher callback.
     *
     * @return \Closure
     */
    protected function dispatchToRouter()
    {
        return function ($request) {
            $this->app->instance('request', $request);

            return $this->router->dispatch($request);
        };
    }
}

<?php

if (!function_exists('app')) {
    function app($abstract = null)
    {
        if (is_null($abstract)) {
            return \zeni18\system\Application::single()->make('app');
        }

        return \zeni18\system\Application::single()->make('app')->make($abstract);
    }
}

if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param mixed $args
     */
    function dd(...$args)
    {
        http_response_code(500);

        foreach ($args as $x) {
            (new \zeni18\support\Debug\Dumper())->dump($x);
        }
    }
}

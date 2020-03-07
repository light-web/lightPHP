<?php

namespace zeni18\request\build;

use Symfony\Component\HttpFoundation\Request;

class Core extends Request
{
    public function capture()
    {
        static::enableHttpMethodParameterOverride();

        return static::createFromGlobals();
    }

    /**
     * Get the request method.
     *
     * @return string
     */
    public function method()
    {
        return $this->getMethod();
    }

    /**
     * Return the Request instance.
     *
     * @return $this
     */
    public function instance()
    {
        return $this;
    }
}

<?php

namespace  zeni18\request;

/**
 * Class Request.
 */
class Request extends \Symfony\Component\HttpFoundation\Request
{
    public static function capture()
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

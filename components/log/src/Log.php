<?php
/**
 * This file is part of the zeni18.
 *
 * (c) zeni18 <hi.zero.im@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace  zeni18\log;

use Monolog\Logger;
use zeni18\log\build\Writer;

class Log
{
    //连接的驱动
    /**
     * @var null
     */
    protected static $link = null;

    /**
     * 类静态方法调用.
     *
     * @param $name
     * @param $arguments
     * @param mixed $method
     *
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        return call_user_func_array([static::single(), $method], $arguments);
    }

    /**
     * 实例调用方法.
     *
     * @param $name
     * @param $arguments
     * @param mixed $method
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([static::single(), $method], $arguments);
    }

    /**
     * 单例化.
     */
    public static function single()
    {
        if (is_null(static::$link)) {
            static::$link = new  Writer(new Logger('lightPHP'));
        }

        return static::$link;
    }
}

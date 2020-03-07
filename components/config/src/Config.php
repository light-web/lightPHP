<?php

/**
 * This file is part of the overtrue/wechat.
 *
 * (c) zeni18 <hi.zero.im@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace zeni18\config;

use zeni18\config\build\Core;

/**
 * Class Config.
 */
class Config
{
    /**
     * @var null
     */
    public static $link = null;

    /**
     * @param $method
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([self::single(), $method], $arguments);
    }

    /**
     * @param $method
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        return call_user_func_array([self::single(), $method], $arguments);
    }

    /**
     * @return null|Core
     */
    public static function single()
    {
        if (is_null(self::$link)) {
            self::$link = new Core();
        }

        return self::$link;
    }
}

<?php

class Container
{
    public static $link = null;

    public function __call($name, $arguments)
    {
        return call_user_func_array([static::single(), $name], $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([static::single(), $name], $arguments);
    }

    public function single()
    {
        if (is_null(static::$link)) {
            static::$link = new static();
        }

        return static::$link;
    }

    private function show(){
        echo "mgs";
    }
}

class Foo extends Container{


}


$foo = new Foo();


$foo->show();


var_dump($foo::$link);


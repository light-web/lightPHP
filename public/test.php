<?php

require_once __DIR__.'/../vendor/autoload.php';

/**
 * @internal
 * @coversNothing
 */
class Test
{
    public function hello()
    {
        echo 'hello';
    }
}

$app = new \DI\Container();

//$app->set('test', \DI\create(Test::class));

//var_dump($app->get('test')->hello());



$app->make("Test");

($app->get('test')->hello());

var_dump("hah"->get_class());



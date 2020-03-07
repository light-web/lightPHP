<?php

$app = app();

$app->router->get('/', 'HomeController@index');

$app->router->get('/test', function () {
    return 'closure test';
});

<?php

require_once __DIR__.'/../bootstrap/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->get(\light\Http\Kernel::class);

$response = $kernel->handle(
    \zeni18\request\Request::capture()
);



$response->send();

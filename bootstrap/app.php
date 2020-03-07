<?php

$app = new \zeni18\system\Application(
    realpath(__DIR__.'/../')
);

$app->make(\light\Http\Kernel::class, \light\Http\Kernel::class, true);

return $app;

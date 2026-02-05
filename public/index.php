<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get the Laravel application instance. This is pulled
| in from the bootstrap file. Then we determine if the request should go
| to the application HTTP kernel or the console kernel for this app.
|
*/

$autoload = __DIR__.'/../vendor/autoload.php';
if (! file_exists($autoload)) {
    fwrite(STDERR, "Composer autoload file not found. Run 'composer install'.\n");
    exit(1);
}
require $autoload;

$app = require __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the HTTP kernel. This bootstrap file doesn't need to load
| your full configuration since we're just firing off the request
| handlers which loads all of this information on demand.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);

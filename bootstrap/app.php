<?php

//Optional (if not set the default c3 output dir will be used)
$basePath = $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__);

//Add the C3 file so that we can run Codeception remotely
if (!defined('C3_CODECOVERAGE_ERROR_LOG_FILE')) {
    define('C3_CODECOVERAGE_ERROR_LOG_FILE', '../storage/logs/c3_error.log');
}
$appEnv = (key_exists('APP_ENV', $_ENV)) ? $_ENV['APP_ENV']  : 'production';
if ($appEnv === 'local') {
    include $basePath . '/c3.php';
}
    /*
    |--------------------------------------------------------------------------
    | Create The Application
    |--------------------------------------------------------------------------
    |
    | The first thing we will do is create a new Laravel application instance
    | which serves as the "glue" for all the components of Laravel, and is
    | the IoC container for the system binding all of the various parts.
    |
    */

    $app = new Illuminate\Foundation\Application($basePath);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    Bank\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Bank\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    Bank\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;

<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Exceptions\Api\ValidationApiException;
use App\Http\Resources\Api\Message\InvalidMessageResource;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api_v1.php',
        apiPrefix: 'api/v1',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationApiException $e) {
            return new InvalidMessageResource($e->validator->errors()->toArray(), 400);
        });
    })->create();

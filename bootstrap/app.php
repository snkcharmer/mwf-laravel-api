<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (
            ModelNotFoundException|NotFoundHttpException $e,
            Request $request
        ) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status'  => 404,
                    'message' => 'Resource not found',
                ], 404);
            }
        });
        // $exceptions->renderable(function (NotFoundHttpException $e) {
        //     // Custom JSON response for 404 errors, including model not found
        //     $message = 'Record not found.';
        //     $previous = $e->getPrevious();

        //     if (str_contains($e->getMessage(), 'The route') && str_contains($e->getMessage(), 'could not be found')) {
        //         $message = 'The requested route could not be found.';
        //     }
        //     if ($previous instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
        //         $model = class_basename($previous->getModel());
        //         $message = $model . ' not found.';
        //     }
        //     return response()->json([
        //         'message' => $message
        //     ], 404);
        // });
        // $exceptions->renderable(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        //     // Custom JSON response for model not found
        //     $model = class_basename($e->getModel());
        //     return response()->json([
        //         'message' => $model . ' not found.'
        //     ], 404);
        // });
        // $exceptions->renderable(function (\Illuminate\Validation\ValidationException $e) {
        //     // Custom JSON response for validation errors
        //     return response()->json([
        //         'message' => 'Validation failed.',
        //         'errors' => $e->errors()
        //     ], 422);
        // });
        // $exceptions->renderable(function (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
        //     // Custom JSON response for generic HTTP exceptions
        //     return response()->json([
        //         'message' => $e->getMessage() ?: 'HTTP error.'
        //     ], $e->getStatusCode() ?: 500);
        // });
        // $exceptions->renderable(function (\Exception $e) {
        //     return response()->json([
        //         'message' => $e->getMessage()
        //     ], 500);
        // });

    })->create();

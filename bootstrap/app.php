<?php

use App\Http\Middleware\CheckApiKey;
use App\Http\Middleware\returnAccountUser;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\checkAdmin;
 




return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php', // ✅ Thêm dòng này
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'checkApiKey' => CheckApiKey::class, // ✅ Thêm middleware vào đây
            'checkAdmin' => CheckAdmin::class,
            'returnAccountUser' => returnAccountUser::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

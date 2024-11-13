<?php

use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;

// Создание нового приложения
$app = new Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

// Настройка маршрутов
$app->withRouting(function (Router $router) {
    $router->group(['namespace' => 'App\Http\Controllers'], function () {
        require __DIR__.'/../routes/web.php';
        require __DIR__.'/../routes/console.php';
    });
});

// Настройка промежуточного ПО
$app->withMiddleware(function (Middleware $middleware) {
    // Ваше промежуточное ПО
});

// Обработка исключений
$app->withExceptions(function (Exceptions $exceptions) {
    // Ваши обработчики исключений
});

return $app;

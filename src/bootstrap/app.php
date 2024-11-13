use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;

$app = new Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

// Подключаем маршруты
require __DIR__.'/../routes/web.php';
require __DIR__.'/../routes/console.php';

// Можно также настроить группу маршрутов, если нужно
$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
    require __DIR__.'/../routes/console.php';
});

return $app;

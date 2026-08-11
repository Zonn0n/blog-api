<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

final class RouteHelper
{
    public static function loadRoutes(string $directory, string $prefix, array $middlewares = []): void
    {
        $routeDir = base_path($directory);
        Route::group([
            'prefix' => $prefix,
            'middleware' => $middlewares,
        ], function () use ($routeDir) {
            foreach (File::allFiles($routeDir) as $routeFile) {
                require $routeFile->getPathname();
            }
        });
    }
}

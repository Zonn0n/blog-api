<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Blog API',
    version: '1.0.0',
)]
#[OA\Server(url: '/api')]
#[OA\SecurityScheme(
    type: 'http',
    scheme: 'bearer',
    securityScheme: 'sanctum',
)]
abstract class Controller
{
    //
}

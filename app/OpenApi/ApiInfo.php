<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'API Tienda',
    description: 'API REST para la gestión de productos'
)]
#[OA\Server(
    url: 'http://127.0.0.1:8000/api',
    description: 'Servidor local'
)]
class ApiInfo
{
}
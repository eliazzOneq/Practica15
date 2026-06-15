<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController as AuthControllerV1;
use App\Http\Controllers\Api\V1\CategoriaController as CategoriaControllerV1;
use App\Http\Controllers\Api\V1\PedidoController as PedidoControllerV1;
use App\Http\Controllers\Api\V1\ProductoController as ProductoControllerV1;

use App\Http\Controllers\Api\V2\ProductoController as ProductoControllerV2;

Route::prefix('v1')
    ->name('v1.')
    ->group(function () {

        Route::post('/register', [AuthControllerV1::class, 'register']);
        Route::post('/login', [AuthControllerV1::class, 'login']);

        Route::middleware('auth:sanctum')
            ->get('/me', [AuthControllerV1::class, 'me']);

        Route::middleware('auth:sanctum')
            ->post('/logout', [AuthControllerV1::class, 'logout']);

        Route::apiResource('categorias', CategoriaControllerV1::class);

        Route::get(
            'categorias/{categoria}/productos',
            [CategoriaControllerV1::class, 'productos']
        );

        Route::apiResource('productos', ProductoControllerV1::class)
            ->middleware('auth:sanctum');

        Route::post('/pedidos', PedidoControllerV1::class)
            ->middleware('auth:sanctum');
});

Route::prefix('v2')
    ->name('v2.')
    ->group(function () {

    Route::apiResource('productos', ProductoControllerV2::class)
        ->middleware('auth:sanctum');
});
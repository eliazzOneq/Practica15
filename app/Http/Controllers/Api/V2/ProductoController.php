<?php

namespace App\Http\Controllers\Api\V2;

use OpenApi\Attributes as OA;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\ProductoController as V1ProductoController;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends V1ProductoController
{
    #[OA\Get(
        path: '/api/v2/productos',
        summary: 'Listado de productos con búsqueda full-text',
        tags: ['Productos V2']
    )]
    #[OA\Parameter(
        name: 'q',
        in: 'query',
        required: false,
        description: 'Texto para búsqueda full-text'
    )]
    #[OA\Response(
        response: 200,
        description: 'Listado obtenido'
    )]
    public function index(Request $request)
    {
        $query = Producto::with('categoria');

        if ($request->q) {
            $query->whereFullText(['nombre','descripcion'], $request->q);
        }

        return $query->paginate(15);
    }
}

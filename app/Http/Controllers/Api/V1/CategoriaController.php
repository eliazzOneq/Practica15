<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Resources\CategoriaResource;
use App\Http\Resources\ProductoResource;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Cache::remember(
            'categorias.todas',
            3600,
            function () {
                return Categoria::with('productos')->get();
            }
        );

        return CategoriaResource::collection($categorias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        //
    }

    public function productos(Categoria $categoria)
    {
        return ProductoResource::collection(
            $categoria->productos()->with('categoria')->get()
        );
    }
}

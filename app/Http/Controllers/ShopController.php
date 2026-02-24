<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Taxonomy;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->where('is_active', 1); // solo productos activos

        /*
        |--------------------------------------------------------------------------
        | 🔎 BÚSQUEDA
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | 📂 FILTRO POR CATEGORÍA
        |--------------------------------------------------------------------------
        */
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 💰 FILTRO POR PRECIO
        |--------------------------------------------------------------------------
        */
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        /*
        |--------------------------------------------------------------------------
        | ↕ ORDENAMIENTO
        |--------------------------------------------------------------------------
        */
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;

            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;

            case 'latest':
                $query->latest();
                break;

            default:
                $query->latest();
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | 📦 PAGINACIÓN
        |--------------------------------------------------------------------------
        */
        $products = $query->paginate(12)->withQueryString();

        $categories = Taxonomy::where('is_active', 1)->get();

        return view('shop.index', compact('products', 'categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | 📂 TIENDA POR CATEGORÍA (opcional)
    |--------------------------------------------------------------------------
    */
    public function category($slug)
    {
        $products = Product::whereHas('taxonomy', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->where('is_active', 1)
            ->paginate(12);

        $categories = Taxonomy::where('is_active', 1)->get();

        return view('shop.index', compact('products', 'categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | 📄 DETALLE DE PRODUCTO
    |--------------------------------------------------------------------------
    */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return view('shop.show', compact('product'));
    }
}

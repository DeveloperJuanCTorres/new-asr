<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('shop.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1,
                "image" => json_decode($product->images, true)[0] ?? null,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart_count' => count($cart)
        ]);
    }

    public function mini()
    {
        $cart = session()->get('cart', []);
        return view('shop.partials.mini_cart_items', compact('cart'));
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])){
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'cart_count' => count($cart)
        ]);
    }

    public function clear()
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'cart_count' => 0
        ]);
    }
}

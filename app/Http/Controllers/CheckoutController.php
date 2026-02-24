<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')
                ->with('error', 'Tu carrito está vacío');
        }

        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('shop.checkout', compact('cart', 'subtotal'));
    }

    /*
    |--------------------------------------------------------------------------
    | Guardar Pedido
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'department' => 'required|string'
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')
                ->with('error', 'Carrito vacío');
        }

        /*
        |--------------------------------------------------------------------------
        | Calcular Subtotal
        |--------------------------------------------------------------------------
        */
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        /*
        |--------------------------------------------------------------------------
        | Cálculo de Envío (simple)
        |--------------------------------------------------------------------------
        */
        $shipping = $request->department === "Lima" ? 10 : 20;

        $total = $subtotal + $shipping;

        /*
        |--------------------------------------------------------------------------
        | Crear Pedido
        |--------------------------------------------------------------------------
        */
        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $total,
            'status' => 'pendiente'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Guardar Detalle del Pedido
        |--------------------------------------------------------------------------
        */
        foreach ($cart as $productId => $item) {

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity']
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Limpiar carrito
        |--------------------------------------------------------------------------
        */
        session()->forget('cart');

        return redirect()->route('home')
            ->with('success', 'Pedido generado correctamente. Nos contactaremos contigo.');
    }
}

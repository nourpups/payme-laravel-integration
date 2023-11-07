<?php

namespace App\Http\Controllers;

use App\Enum\Order\State;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{

    public function index()
    {
        return view('cart.index', [
            'cart' => session('cart'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add(Product $product)
    {
        $cart = session('cart', new Order());

        if (isset($cart->products[$product->id])) {
            // $cart[$product->id]['count']++ === "Indirect modification of overloaded element of App\Models\Order has no effect" ERROR
            $product = $cart->products[$product->id];

            $cart->products[$product->id]['count'] += 1;
        } else {

            $product->status = State::CART;
            $product['count'] = 1;
            $cart->products[$product->id] = $product;
        }

        $cart->amount += $product->price;
        session()->put('cart', $cart);

        return to_route('products.show', compact('product'))
            ->with('flash', [
                'class' => 'green',
                'message' => 'Product added to cart successfully!'
            ]);
    }

    public function update(Request $request)
    {
        $cart = session('cart');

        $product = $cart->products[$request->product_id];
        if ($request->count > $product['count']) { // if it is incrementing
            $cart['amount'] += $product->price;
        }
        if ($request->count < $product['count']) { // if it is decrementing
            $cart['amount'] -= $product->price;
        }
        $product['count'] = $request->count;

        session()->put('cart', $cart);

        session()->flash('flash', [
            'class' => 'green',
            'message' => 'Product updated successfully!'
        ]);
    }

    public function store()
    {
        $order = session('cart');

        $order->user_id = auth()->id();
        $order->status = State::PENDING;

        $order->save();

        foreach ($order->products as $product) {
            $order->products()->attach(
                $product->id,
                [
                    'count' => $product['count'],
                ]
            );
        }

        Http::post('https://test.paycom.uz', [
            'merchant' => config('payme.merchant_id'),
            'amount' => $order->amount * 100, // sum to tiyin
            'account' => [
                config('payme.identity') => $order->fresh()->id
            ]
        ]);
        session()->forget('cart');
    }

    public function destroy(Request $request)
    {
        $cart = session('cart');

        $product = $cart->products[$request['product_id']];
        $cart->amount -= ($product->price * $product->count);
        $cart->products->forget($product->id);

        session()->put('cart', $cart);

        session()->flash('flash', [
            'class' => 'red',
            'message' => 'Product deleted from cart!'
        ]);
    }

}

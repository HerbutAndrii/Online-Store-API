<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() {
        $products = auth()->user()->productsInCart;

        return ProductResource::collection($products);
    }

    public function store(Request $request, Product $product) {
        if($request->user()->productsInCart()->where('product_id', $product->id)->exists()) {
            return response()->json(['message' => 'The Product is already in the cart']);
        }

        $request->user()->productsInCart()->attach($product);

        return response()->json(['message' => 'Product was added to cart successfully']);
    }

    public function destroy(Request $request, Product $product) {
        if($product = $request->user()->productsInCart()->where('product_id', $product->id)->first()) {
            $request->user()->productsInCart()->detach($product);

            return response()->json(['message' => 'Product was removed from cart successfully']);
        }

        return response()->json(['message' => 'Product not in cart']);
    }
}

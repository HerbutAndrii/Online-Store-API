<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        return ProductResource::collection(Product::orderByDesc('rate')->get());
    }

    public function show(Product $product) {
        return new ProductResource($product);
    }

    public function store(ProductRequest $request) {
        $product = new Product($request->only('name', 'description'));
        $product->company()->associate($request->company);
        $product->category()->associate($request->category);
        $product->save();

        return [
            'status' => 'Product was created successfully',
            'product' => new ProductResource($product)
        ];
    }

    public function update(ProductRequest $request, Product $product) {
        $product->fill($request->only('name', 'description'));
        $product->company()->associate($request->company);
        $product->category()->associate($request->category);
        $product->save();

        return [
            'status' => 'Product was updated successfully',
            'product' => new ProductResource($product)
        ];
    }

    public function destroy(Product $product) {
        $product->delete();

        return ['status' => 'Product was deleted successfully'];
    }
}

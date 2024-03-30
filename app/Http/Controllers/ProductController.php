<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        $products = Product::with('company', 'category')->orderByDesc('rate')->get();

        return ProductResource::collection($products);
    }

    public function show(Product $product) {
        return new ProductResource($product->load('company', 'category'));
    }

    public function store(StoreProductRequest $request) {
        $product = new Product($request->only('name', 'description', 'price'));
        $product->user()->associate($request->user());
        $product->company()->associate($request->company);
        $product->category()->associate($request->category);
        $product->save();

        return [
            'message' => 'Product was created successfully',
            'product' => new ProductResource($product->load('company', 'category'))
        ];
    }

    public function update(UpdateProductRequest $request, Product $product) {
        $this->authorize('update', $product);

        $data = $request->only('name', 'description', 'price');
        if(! empty(array_filter($data))) {
            $product->fill($data);
        }
        
        $product->company()->associate($request->company ?? $product->company);
        $product->category()->associate($request->category ?? $product->category);
        
        $product->save();
        
        return [
            'message' => 'Product was updated successfully',
            'product' => new ProductResource($product->load('company', 'category'))
        ];
    }

    public function destroy(Product $product) {
        $this->authorize('delete', $product);

        $product->delete();

        return ['message' => 'Product was deleted successfully'];
    }
}

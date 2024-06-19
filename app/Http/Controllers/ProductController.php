<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index() {
        $products = Cache::remember('products', 60, function () {
            return Product::with('company', 'category', 'tags')->orderByDesc('rate')->get();
        });

        return ProductResource::collection($products);
    }

    public function show(Product $product) {
        return new ProductResource($product->load('company', 'category', 'tags'));
    }

    public function store(StoreProductRequest $request) {
        $product = new Product($request->validated());
        $product->user()->associate($request->user());
        $product->save();

        if($request->has('tags')) {
            $product->tags()->attach($request->tags);
        }

        return [
            'message' => 'Product was created successfully',
            'product' => new ProductResource($product->load('company', 'category', 'tags'))
        ];
    }

    public function update(UpdateProductRequest $request, Product $product) {
        $this->authorize('update', $product);

        if(! empty(array_filter($request->validated()))) {
            $product->update($request->validated());
        }
        
        if($request->has('tags')) {
            $product->tags()->sync($request->tags);
        }
        
        return [
            'message' => 'Product was updated successfully',
            'product' => new ProductResource($product->load('company', 'category', 'tags'))
        ];
    }

    public function destroy(Product $product) {
        $this->authorize('delete', $product);

        $product->delete();

        return ['message' => 'Product was deleted successfully'];
    }
}

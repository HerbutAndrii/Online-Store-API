<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::with('products')->orderByDesc('updated_at')->get();

        return CategoryResource::collection($categories);
    }

    public function show(Category $category) {
        return new CategoryResource($category->load('products'));
    }

    public function store(StoreCategoryRequest $request) {
        $category = new Category(['name' => $request->name]);
        $category->user()->associate($request->user());
        $category->save();

        return [
            'message' => 'Category was created successfully',
            'category' => new CategoryResource($category)
        ];
    }

    public function update(UpdateCategoryRequest $request, Category $category) {
        $this->authorize('update', $category);

        $category->update(['name' => $request->name ?? $category->name]);

        return [
            'message' => 'Category was updated successfully',
            'category' => new CategoryResource($category->load('products'))
        ];
    }

    public function destroy(Category $category) {
        $this->authorize('delete', $category);

        $category->delete();

        return ['message' => 'Category was deleted successfully'];
    }
}

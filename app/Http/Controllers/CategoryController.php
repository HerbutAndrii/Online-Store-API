<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        return CategoryResource::collection(Category::orderByDesc('updated_at')->get());
    }

    public function show(Category $category) {
        return new CategoryResource($category);
    }

    public function store(CategoryRequest $request) {
        $category = Category::create(['name' => $request->name]);

        return [
            'status' => 'Category was created successfully',
            'category' => new CategoryResource($category)
        ];
    }

    public function update(CategoryRequest $request, Category $category) {
        $category->update(['name' => $request->name]);

        return [
            'status' => 'Category was updated successfully',
            'category' => new CategoryResource($category)
        ];
    }

    public function destroy(Category $category) {
        $category->delete();

        return ['status' => 'Category was deleted successfully'];
    }
}

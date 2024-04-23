<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewStoreRequest;
use App\Http\Requests\ReviewUpdateRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Cache;

class ReviewController extends Controller
{
    public function index(Product $product) {
        $reviews = Cache::remember('reviews', 60, function () use ($product) {
            return Review::with('product', 'user')
                ->where('product_id', $product->id)
                ->orderByDesc('updated_at')
                ->get();
        });
        
        return ReviewResource::collection($reviews);
    }

    public function store(ReviewStoreRequest $request, Product $product) {
        $review = new Review($request->validated());
        $review->product()->associate($product);
        $review->user()->associate($request->user());
        $review->save();

        return response()->json([
            'message' => 'Review was created successfully',
            'review' => new ReviewResource($review->load('product', 'user'))
        ]);
    }

    public function update(ReviewUpdateRequest $request, Review $review) {
        $this->authorize('update', $review);

        $review->update(['content' => $request->content ?? $review->content]);

        return response()->json([
            'message' => 'Review was updated successfully',
            'review' => new ReviewResource($review->load('product', 'user'))
        ]);
    }

    public function destroy(Review $review) {
        $this->authorize('delete', $review);

        $review->delete();

        return response()->json(['message' => 'Review was deleted successfully']);
    }
}

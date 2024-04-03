<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function create(RatingRequest $request, Product $product) {
        if($rate = $product->ratings()->where('user_id', $request->user()->id)) {
            $rate->delete();
        }

        Rating::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'rate' => $request->rate
        ]);

        $product->update(['rate' => $product->ratings()->avg('rate')]);

        return response()->json(['message' => 'Product was rated successfully']);
    }

    public function destroy(Request $request, Product $product) {
        if($rate = $product->ratings()->where('user_id', $request->user()->id)) {
            $rate->delete();

            return response()->json(['message' => 'Rating was deleted successfully']);
        }

        return response()->json(['message' => 'You do not have a rating for this product']);

    }
}

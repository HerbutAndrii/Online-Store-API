<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountStoreRequest;
use App\Http\Requests\DiscountUpdateRequest;
use App\Http\Resources\DiscountResource;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function index() {
        $discounts = Discount::all();

        return DiscountResource::collection($discounts);
    }

    public function store(DiscountStoreRequest $request) {
        Discount::create($request->validated());

        return response()->json(['message' => 'Discount was created successfully']);
    } 

    public function update(DiscountUpdateRequest $request, Discount $discount) {
        if(! empty(array_filter($request->validated()))) {
            $discount->update($request->validated());
        }

        return response()->json(['message' => 'Discount was updated successfully']);
    }

    public function destroy(Discount $discount) {
        $discount->delete();

        return response()->json(['message' => 'Discount was deleted successfully']);
    }
}

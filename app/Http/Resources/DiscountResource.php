<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'percentage' => $this->percentage,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => (string) $this->updated_at  
        ];
    }
}

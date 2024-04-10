<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'content' => $this->content,
            'product' => new ProductResource($this->whenLoaded('product')),
            'owner' => new UserResource($this->whenLoaded('user')),
            'publication_date' => (string) $this->updated_at,
        ];
    }
}

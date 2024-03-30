<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'owner' => $this->when($request->user()->isAdmin(), new UserResource($this->user)),
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'publication_date' => (string) $this->updated_at
        ];
    }
}

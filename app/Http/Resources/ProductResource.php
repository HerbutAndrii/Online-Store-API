<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'price' => $this->price . '$',
            'rate' => $this->rate,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'owner' => $this->when($request->user()->isAdmin(), new UserResource($this->user)),
            'publication_date' => (string) $this->updated_at
        ];
    }
}

<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\v1\PropertyAddressResource;
use App\Http\Resources\v1\UserResource;
use App\Http\Resources\v1\PropertyStatusResource;

class PropertyResource extends JsonResource
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
            'slug' => $this->slug,
            'address' => $this->whenLoaded('address', function() {
                return new PropertyAddressResource($this->address);
            }),
            'owner' => $this->whenLoaded('owner', function() {
                return new UserResource($this->owner);
            }),
            'status' => $this->whenLoaded('status', function() {
                return new PropertyStatusResource($this->status);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

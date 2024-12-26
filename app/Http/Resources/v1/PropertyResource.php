<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\v1\PropertyAddressResource;
use App\Http\Resources\v1\UserResource;

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
            'id' => $this->whenHas('id'),
            'name' => $this->whenHas('name'),
            'slug' => $this->whenHas('slug'),
            'owner_id' => $this->whenHas('owner_id'),
            'status_id' => $this->whenHas('status_id'),
            'created_at' => $this->whenHas('created_at'),
            'updated_at' => $this->whenHas('updated_at'),
            'address' => $this->whenLoaded('address', function() {
                return new PropertyAddressResource($this->address);
            }),
            'owner' => $this->whenLoaded('owner', function() {
                return new UserResource($this->owner);
            })
        ];
    }
}

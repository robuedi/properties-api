<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\v1\CityResource;

class PropertyAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'city_id' => $this->city_id,
            'city' => $this->whenLoaded('city', function() {
                return new CityResource($this->city);
            }),
            'address_line' => $this->address_line,
        ];
    }
}
